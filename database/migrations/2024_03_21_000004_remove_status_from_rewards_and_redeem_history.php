<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            if (Schema::hasColumn('rewards', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('redeem_history', function (Blueprint $table) {
            if (Schema::hasColumn('redeem_history', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active');
        });

        Schema::table('redeem_history', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }
}; 