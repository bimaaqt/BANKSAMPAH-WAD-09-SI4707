@extends('layouts.app')

@section('title', 'Redeem Poin')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Redeem Poin</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- User Points Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Poin Anda</h6>
                            <h2 class="card-title display-4 mb-0">{{ number_format($user->total_poin) }} <small class="fs-6">Poin</small></h2>
                        </div>
                        <div class="ms-auto">
                            <i class="fas fa-coins fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rewards Grid -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Reward</h4>
                @if($isAdmin)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRewardModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Reward
                </button>
                @endif
            </div>
        </div>

        @forelse($rewards as $reward)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100">
                @if($reward->image)
                <img src="{{ asset('storage/' . $reward->image) }}" class="card-img-top" alt="{{ $reward->name }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-gift fa-3x text-muted"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $reward->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($reward->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            <i class="fas fa-coins me-2"></i>{{ number_format($reward->points_required) }} Poin
                        </span>
                        <span class="badge bg-{{ $reward->stock > 0 ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                            <i class="fas fa-box me-2"></i>Stok: {{ $reward->stock }}
                        </span>
                    </div>
                    @if(!$isAdmin)
                    <form action="{{ route('redeem.points', $reward) }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="quantity" value="1" min="1" max="{{ $reward->stock }}" id="quantity{{ $reward->id }}" placeholder="Jumlah">
                            <label for="quantity{{ $reward->id }}">Jumlah</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 {{ ($user->total_poin < $reward->points_required || $reward->stock <= 0) ? 'disabled' : '' }}">
                            @if($reward->stock <= 0)
                                <i class="fas fa-times-circle me-2"></i>Stok Habis
                            @elseif($user->total_poin < $reward->points_required)
                                <i class="fas fa-exclamation-circle me-2"></i>Poin Tidak Cukup
                            @else
                                <i class="fas fa-gift me-2"></i>Tukar Poin
                            @endif
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center">
                <i class="fas fa-info-circle me-3 fa-2x"></i>
                <div>Belum ada reward yang tersedia.</div>
            </div>
        </div>
        @endforelse
    </div>

    @if($redeemHistories->isNotEmpty())
    <!-- Riwayat Penukaran -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Penukaran Anda
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Reward</th>
                                    <th>Jumlah</th>
                                    <th>Poin Digunakan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($redeemHistories as $history)
                                <tr>
                                    <td>{{ $history->redeemed_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $history->reward->name }}</td>
                                    <td>{{ $history->quantity }}</td>
                                    <td>{{ number_format($history->points_spent) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $history->status === 'selesai' ? 'success' : ($history->status === 'ditolak' ? 'danger' : 'warning') }} rounded-pill">
                                            {{ ucfirst($history->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@if($isAdmin)
<!-- Modal Tambah Reward -->
<div class="modal fade" id="addRewardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.redeem.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Reward
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" required id="addName" placeholder="Nama Reward">
                        <label for="addName">Nama Reward</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" rows="3" required id="addDescription" placeholder="Deskripsi" style="height: 100px"></textarea>
                        <label for="addDescription">Deskripsi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="points_required" required min="1" id="addPoints" placeholder="Poin yang Dibutuhkan">
                        <label for="addPoints">Poin yang Dibutuhkan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="stock" required min="0" id="addStock" placeholder="Stok">
                        <label for="addStock">Stok</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Opsional. Format: JPG, PNG. Maks: 2MB
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Reward -->
<div class="modal fade" id="editRewardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editRewardForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Reward
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" required id="editName" placeholder="Nama Reward">
                        <label for="editName">Nama Reward</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" rows="3" required id="editDescription" placeholder="Deskripsi" style="height: 100px"></textarea>
                        <label for="editDescription">Deskripsi</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="points_required" required min="1" id="editPoints" placeholder="Poin yang Dibutuhkan">
                        <label for="editPoints">Poin yang Dibutuhkan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="stock" required min="0" id="editStock" placeholder="Stok">
                        <label for="editStock">Stok</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Opsional. Format: JPG, PNG. Maks: 2MB
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #00bcd4);
}
.reward-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.reward-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.badge {
    font-weight: 500;
}
.form-floating > .form-select {
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
}
.table th {
    white-space: nowrap;
}
.alert {
    border: none;
    border-radius: 10px;
}
.modal-content {
    border: none;
    border-radius: 15px;
}
.btn {
    border-radius: 5px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editRewardModal = document.getElementById('editRewardModal');
    if (editRewardModal) {
        editRewardModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const reward = JSON.parse(button.getAttribute('data-reward'));
            const form = this.querySelector('#editRewardForm');
            
            form.action = `/admin/redeem/${reward.id}`;
            form.querySelector('#editName').value = reward.name;
            form.querySelector('#editDescription').value = reward.description;
            form.querySelector('#editPoints').value = reward.points_required;
            form.querySelector('#editStock').value = reward.stock;
        });
    }
});
</script>
@endpush

@endsection 