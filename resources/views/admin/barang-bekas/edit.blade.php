@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Barang Bekas</h1>
        <a href="{{ route('admin.barang-bekas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Barang Bekas</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.barang-bekas.update', $barangBekas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror" 
                                   value="{{ old('nama_barang', $barangBekas->nama_barang) }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $barangBekas->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="baru" {{ old('kondisi', $barangBekas->kondisi) == 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="bekas_sangat_baik" {{ old('kondisi', $barangBekas->kondisi) == 'bekas_sangat_baik' ? 'selected' : '' }}>Bekas - Sangat Baik</option>
                                <option value="bekas_baik" {{ old('kondisi', $barangBekas->kondisi) == 'bekas_baik' ? 'selected' : '' }}>Bekas - Baik</option>
                                <option value="bekas_cukup" {{ old('kondisi', $barangBekas->kondisi) == 'bekas_cukup' ? 'selected' : '' }}>Bekas - Cukup</option>
                            </select>
                            @error('kondisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Estimasi Poin</label>
                            <input type="number" name="estimasi_poin" class="form-control @error('estimasi_poin') is-invalid @enderror" 
                                   value="{{ old('estimasi_poin', $barangBekas->estimasi_poin) }}" min="0" required>
                            @error('estimasi_poin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Perkiraan poin yang akan didapat jika barang diterima</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            @if($barangBekas->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $barangBekas->foto) }}" alt="Foto Barang" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @endif
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" 
                                   accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="4">{{ old('deskripsi', $barangBekas->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 