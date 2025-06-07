@extends('layouts.app')

@section('title', 'Edit Barang Bekas')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Barang Bekas</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-bekas.update', $barangBekas->id) }}" 
                        method="POST" 
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" 
                                class="form-control @error('nama') is-invalid @enderror" 
                                id="nama" 
                                name="nama" 
                                value="{{ old('nama', $barangBekas->nama) }}" 
                                required>
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" 
                                class="form-control @error('kategori') is-invalid @enderror" 
                                id="kategori" 
                                name="kategori" 
                                value="{{ old('kategori', $barangBekas->kategori) }}" 
                                required>
                            @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="3" 
                                required>{{ old('deskripsi', $barangBekas->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" 
                                class="form-control @error('harga') is-invalid @enderror" 
                                id="harga" 
                                name="harga" 
                                value="{{ old('harga', $barangBekas->harga) }}" 
                                required 
                                min="0">
                            @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            @if($barangBekas->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $barangBekas->gambar) }}" 
                                    alt="{{ $barangBekas->nama }}" 
                                    class="img-thumbnail" 
                                    style="max-height: 200px;">
                            </div>
                            @endif
                            <input type="file" 
                                class="form-control @error('gambar') is-invalid @enderror" 
                                id="gambar" 
                                name="gambar" 
                                accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                            @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('barang-bekas.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 