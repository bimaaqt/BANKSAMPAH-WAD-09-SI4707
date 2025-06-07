<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;

    protected $table = 'sampahs';
    
    protected $fillable = [
        'user_id',
        'jenis_sampah_id',
        'nama',
        'jenis',
        'berat',
        'harga_per_kg',
        'poin_per_kg',
        'total_harga',
        'total_poin',
        'deskripsi'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sampah) {
            // Hitung total harga dan poin setiap kali model disimpan
            if ($sampah->berat && $sampah->harga_per_kg && $sampah->poin_per_kg) {
                $sampah->total_harga = $sampah->berat * $sampah->harga_per_kg;
                $sampah->total_poin = (int)($sampah->berat * $sampah->poin_per_kg);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id');
    }
}
