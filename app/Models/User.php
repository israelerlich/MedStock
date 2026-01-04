<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        "name",
        "password",
        "email",
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