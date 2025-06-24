<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')->id;

        return [
            'employee_id' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('employees', 'employee_id')->ignore($employeeId)
            ],
            'employee_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'gender' => [
                'sometimes',
                'required',
                'string',
                Rule::in(['Male', 'Female', 'Other', 'Prefer not to say'])
            ],
            'marital_status' => [
                'sometimes',
                'required',
                'string',
                Rule::in(['Single', 'Married', 'Divorced', 'Widowed'])
            ],
            'phone_no' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[\+]?[1-9][\d]{0,15}$/'
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($employeeId)
            ],
            'address' => [
                'sometimes',
                'required',
                'string',
                'max:500'
            ],
            'date_of_birth' => [
                'sometimes',
                'required',
                'date',
                'before:-16 years',
                'after:1900-01-01'
            ],
            'nationality' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'hire_date' => [
                'sometimes',
                'required',
                'date',
                'before_or_equal:today'
            ],
            'department' => [
                'sometimes',
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
                'sometimes',
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
            'nationality.regex' => 'Nationality should only contain letters, spaces, hyphens, apostrophes, and periods.'
        ];
    }
}
