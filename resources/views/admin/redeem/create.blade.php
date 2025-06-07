@extends('admin.layouts.app')

@section('title', 'Tambah Reward')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Reward Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.redeem.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Reward</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Poin yang Dibutuhkan</label>
                            <input type="number" class="form-control @error('points_required') is-invalid @enderror" 
                                   name="points_required" value="{{ old('points_required') }}" required min="1">
                            @error('points_required')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   name="stock" value="{{ old('stock') }}" required min="0">
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   name="image" accept="image/*">
                            <small class="text-muted">Opsional. Format: JPG, PNG. Maks: 2MB</small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.redeem.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 