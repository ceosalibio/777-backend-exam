<?php
namespace App\Repositories;
use App\Models\Employee;

class EmployeeRepository
{
    public function all()
    {
        return Employee::orderBy('id','desc')->get();
    }

    public function byPosition(string $position)
    {
        return Employee::where('position', $position)->get();
    }

    public function find(int $id)
    {
        return Employee::findOrFail($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee;
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }
}
