<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_name",
        "commercial_name",
        "phone_number",
        "cnpj",
        "email"
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'referring');
    }
}