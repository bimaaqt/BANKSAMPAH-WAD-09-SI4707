<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sampahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('jenis_sampah_id')->nullable()->constrained('jenis_sampahs')->onDelete('restrict');
            $table->string('nama')->nullable();
            $table->enum('jenis', ['organik', 'anorganik'])->nullable();
            $table->decimal('harga_per_kg', 10, 2)->nullable();
            $table->integer('poin_per_kg')->nullable();
            $table->string('gambar')->nullable();
            $table->decimal('berat', 8, 2)->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sampahs');
    }
}; 