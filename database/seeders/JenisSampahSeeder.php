<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSampahs = [
            [
                'nama' => 'Sisa Makanan',
                'kategori' => 'organik',
                'harga_per_kg' => 2000,
                'poin_per_kg' => 20,
                'deskripsi' => 'Sisa makanan rumah tangga'
            ],
            [
                'nama' => 'Daun Kering',
                'kategori' => 'organik',
                'harga_per_kg' => 1500,
                'poin_per_kg' => 15,
                'deskripsi' => 'Daun-daun kering dari pekarangan'
            ],
            [
                'nama' => 'Sayuran Busuk',
                'kategori' => 'organik',
                'harga_per_kg' => 1800,
                'poin_per_kg' => 18,
                'deskripsi' => 'Sayuran yang sudah tidak layak konsumsi'
            ],
            [
                'nama' => 'Botol Plastik',
                'kategori' => 'non-organik',
                'harga_per_kg' => 4000,
                'poin_per_kg' => 40,
                'deskripsi' => 'Botol plastik bekas minuman'
            ],
            [
                'nama' => 'Kertas',
                'kategori' => 'non-organik',
                'harga_per_kg' => 3000,
                'poin_per_kg' => 30,
                'deskripsi' => 'Kertas bekas, koran, majalah'
            ],
            [
                'nama' => 'Kaleng',
                'kategori' => 'non-organik',
                'harga_per_kg' => 10000,
                'poin_per_kg' => 100,
                'deskripsi' => 'Kaleng bekas minuman atau makanan'
            ],
        ];

        foreach ($jenisSampahs as $sampah) {
            JenisSampah::create($sampah);
        }
    }
}
