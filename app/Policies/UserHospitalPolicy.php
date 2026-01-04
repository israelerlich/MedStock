<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\UserHospital;
use Illuminate\Auth\Access\Response;

class UserHospitalPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function view(User $user, UserHospital $userHospital): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function update(User $user, UserHospital $userHospital): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function delete(User $user, UserHospital $userHospital): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function restore(User $user, UserHospital $userHospital): bool
    {
        return false;
    }

    public function forceDelete(User $user, UserHospital $userHospital): bool
    {
        return false;
    }
}
