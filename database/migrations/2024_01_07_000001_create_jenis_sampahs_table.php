<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_sampahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kategori', ['organik', 'non-organik']);
            $table->decimal('harga_per_kg', 10, 2);
            $table->integer('poin_per_kg');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_sampahs');
    }
}; 