<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RedeemHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedeemController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        
        $rewards = Reward::where('stock', '>', 0)
            ->orderBy('points_required', 'asc')
            ->get();
            
        $redeemHistories = RedeemHistory::with('reward')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('redeem.index', compact('rewards', 'redeemHistories', 'user', 'isAdmin'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0'
        ]);

        Reward::create($validated);
        return redirect()->route('redeem.index')->with('success', 'Reward berhasil ditambahkan');
    }

    public function show(Reward $reward)
    {
        return response()->json($reward);
    }

    public function update(Request $request, Reward $reward)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'points' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0'
        ]);

        $reward->update($validated);
        return redirect()->route('redeem.index')->with('success', 'Reward berhasil diperbarui');
    }

    public function destroy(Reward $reward)
    {
        if (!Auth::user()->isAdmin()) {
            return back()->with('error', 'Unauthorized');
        }

        $reward->delete();
        return redirect()->route('redeem.index')->with('success', 'Reward berhasil dihapus');
    }

    public function redeem(Request $request, Reward $reward)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $reward->stock,
            ]);

            $user = Auth::user();
            $quantity = $request->input('quantity');
            $totalPoints = $reward->points_required * $quantity;

            if ($user->total_poin < $totalPoints) {
                return back()->with('error', 'Poin Anda tidak mencukupi untuk menukar reward ini.');
            }

            if ($reward->stock < $quantity) {
                return back()->with('error', 'Stok reward tidak mencukupi.');
            }

            DB::beginTransaction();

            // Kurangi poin user
            $user->total_poin -= $totalPoints;
            $user->save();

            // Kurangi stok reward
            $reward->stock -= $quantity;
            $reward->save();

            // Buat riwayat redeem
            RedeemHistory::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'quantity' => $quantity,
                'points_spent' => $totalPoints,
                'redeemed_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', 'Berhasil menukar reward.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menukar reward.');
        }
    }
} 