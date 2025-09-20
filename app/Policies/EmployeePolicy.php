<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;

class EmployeePolicy
{
    /**
     * Managers can view all.
     * Devs/Designers can only view employees of their own role.
     */
    public function view(User $user, Employee $employee): bool
    {
        return $user->role === 'Manager' || $employee->position === $user->role;
    }

    /**
     * Everyone can view the list, but role-based restriction applies in service.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['Manager', 'Web Developer', 'Web Designer']);
    }

    /**
     * Managers can create any.
     * Devs/Designers can only create employees of their own role.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['Manager', 'Web Developer', 'Web Designer']);
    }

    /**
     * Managers can update anyone.
     * Devs/Designers can only update employees of their own role.
     */
    public function update(User $user, Employee $employee): bool
    {
        return $user->role === 'Manager' || $employee->position === $user->role;
    }

    /**
     * Managers can delete anyone.
     * Devs/Designers can only delete employees of their own role.
     */
    public function delete(User $user, Employee $employee): bool
    {
        return $user->role === 'Manager' || $employee->position === $user->role;
    }
}
