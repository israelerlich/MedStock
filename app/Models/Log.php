<?php

namespace App\Models;

use App\Enums\ActionType;
use App\Enums\LogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'type'
    ];

    protected $casts = [
        'action' => ActionType::class,
        'type' => LogType::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
