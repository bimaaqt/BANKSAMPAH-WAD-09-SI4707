<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\RedeemHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRedeemController extends Controller
{
    public function index()
    {
        $rewards = Reward::all();
        $redeems = RedeemHistory::with(['user', 'reward'])->orderBy('redeemed_at', 'desc')->get();
        return view('admin.redeem.index', compact('rewards', 'redeems'));
    }

    public function create()
    {
        return view('admin.redeem.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'points_required' => 'required|integer|min:1',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('rewards', 'public');
                $validated['image'] = $path;
            }

            Reward::create($validated);

            return redirect()
                ->route('admin.redeem.index')
                ->with('success', 'Reward berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating reward: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan reward');
        }
    }

    public function edit($id)
    {
        $reward = Reward::findOrFail($id);
        return view('admin.redeem.edit', compact('reward'));
    }

    public function update(Request $request, $id)
    {
        try {
            $reward = Reward::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'points_required' => 'required|integer|min:1',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($reward->image) {
                    Storage::disk('public')->delete($reward->image);
                }
                $path = $request->file('image')->store('rewards', 'public');
                $validated['image'] = $path;
            }

            $reward->update($validated);

            return redirect()
                ->route('admin.redeem.index')
                ->with('success', 'Reward berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating reward: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui reward');
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $reward = Reward::findOrFail($id);

            // Check if reward has any redeem history
            $hasHistory = RedeemHistory::where('reward_id', $reward->id)->exists();
            if ($hasHistory) {
                return redirect()
                    ->back()
                    ->with('error', 'Reward tidak dapat dihapus karena sudah memiliki riwayat penukaran');
            }

            // Delete image if exists
            if ($reward->image) {
                Storage::disk('public')->delete($reward->image);
            }

            $reward->delete();

            DB::commit();

            return redirect()
                ->route('admin.redeem.index')
                ->with('success', 'Reward berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting reward: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus reward');
        }
    }

    public function updateStatus(Request $request, RedeemHistory $redeem)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'status' => 'required|in:pending,diproses,selesai,ditolak'
            ]);

            if ($validated['status'] === 'ditolak' && $redeem->status !== 'ditolak') {
                $redeem->user->increment('points', $redeem->reward->poin);
                $redeem->reward->increment('stok');
            } elseif ($redeem->status === 'ditolak' && $validated['status'] !== 'ditolak') {
                $redeem->user->decrement('points', $redeem->reward->poin);
                $redeem->reward->decrement('stok');
            }

            $redeem->update($validated);

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
} 