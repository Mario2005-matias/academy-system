<?php

namespace App\Http\Requests\Payments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "enrollment_id" => "required|exists:enrollments,id",
            "payment_method" => "required|string|in:TPA,Transferencia,Express",
            "payment_date" => "required|date",
            "value" => "required|numeric|min:0",
            "idempontency-key" => ['required', 'uuid', 'unique:payments,idempotency_key']
        ];
    }
}
