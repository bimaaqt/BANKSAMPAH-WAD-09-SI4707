<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_id',
        'status',
        'catatan',
        'points_spent',
        'quantity',
        'redeemed_at'
    ];

    protected $casts = [
        'redeemed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
} 