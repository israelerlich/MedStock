<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function view(User $user, User $model): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]) || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === Role::SUPER_ADMIN || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
