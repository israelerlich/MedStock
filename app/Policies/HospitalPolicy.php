<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HospitalPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Hospital $hospital): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function update(User $user, Hospital $hospital): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function delete(User $user, Hospital $hospital): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function restore(User $user, Hospital $hospital): bool
    {
        return false;
    }

    public function forceDelete(User $user, Hospital $hospital): bool
    {
        return false;
    }
}
