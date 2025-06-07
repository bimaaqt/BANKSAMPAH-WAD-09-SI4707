<?php

namespace App\Http\Controllers;

use App\Models\BarangBekas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangBekasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $barangBekas = $user->isAdmin() 
            ? BarangBekas::with('user')->get()
            : BarangBekas::with('user')->get();
        
        $kategoris = ['elektronik', 'pakaian', 'perabotan', 'buku', 'olahraga', 'lainnya'];
        
        return view('barang-bekas.index', [
            'barangBekas' => $barangBekas,
            'isAdmin' => $user->isAdmin(),
            'kategoris' => $kategoris
        ]);
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('barang-bekas.index')
                ->with('error', 'Anda tidak memiliki akses untuk menambah barang.');
        }
        return view('barang-bekas.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('barang-bekas.index')
                ->with('error', 'Anda tidak memiliki akses untuk menambah barang.');
        }

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('barang-bekas', 'public');
            $validated['foto'] = $path;
        }

        $validated['user_id'] = Auth::id();
        BarangBekas::create($validated);

        return redirect()->route('barang-bekas.index')
            ->with('success', 'Barang bekas berhasil ditambahkan.');
    }

    public function edit(BarangBekas $barangBekas)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('barang-bekas.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit barang.');
        }
        return view('barang-bekas.edit', compact('barangBekas'));
    }

    public function update(Request $request, BarangBekas $barangBekas)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('barang-bekas.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit barang.');
        }

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kondisi' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($barangBekas->foto) {
                Storage::disk('public')->delete($barangBekas->foto);
            }
            $path = $request->file('foto')->store('barang-bekas', 'public');
            $validated['foto'] = $path;
        }

        $barangBekas->update($validated);

        return redirect()->route('barang-bekas.index')
            ->with('success', 'Barang bekas berhasil diperbarui.');
    }

    public function destroy(BarangBekas $barangBekas)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('barang-bekas.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus barang.');
        }

        if ($barangBekas->foto) {
            Storage::disk('public')->delete($barangBekas->foto);
        }

        $barangBekas->delete();

        return redirect()->route('barang-bekas.index')
            ->with('success', 'Barang bekas berhasil dihapus.');
    }

    public function beli(BarangBekas $barangBekas)
    {
        return redirect()->route('barang-bekas.index')
            ->with('success', 'Barang berhasil dibeli.');
    }
}
