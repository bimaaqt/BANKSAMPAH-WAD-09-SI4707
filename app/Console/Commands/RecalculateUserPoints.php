<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Sampah;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecalculateUserPoints extends Command
{
    protected $signature = 'points:recalculate';
    protected $description = 'Menghitung ulang total poin untuk semua user';

    public function handle()
    {
        $this->info('Memulai perhitungan ulang poin...');

        DB::transaction(function () {
            // Reset semua total_poin ke 0
            User::query()->update(['total_poin' => 0]);

            // Hitung ulang total_poin berdasarkan sampah
            $users = User::all();
            foreach ($users as $user) {
                $totalPoin = Sampah::where('user_id', $user->id)->sum('total_poin');
                
                $user->total_poin = $totalPoin;
                
                // Update level berdasarkan total poin
                if ($totalPoin >= 1000) {
                    $user->level = 'gold';
                } elseif ($totalPoin >= 500) {
                    $user->level = 'silver';
                } else {
                    $user->level = 'bronze';
                }
                
                $user->save();
                
                $this->info("User {$user->name}: {$totalPoin} poin (Level: {$user->level})");
            }
        });

        $this->info('Perhitungan ulang poin selesai!');
    }
} 