<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_poin')->default(0)->after('level');
        });

        // Update total_poin untuk semua user berdasarkan sampah yang sudah ada
        DB::statement('
            UPDATE users u 
            SET total_poin = (
                SELECT COALESCE(SUM(total_poin), 0)
                FROM sampahs s
                WHERE s.user_id = u.id
            )
        ');
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('total_poin');
        });
    }
}; 