<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
