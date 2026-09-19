<?php

namespace App\Http\Requests\Enrollements;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnrollmentRequest extends FormRequest
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
            'start_date'     => ['sometimes', 'date'],
            'end_date'       => ['sometimes', 'date', 'after:start_date'],
            'value_paid'     => ['sometimes', 'numeric', 'min:0'],
            'status'         => ['sometimes', Rule::in(['active', 'completed', 'cancelled'])],
            'status_payment' => ['sometimes', Rule::in(['paid', 'unpaid'])],
        ];
    }
}
