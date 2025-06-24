<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => [
                'required',
                'string',
                'max:20',
                'unique:employees,employee_id'
            ],
            'employee_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'gender' => [
                'required',
                'string',
                Rule::in(['Male', 'Female', 'Other', 'Prefer not to say'])
            ],
            'marital_status' => [
                'required',
                'string',
                Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
            ],
            'phone_no' => [
                'required',
                'string',
                'regex:/^[\+]?[1-9][\d]{0,15}$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:employees,email'
            ],
            'address' => [
                'required',
                'string',
                'max:500'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:-16 years',
                'after:1900-01-01'
            ],
            'nationality' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'hire_date' => [
                'required',
                'date',
                'before_or_equal:today',
                'after:date_of_birth'
            ],
            'department' => [
                'required',
                'string',
                Rule::in([
                    'Human Resources',
                    'Information Technology',
                    'Finance',
                    'Marketing',
                    'Sales',
                    'Operations',
                    'Customer Service',
                    'Research & Development'
                ])
            ],
            'position' => [
                'required',
                'string',
                'max:100'
            ],
            'salary' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.unique' => 'This employee ID is already taken.',
            'employee_name.regex' => 'Employee name should only contain letters, spaces, hyphens, apostrophes, and periods.',
            'phone_no.regex' => 'Please enter a valid phone number.',
            'email.unique' => 'This email address is already registered.',
            'date_of_birth.before' => 'Employee must be at least 16 years old.',
            'date_of_birth.after' => 'Please enter a valid date of birth.',
            'hire_date.before_or_equal' => 'Hire date cannot be in the future.',
            'hire_date.after' => 'Hire date must be after date of birth.',
            'nationality.regex' => 'Nationality should only contain letters, spaces, hyphens, apostrophes, and periods.'
        ];
    }
}
