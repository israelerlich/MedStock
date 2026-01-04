<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Log;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LogPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function view(User $user, Log $log): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function update(User $user, Log $log): bool
    {
        return false;
    }

    public function delete(User $user, Log $log): bool
    {
        return false;
    }

    public function restore(User $user, Log $log): bool
    {
        return false;
    }

    public function forceDelete(User $user, Log $log): bool
    {
        return false;
    }
}
