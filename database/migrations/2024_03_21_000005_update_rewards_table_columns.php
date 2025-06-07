<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            $table->dropColumn(['nama', 'deskripsi', 'poin', 'stok', 'gambar']);
            
            // Tambah kolom baru
            $table->string('name');
            $table->text('description');
            $table->integer('points_required');
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            // Hapus kolom baru
            $table->dropColumn(['name', 'description', 'points_required', 'stock', 'image']);
            
            // Kembalikan kolom lama
            $table->string('nama');
            $table->text('deskripsi');
            $table->integer('poin');
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
        });
    }
}; 