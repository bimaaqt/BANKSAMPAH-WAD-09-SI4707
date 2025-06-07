<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarangBekas extends Model
{
    use HasFactory;

    protected $table = 'kategori_barang_bekas';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'status'
    ];

    public function barangBekas()
    {
        return $this->hasMany(BarangBekas::class, 'kategori_id');
    }
} 