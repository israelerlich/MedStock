<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'name',
        'price',
        'type',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'type' => ProductType::class,
        'status' => ProductStatus::class,
        'expires_at' => 'datetime'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function productMovements()
    {
        return $this->hasMany(ProductMovement::class);
    }
}
