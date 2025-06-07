<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'points_required',
        'stock',
        'image'
    ];

    protected $casts = [
        'points_required' => 'integer',
        'stock' => 'integer',
    ];

    public function redeemHistories()
    {
        return $this->hasMany(RedeemHistory::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Log setiap kali ada percobaan delete
        static::deleting(function($reward) {
            \Log::info('Deleting reward from model event', [
                'reward_id' => $reward->id,
                'reward_name' => $reward->name
            ]);
        });
    }
} 