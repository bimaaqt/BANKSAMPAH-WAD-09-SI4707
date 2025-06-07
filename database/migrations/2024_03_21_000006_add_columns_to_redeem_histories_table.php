<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('redeem_histories', function (Blueprint $table) {
            $table->timestamp('redeemed_at')->nullable()->after('catatan');
            $table->integer('points_spent')->default(0)->after('reward_id');
            $table->integer('quantity')->default(1)->after('points_spent');
        });

        // Update existing records to set redeemed_at to created_at
        DB::table('redeem_histories')->whereNull('redeemed_at')->update([
            'redeemed_at' => DB::raw('created_at')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('redeem_histories', function (Blueprint $table) {
            $table->dropColumn(['redeemed_at', 'points_spent', 'quantity']);
        });
    }
}; 