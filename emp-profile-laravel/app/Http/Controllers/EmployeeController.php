namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Employee::query();

            // Apply filters
            if ($request->has('department')) {
                $query->byDepartment($request->department);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('employee_name', 'like', "%{$search}%")
                      ->orWhere('employee_id', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Pagination
            $perPage = $request->get('per_page', 15);
            $employees = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $employees,
                'message' => 'Employees retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving employees: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created employee.
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        try {
            $employee = Employee::create($request->validated());

            // Save to JSON file as backup
            $this->saveToJsonFile($employee);

            // Save to CSV file as backup
            $this->saveToCsvFile($employee);

            return response()->json([
                'success' => true,
                'data' => $employee,
                'message' => 'Employee created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $employee,
                'message' => 'Employee retrieved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified employee.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        try {
            $employee->update($request->validated());

            return response()->json([
                'success' => true,
                'data' => $employee,
                'message' => 'Employee updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee): JsonResponse
    {
        try {
            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export employees to CSV.
     */
    public function exportCsv(): JsonResponse
    {
        try {
            $employees = Employee::all();
            $csvData = [];

            // CSV Headers
            $csvData[] = [
                'Employee ID',
                'Employee Name',
                'Gender',
                'Marital Status',
                'Phone Number',
                'Email',
                'Address',
                'Date of Birth',
                'Nationality',
                'Hire Date',
                'Department',
                'Position',
                'Salary',
                'Created At'
            ];

            // Add employee data
            foreach ($employees as $employee) {
                $csvData[] = [
                    $employee->employee_id,
                    $employee->employee_name,
                    $employee->gender,
                    $employee->marital_status,
                    $employee->phone_no,
                    $employee->email,
                    $employee->address,
                    $employee->date_of_birth?->format('Y-m-d'),
                    $employee->nationality,
                    $employee->hire_date?->format('Y-m-d'),
                    $employee->department,
                    $employee->position,
                    $employee->salary,
                    $employee->created_at?->format('Y-m-d H:i:s')
                ];
            }

            // Save to storage
            $filename = 'employees_export_' . date('Y-m-d_H-i-s') . '.csv';
            $filepath = storage_path('app/exports/' . $filename);

            // Create directory if it doesn't exist
            if (!file_exists(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }

            $file = fopen($filepath, 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);

            return response()->json([
                'success' => true,
                'data' => [
                    'filename' => $filename,
                    'path' => $filepath,
                    'count' => count($employees)
                ],
                'message' => 'CSV export completed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting CSV: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export employees to JSON.
     */
    public function exportJson(): JsonResponse
    {
        try {
            $employees = Employee::all();
            $filename = 'employees_export_' . date('Y-m-d_H-i-s') . '.json';
            $filepath = storage_path('app/exports/' . $filename);

            // Create directory if it doesn't exist
            if (!file_exists(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }

            file_put_contents($filepath, json_encode($employees, JSON_PRETTY_PRINT));

            return response()->json([
                'success' => true,
                'data' => [
                    'filename' => $filename,
                    'path' => $filepath,
                    'count' => count($employees)
                ],
                'message' => 'JSON export completed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error exporting JSON: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save employee data to JSON file.
     */
    private function saveToJsonFile(Employee $employee): void
    {
        $filepath = storage_path('app/employees/employees.json');
        
        // Create directory if it doesn't exist
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $employees = [];
        if (file_exists($filepath)) {
            $employees = json_decode(file_get_contents($filepath), true) ?? [];
        }

        $employees[] = $employee->toArray();
        file_put_contents($filepath, json_encode($employees, JSON_PRETTY_PRINT));
    }

    /**
     * Save employee data to CSV file.
     */
    private function saveToCsvFile(Employee $employee): void
    {
        $filepath = storage_path('app/employees/employees.csv');
        
        // Create directory if it doesn't exist
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        $fileExists = file_exists($filepath);
        $file = fopen($filepath, 'a');

        // Write header if file is new
        if (!$fileExists) {
            fputcsv($file, [
                'Employee ID',
                'Employee Name',
                'Gender',
                'Marital Status',
                'Phone Number',
                'Email',
                'Address',
                'Date of Birth',
                'Nationality',
                'Hire Date',
                'Department',
                'Position',
                'Salary',
                'Created At'
            ]);
        }

        // Write employee data
        fputcsv($file, [
            $employee->employee_id,
            $employee->employee_name,
            $employee->gender,
            $employee->marital_status,
            $employee->phone_no,
            $employee->email,
            $employee->address,
            $employee->date_of_birth?->format('Y-m-d'),
            $employee->nationality,
            $employee->hire_date?->format('Y-m-d'),
            $employee->department,
            $employee->position,
            $employee->salary,
            $employee->created_at?->format('Y-m-d H:i:s')
        ]);

        fclose($file);
    }
}
