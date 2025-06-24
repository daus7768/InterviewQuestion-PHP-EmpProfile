<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'employee_id' => 'EMP001',
                'employee_name' => 'John Doe',
                'gender' => 'Male',
                'marital_status' => 'Single',
                'phone_no' => '+1234567890',
                'email' => 'john.doe@company.com',
                'address' => '123 Main Street, New York, NY 10001',
                'date_of_birth' => '1990-05-15',
                'nationality' => 'American',
                'hire_date' => '2023-01-15',
                'department' => 'Information Technology',
                'position' => 'Software Developer',
                'salary' => 75000.00
            ],
            [
                'employee_id' => 'EMP002',
                'employee_name' => 'Jane Smith',
                'gender' => 'Female',
                'marital_status' => 'Married',
                'phone_no' => '+1234567891',
                'email' => 'jane.smith@company.com',
                'address' => '456 Oak Avenue, Los Angeles, CA 90210',
                'date_of_birth' => '1988-08-22',
                'nationality' => 'American',
                'hire_date' => '2022-03-10',
                'department' => 'Human Resources',
                'position' => 'HR Manager',
                'salary' => 85000.00
            ],
            [
                'employee_id' => 'EMP003',
                'employee_name' => 'Michael Johnson',
                'gender' => 'Male',
                'marital_status' => 'Married',
                'phone_no' => '+1234567892',
                'email' => 'michael.johnson@company.com',
                'address' => '789 Pine Road, Chicago, IL 60601',
                'date_of_birth' => '1985-12-03',
                'nationality' => 'American',
                'hire_date' => '2021-07-20',
                'department' => 'Finance',
                'position' => 'Financial Analyst',
                'salary' => 70000.00
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}