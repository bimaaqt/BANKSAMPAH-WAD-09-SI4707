<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sampah;
use App\Models\RedeemHistory;
use App\Models\BarangBekas;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik User
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalPoinDiberikan = User::sum('total_poin');

        // Statistik Sampah
        $totalSampah = Sampah::count();
        $totalSetoranSampah = Sampah::count();
        $totalBeratSampah = Sampah::sum('berat');
        $sampahPerKategori = Sampah::select('jenis_sampahs.kategori', DB::raw('count(*) as total'))
            ->join('jenis_sampahs', 'sampahs.jenis_sampah_id', '=', 'jenis_sampahs.id')
            ->groupBy('jenis_sampahs.kategori')
            ->get();

        // Data Terbaru untuk Tabel
        $latestSetoranSampah = Sampah::with(['user', 'jenisSampah'])
            ->latest()
            ->take(5)
            ->get();

        $latestUsers = User::latest()
            ->take(5)
            ->get();

        $latestRedeem = RedeemHistory::with(['user', 'reward'])
            ->latest()
            ->take(5)
            ->get();

        $latestBarangBekas = BarangBekas::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Statistik Barang Bekas
        $totalBarangBekas = BarangBekas::count();

        // Statistik Redeem
        $totalRedeem = RedeemHistory::count();
        $redeemPending = RedeemHistory::where('status', 'pending')->count();
        $redeemDiproses = RedeemHistory::where('status', 'diproses')->count();
        $redeemSelesai = RedeemHistory::where('status', 'selesai')->count();

        // Data untuk grafik (contoh: redeem per bulan)
        $redeemPerBulan = RedeemHistory::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('count(*) as total')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmin',
            'totalPoinDiberikan',
            'totalSampah',
            'totalSetoranSampah',
            'totalBeratSampah',
            'sampahPerKategori',
            'latestSetoranSampah',
            'latestUsers',
            'latestRedeem',
            'latestBarangBekas',
            'totalBarangBekas',
            'totalRedeem',
            'redeemPending',
            'redeemDiproses',
            'redeemSelesai',
            'redeemPerBulan'
        ));
    }
} 