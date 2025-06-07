@extends('admin.layouts.app')

@section('title', 'Edit Reward')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Reward</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.redeem.update', $reward->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Reward</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $reward->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="3" required>{{ old('description', $reward->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Poin yang Dibutuhkan</label>
                            <input type="number" class="form-control @error('points_required') is-invalid @enderror" 
                                   name="points_required" value="{{ old('points_required', $reward->points_required) }}" required min="1">
                            @error('points_required')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   name="stock" value="{{ old('stock', $reward->stock) }}" required min="0">
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            @if($reward->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}" 
                                     class="img-thumbnail" style="max-height: 200px">
                            </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   name="image" accept="image/*">
                            <small class="text-muted">Opsional. Format: JPG, PNG. Maks: 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.redeem.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 