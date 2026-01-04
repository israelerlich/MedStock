<?php

namespace App\Models;

use App\Enums\Profession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profession',
        'name',
        'cpf',
        'phone_number'
    ];

    protected $casts = [
        'profession' => Profession::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productMovements()
    {
        return $this->hasMany(ProductMovement::class);
    }
}
