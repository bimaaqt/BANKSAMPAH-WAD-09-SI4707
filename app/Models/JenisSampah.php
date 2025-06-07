<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampahs';

    protected $fillable = [
        'nama',
        'kategori', // organik/non-organik
        'harga_per_kg',
        'poin_per_kg',
        'deskripsi'
    ];

    public function sampahs()
    {
        return $this->hasMany(Sampah::class);
    }
} 