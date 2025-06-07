<?php

namespace App\Http\Controllers;

use App\Models\BarangBekas;
use App\Models\KategoriBarangBekas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBarangBekasController extends Controller
{
    public function index()
    {
        $barangBekas = BarangBekas::with('user')->latest()->get();
        return view('admin.barang-bekas.index', compact('barangBekas'));
    }

    public function create()
    {
        $kategoris = KategoriBarangBekas::where('status', 'aktif')->get();
        return view('admin.barang-bekas.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string|max:50',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'gambar' => 'nullable|image|max:2048'
            ]);

            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('barang-bekas', 'public');
            }

            $validated['user_id'] = auth()->id();
            BarangBekas::create($validated);

            return redirect()->route('admin.barang-bekas.index')
                ->with('success', 'Barang bekas berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(BarangBekas $barangBekas)
    {
        return view('admin.barang-bekas.show', compact('barangBekas'));
    }

    public function edit(BarangBekas $barangBekas)
    {
        $kategoris = KategoriBarangBekas::where('status', 'aktif')->get();
        return view('admin.barang-bekas.edit', compact('barangBekas', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        try {
            $barangBekas = BarangBekas::findOrFail($id);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string|max:50',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'gambar' => 'nullable|image|max:2048'
            ]);

            if ($request->hasFile('gambar')) {
                if ($barangBekas->gambar) {
                    Storage::disk('public')->delete($barangBekas->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store('barang-bekas', 'public');
            }

            $barangBekas->update($validated);

            return redirect()->route('admin.barang-bekas.index')
                ->with('success', 'Barang bekas berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $barangBekas = BarangBekas::findOrFail($id);
            
            if ($barangBekas->gambar) {
                Storage::disk('public')->delete($barangBekas->gambar);
            }
            
            $barangBekas->delete();
            
            return redirect()->route('admin.barang-bekas.index')
                ->with('success', 'Barang bekas berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kategori()
    {
        $kategoris = KategoriBarangBekas::withCount('barangBekas as total_barang')->get();
        return view('admin.barang-bekas.kategori', compact('kategoris'));
    }

    public function storeKategori(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_barang_bekas,nama',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            KategoriBarangBekas::create([
                'nama' => $validated['nama'],
                'slug' => Str::slug($validated['nama']),
                'deskripsi' => $validated['deskripsi'],
                'status' => 'aktif'
            ]);

            return back()->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menambahkan kategori');
        }
    }

    public function updateKategori(Request $request, KategoriBarangBekas $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_barang_bekas,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $kategori->update([
                'nama' => $validated['nama'],
                'slug' => Str::slug($validated['nama']),
                'deskripsi' => $validated['deskripsi']
            ]);

            return back()->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui kategori');
        }
    }

    public function destroyKategori(KategoriBarangBekas $kategori)
    {
        try {
            // Cek apakah ada barang bekas yang menggunakan kategori ini
            if ($kategori->barangBekas()->exists()) {
                return back()->with('error', 'Tidak dapat menghapus kategori yang masih digunakan');
            }

            $kategori->delete();
            return back()->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus kategori');
        }
    }
} 