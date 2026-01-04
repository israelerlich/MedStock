<?php

namespace App\Models;

use App\Enums\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'referring_type',
        'referring_id',
        'cep',
        'city',
        'state',
        'district',
        'country',
        'street',
        'complement_number',
        'address_number'
    ];

    protected $casts = [
        'country' => Country::class
    ];

    public function referring()
    {
        return $this->morphTo();
    }
}
