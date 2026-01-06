<?php

namespace App\Models;

use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMovement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'client_id',
        'type',
        'quantity',
        'unit_price',
        'total_price'
    ];

    protected $casts = [
        'type' => MovementType::class
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Event para atualizar estoque automaticamente
    protected static function booted()
    {
        static::created(function ($movement) {
            $product = $movement->product;
            if ($movement->type === MovementType::ENTRY || $movement->type === MovementType::RETURN) {
                $product->increment('current_stock', $movement->quantity);
            } elseif ($movement->type === MovementType::EXIT) {
                $product->decrement('current_stock', $movement->quantity);
            }
        });
    }
}
