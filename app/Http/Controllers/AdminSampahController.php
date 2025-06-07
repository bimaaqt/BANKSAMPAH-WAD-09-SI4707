<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class AdminSampahController extends Controller
{
    public function index()
    {
        $jenisSampahs = JenisSampah::latest()->get();
        return view('admin.sampah.index', compact('jenisSampahs'));
    }

    public function create()
    {
        return view('admin.sampah.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|in:organik,non-organik',
                'harga_per_kg' => 'required|numeric|min:0',
                'poin_per_kg' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string'
            ]);

            JenisSampah::create($validated);

            return redirect()->route('admin.sampah.index')
                ->with('success', 'Jenis sampah berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $jenisSampah = JenisSampah::findOrFail($id);
        return view('admin.sampah.edit', compact('jenisSampah'));
    }

    public function update(Request $request, $id)
    {
        try {
            $jenisSampah = JenisSampah::findOrFail($id);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|in:organik,non-organik',
                'harga_per_kg' => 'required|numeric|min:0',
                'poin_per_kg' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string'
            ]);

            $jenisSampah->update($validated);

            return redirect()->route('admin.sampah.index')
                ->with('success', 'Jenis sampah berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $jenisSampah = JenisSampah::findOrFail($id);
            $jenisSampah->delete();
            
            return redirect()->route('admin.sampah.index')
                ->with('success', 'Jenis sampah berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 