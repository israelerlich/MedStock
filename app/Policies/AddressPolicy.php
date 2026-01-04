<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Address $address): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function update(User $user, Address $address): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function delete(User $user, Address $address): bool
    {
        return $user->role === Role::SUPER_ADMIN;
    }

    public function restore(User $user, Address $address): bool
    {
        return false;
    }

    public function forceDelete(User $user, Address $address): bool
    {
        return false;
    }
}
