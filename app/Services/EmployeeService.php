<?php
namespace App\Services;
use App\Repositories\EmployeeRepository;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class EmployeeService
{
    public function __construct(protected EmployeeRepository $repo) {}

    public function listFor(User $user)
    {
        if ($user->role === 'Manager') {
            return $this->repo->all();
        }
        return $this->repo->byPosition($user->role);
    }

    public function createFor(User $user, array $data): Employee
    {
        // Manager may choose any position.
        if ($user->role !== 'Manager') {
            // enforce that non-manager can only create employees of their own role.
            $data['position'] = $user->role;
        } else {
            $data['position'] = $data['position'] ?? 'Web Developer';
        }
        return $this->repo->create($data);
    }

    public function updateFor(User $user, Employee $employee, array $data): Employee
    {
        if ($user->role !== 'Manager') {
            // non-manager cannot change position, and can only update same-position employees
            if ($employee->position !== $user->role) {
                throw new AuthorizationException('Unauthorized');
            }
            unset($data['position']);
        }
        // manager can update any field including position
        return $this->repo->update($employee, $data);
    }

    public function deleteFor(User $user, Employee $employee): bool
    {
        if ($user->role !== 'Manager' && $employee->position !== $user->role) {
            throw new AuthorizationException('Unauthorized');
        }
        return $this->repo->delete($employee);
    }
}
