<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'gender',
        'marital_status',
        'phone_no',
        'email',
        'address',
        'date_of_birth',
        'nationality',
        'hire_date',
        'department',
        'position',
        'salary'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2'
    ];

    // Accessors
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }

    public function getFormattedSalaryAttribute()
    {
        return $this->salary ? '$' . number_format($this->salary, 2) : null;
    }

    // Scopes
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('hire_date');
    }
}
