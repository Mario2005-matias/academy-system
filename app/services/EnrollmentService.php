<?php

namespace App\Services;

use App\Models\Enrollment;
use Illuminate\Validation\ValidationException;

class EnrollmentService
{
    public function paginate()
    {
        return Enrollment::with(['student', 'plan'])
            ->latest()
            ->paginate(15);
    }

    public function create(array $data): Enrollment
    {
        $this->ensureNoActiveEnrollment($data['student_id'], $data['plan_id']);

        return Enrollment::create($data);
    }

    public function update(Enrollment $enrollment, array $data): Enrollment
    {
        $enrollment->fill($data);
        $enrollment->save();

        return $enrollment;
    }

    protected function ensureNoActiveEnrollment(int $studentId, int $planId): void
    {
        $exists = Enrollment::where('student_id', $studentId)
            ->where('plan_id', $planId)
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'plan_id' => 'Este aluno já tem uma matrícula activa neste plano.',
            ]);
        }
    }
}
