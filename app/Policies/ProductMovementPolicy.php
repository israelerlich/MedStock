<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\ProductMovement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductMovementPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ProductMovement $productMovement): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function update(User $user, ProductMovement $productMovement): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function delete(User $user, ProductMovement $productMovement): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function restore(User $user, ProductMovement $productMovement): bool
    {
        return false;
    }

    public function forceDelete(User $user, ProductMovement $productMovement): bool
    {
        return false;
    }
}
