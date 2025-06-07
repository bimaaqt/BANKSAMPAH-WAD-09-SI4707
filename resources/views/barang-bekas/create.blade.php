@extends('layouts.app')

@section('title', 'Tambah Barang Bekas')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Barang Bekas</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-bekas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                                id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                id="harga" name="harga" value="{{ old('harga') }}" required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kondisi" class="form-label">Kondisi</label>
                            <input type="text" class="form-control @error('kondisi') is-invalid @enderror" 
                                id="kondisi" name="kondisi" value="{{ old('kondisi') }}" required>
                            @error('kondisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                id="foto" name="foto">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('barang-bekas.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 