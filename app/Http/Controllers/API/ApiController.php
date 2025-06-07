<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sampah;
use App\Models\BarangBekas;
use App\Models\RedeemHistory;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function sampahs()
    {
        $sampahs = Sampah::with('user')->get();
        return response()->json([
            'status' => 'success',
            'data' => $sampahs
        ]);
    }

    public function barangBekas()
    {
        $barangBekas = BarangBekas::with('user')->get();
        return response()->json([
            'status' => 'success',
            'data' => $barangBekas
        ]);
    }

    public function redeems()
    {
        $redeems = RedeemHistory::with(['user', 'reward'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $redeems
        ]);
    }
} 