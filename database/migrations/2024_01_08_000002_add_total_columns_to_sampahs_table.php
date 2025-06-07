<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sampahs', function (Blueprint $table) {
            $table->decimal('total_harga', 10, 2)->after('harga_per_kg');
            $table->integer('total_poin')->after('total_harga');
        });
    }

    public function down()
    {
        Schema::table('sampahs', function (Blueprint $table) {
            $table->dropColumn(['total_harga', 'total_poin']);
        });
    }
}; 