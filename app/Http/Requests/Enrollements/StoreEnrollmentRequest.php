<?php

namespace App\Http\Requests\Enrollements;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnrollmentRequest extends FormRequest
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
            'student_id'     => ['required', 'exists:students,id'],
            'plan_id'        => ['required', 'exists:plans,id'],
            'start_date'     => ['required', 'date'],
            'end_date'       => ['required', 'date', 'after:start_date'],
            'value_paid'     => ['required', 'numeric', 'min:0'],
            'status'         => ['sometimes', Rule::in(['active', 'completed', 'cancelled'])],
            'status_payment' => ['sometimes', Rule::in(['paid', 'unpaid'])],
        ];
    }
}
