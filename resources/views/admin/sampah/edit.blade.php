@extends('admin.layouts.app')

@section('title', 'Edit Jenis Sampah')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Jenis Sampah</h5>
                <a href="{{ route('admin.sampah.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sampah.update', $jenisSampah->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Sampah</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama', $jenisSampah->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Sampah</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" 
                                id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori Sampah</option>
                            <option value="organik" {{ old('kategori', $jenisSampah->kategori) == 'organik' ? 'selected' : '' }}>
                                Organik
                            </option>
                            <option value="non-organik" {{ old('kategori', $jenisSampah->kategori) == 'non-organik' ? 'selected' : '' }}>
                                Non-Organik
                            </option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga_per_kg" class="form-label">Harga per Kg (Rp)</label>
                        <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" 
                               id="harga_per_kg" name="harga_per_kg" 
                               value="{{ old('harga_per_kg', $jenisSampah->harga_per_kg) }}" required min="0">
                        @error('harga_per_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="poin_per_kg" class="form-label">Poin per Kg</label>
                        <input type="number" class="form-control @error('poin_per_kg') is-invalid @enderror" 
                               id="poin_per_kg" name="poin_per_kg" 
                               value="{{ old('poin_per_kg', $jenisSampah->poin_per_kg) }}" required min="0">
                        @error('poin_per_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-muted">(Opsional)</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $jenisSampah->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 