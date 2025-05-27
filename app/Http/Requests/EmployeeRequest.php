<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json([
        'success' => false,
        'message' => 'Validation Error',
        'errors'  => $validator->errors()
    ], 422));
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
        'first_name' => 'required|string|max:100',
        'last_name'  => 'required|string|max:100',
      'email'      => [
            'required',
            'email',
            Rule::unique('employees')->ignore($this->employee_id, 'employee_id'),
        ],
        'phone'      => [
            'required',
            Rule::unique('employees')->ignore($this->employee_id, 'employee_id'),
        ],
    ];
    }
}
