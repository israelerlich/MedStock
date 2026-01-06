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
        'hospital_id',
        'name',
        'price',
        'type',
        'status',
        'current_stock',
        'min_stock',
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

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function productMovements()
    {
        return $this->hasMany(ProductMovement::class);
    }

    // Verifica se o produto está vencido
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // Verifica se o produto está próximo ao vencimento (30 dias)
    public function isNearExpiry()
    {
        return $this->expires_at && $this->expires_at->diffInDays(now()) <= 30 && !$this->isExpired();
    }

    // Verifica se o estoque está abaixo do mínimo
    public function isLowStock()
    {
        return $this->current_stock <= $this->min_stock;
    }

    // Atualiza o estoque
    public function updateStock(int $quantity, string $type)
    {
        if ($type === 'entry') {
            $this->increment('current_stock', $quantity);
        } else {
            $this->decrement('current_stock', $quantity);
        }
    }
}
