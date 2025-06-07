<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use App\Models\RedeemHistory;
use App\Models\BarangBekas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Hitung statistik berdasarkan role
        if ($user->isAdmin()) {
            $totalSampah = Sampah::sum('berat');
            $totalPendapatan = Sampah::sum('total_harga');
            $totalRedeem = RedeemHistory::count();
            $totalPembelian = BarangBekas::count();
        } else {
            $totalSampah = Sampah::where('user_id', $user->id)->sum('berat');
            $totalPendapatan = Sampah::where('user_id', $user->id)->sum('total_harga');
            $totalRedeem = RedeemHistory::where('user_id', $user->id)->count();
            $totalPembelian = BarangBekas::count();
        }

        return view('dashboard', [
            'user' => $user,
            'totalSampah' => $totalSampah,
            'totalPendapatan' => $totalPendapatan,
            'totalRedeem' => $totalRedeem,
            'totalPembelian' => $totalPembelian
        ]);
    }
} 