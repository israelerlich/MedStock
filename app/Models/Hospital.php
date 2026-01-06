<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "budget",
        "current_balance"
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'current_balance' => 'decimal:2'
    ];

    public function userHospitals()
    {
        return $this->hasMany(UserHospital::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTotalExpenses($startDate = null, $endDate = null)
    {
        $query = ProductMovement::whereHas('product', function ($q) {
            $q->where('hospital_id', $this->id);
        })->where('type', \App\Enums\MovementType::EXIT);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->sum('total_price');
    }

    public function getExpensesByCategory($startDate = null, $endDate = null)
    {
        $query = ProductMovement::with('product')
            ->whereHas('product', function ($q) {
                $q->where('hospital_id', $this->id);
            })
            ->where('type', \App\Enums\MovementType::EXIT);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->get()->groupBy('product.type')->map(function ($movements) {
            return $movements->sum('total_price');
        });
    }
}
