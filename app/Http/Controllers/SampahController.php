<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use App\Models\JenisSampah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SampahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sampahs = $user->isAdmin() 
            ? Sampah::with(['user', 'jenisSampah'])->get()
            : Sampah::where('user_id', $user->id)->with('jenisSampah')->get();
        
        $jenisSampahs = JenisSampah::all();
        
        // Hitung total untuk tampilan statistik
        $totalBerat = $sampahs->sum('berat');
        $totalPendapatan = $sampahs->sum('total_harga');
        $totalPoin = $sampahs->sum('total_poin');
        
        return view('sampah.index', [
            'sampahs' => $sampahs,
            'jenisSampahs' => $jenisSampahs,
            'isAdmin' => $user->isAdmin(),
            'totalBerat' => $totalBerat,
            'totalPendapatan' => $totalPendapatan,
            'totalPoin' => $totalPoin
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
                'berat' => 'required|numeric|min:0.01',
                'deskripsi' => 'nullable|string'
            ]);

            $jenisSampah = JenisSampah::findOrFail($validated['jenis_sampah_id']);
            
            $sampah = new Sampah();
            $sampah->user_id = Auth::id();
            $sampah->jenis_sampah_id = $jenisSampah->id;
            $sampah->nama = $jenisSampah->nama;
            $sampah->jenis = $jenisSampah->kategori;
            $sampah->berat = $validated['berat'];
            $sampah->harga_per_kg = $jenisSampah->harga_per_kg;
            $sampah->poin_per_kg = $jenisSampah->poin_per_kg;
            $sampah->deskripsi = $validated['deskripsi'];
            
            if (!$sampah->save()) {
                throw new \Exception('Gagal menyimpan data sampah');
            }

            // Tambahkan poin ke akun user
            $user = Auth::user();
            $user->total_poin += $sampah->total_poin;
            
            // Update level user berdasarkan total poin
            if ($user->total_poin >= 1000) {
                $user->level = 'gold';
            } elseif ($user->total_poin >= 500) {
                $user->level = 'silver';
            }
            
            if (!$user->save()) {
                throw new \Exception('Gagal memperbarui poin user');
            }

            DB::commit();

            return redirect()->route('sampah.index')->with('success', 'Data sampah berhasil ditambahkan dan ' . $sampah->total_poin . ' poin telah ditambahkan ke akun Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menambah sampah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan data sampah: ' . $e->getMessage());
        }
    }

    public function show(Sampah $sampah)
    {
        $sampah->load('jenisSampah');
        return response()->json($sampah);
    }

    public function update(Request $request, Sampah $sampah)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
                'berat' => 'required|numeric|min:0.01',
                'deskripsi' => 'nullable|string'
            ]);

            // Simpan total_poin lama untuk perhitungan selisih
            $oldTotalPoin = $sampah->total_poin;

            $jenisSampah = JenisSampah::findOrFail($validated['jenis_sampah_id']);
            
            $sampah->jenis_sampah_id = $jenisSampah->id;
            $sampah->nama = $jenisSampah->nama;
            $sampah->jenis = $jenisSampah->kategori;
            $sampah->berat = $validated['berat'];
            $sampah->harga_per_kg = $jenisSampah->harga_per_kg;
            $sampah->poin_per_kg = $jenisSampah->poin_per_kg;
            $sampah->deskripsi = $validated['deskripsi'];
            
            if (!$sampah->save()) {
                throw new \Exception('Gagal memperbarui data sampah');
            }

            // Update poin user berdasarkan selisih
            $pointDifference = $sampah->total_poin - $oldTotalPoin;
            $user = $sampah->user;
            $user->total_poin += $pointDifference;
            
            // Update level user berdasarkan total poin
            if ($user->total_poin >= 1000) {
                $user->level = 'gold';
            } elseif ($user->total_poin >= 500) {
                $user->level = 'silver';
            } else {
                $user->level = 'bronze';
            }
            
            if (!$user->save()) {
                throw new \Exception('Gagal memperbarui poin user');
            }

            DB::commit();

            $message = 'Data sampah berhasil diperbarui.';
            if ($pointDifference != 0) {
                $message .= ' Poin Anda ' . ($pointDifference > 0 ? 'bertambah' : 'berkurang') . ' ' . abs($pointDifference) . ' poin.';
            }

            return redirect()->route('sampah.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat update sampah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data sampah: ' . $e->getMessage());
        }
    }

    public function destroy(Sampah $sampah)
    {
        try {
            DB::beginTransaction();

            // Kurangi poin user
            $user = $sampah->user;
            $user->total_poin -= $sampah->total_poin;
            
            // Update level user berdasarkan total poin
            if ($user->total_poin >= 1000) {
                $user->level = 'gold';
            } elseif ($user->total_poin >= 500) {
                $user->level = 'silver';
            } else {
                $user->level = 'bronze';
            }
            
            if (!$user->save()) {
                throw new \Exception('Gagal memperbarui poin user');
            }

            if (!$sampah->delete()) {
                throw new \Exception('Gagal menghapus data sampah');
            }

            DB::commit();

            return redirect()->route('sampah.index')
                ->with('success', 'Data sampah berhasil dihapus dan ' . $sampah->total_poin . ' poin telah dikurangi dari akun Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat menghapus sampah: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data sampah: ' . $e->getMessage());
        }
    }
} 