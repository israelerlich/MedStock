<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model implements AuthenticatableContract
{
    use SoftDeletes, HasFactory, Authenticatable;

    protected $fillable = [
        "name",
        "email",
        "password",
        "role"
    ];

    protected $hidden = [
        "password"
    ];

    protected $casts = [
        "role" => Role::class
    ];

    public function userHospital()
    {
        return $this->belongsToMany(UserHospital::class);
    }
}