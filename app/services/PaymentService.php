<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function create(array $data)
    {
        $enrollment = Enrollment::findOrFail($data['enrollment_id']);

        $this->ensureValueDoesNotExceedBalance($enrollment, $data['value']);

        return DB::transaction(function () use ($enrollment, $data) {
            $payment = Payment::create($data);

            $this->refreshEnrollmentPaymentStatus($enrollment);

            return $payment;
        });
    }

    protected function ensureValueDoesNotExceedBalance(Enrollment $enrollment, float $value): void
    {
        $remaining = $this->remainingBalance($enrollment);

        if ($value > $remaining) {
            throw ValidationException::withMessages([
                'value' => "O valor excede o saldo em falta ({$remaining}).",
            ]);
        }
    }

    protected function remainingBalance(Enrollment $enrollment): float
    {
        $totalPaid = $enrollment->payments()->sum('value');

        return (float) $enrollment->value_paid - (float) $totalPaid;
    }

    protected function refreshEnrollmentPaymentStatus(Enrollment $enrollment): void
    {
        $remaining = $this->remainingBalance($enrollment);

        $enrollment->update([
            'status_payment' => $remaining <= 0 ? 'paid' : 'unpaid',
        ]);
    }
}
