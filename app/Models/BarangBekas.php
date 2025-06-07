<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangBekas extends Model
{
    use HasFactory;

    protected $table = 'barang_bekas';

    protected $fillable = [
        'user_id',
        'nama',
        'kategori',
        'deskripsi',
        'harga',
        'gambar'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
