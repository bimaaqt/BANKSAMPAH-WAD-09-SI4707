@extends('layouts.app')

@section('title', 'Barang Bekas')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Barang Bekas</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-store me-2"></i>Daftar Barang Bekas
                </h4>
                <div class="d-flex align-items-center">
                    <span class="text-muted me-2">{{ $barangBekas->count() }} barang ditemukan</span>
                </div>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                @forelse($barangBekas as $barang)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        @if($barang->gambar)
                        <img src="{{ asset('storage/' . $barang->gambar) }}" 
                            class="card-img-top" 
                            alt="{{ $barang->nama }}"
                            style="height: 200px; object-fit: cover;">
                        @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                            style="height: 200px;">
                            <i class="fas fa-box fa-3x text-muted"></i>
                        </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $barang->nama }}</h5>
                                <span class="badge bg-primary rounded-pill">{{ $barang->kategori }}</span>
                            </div>
                            <p class="card-text text-muted">{{ Str::limit($barang->deskripsi, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 text-success">Rp {{ number_format($barang->harga, 0, ',', '.') }}</h5>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $barang->created_at->diffForHumans() }}
                                </small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" 
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#beliModal"
                                    data-barang="{{ json_encode($barang) }}">
                                    <i class="fas fa-shopping-cart me-2"></i>Beli
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 fa-2x"></i>
                        <div>Belum ada barang bekas yang tersedia.</div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Beli -->
<div class="modal fade" id="beliModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shopping-cart me-2"></i>Beli Barang Bekas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="fas fa-info-circle me-3"></i>
                    <div>Pastikan Anda telah memeriksa kondisi barang sebelum membeli.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" id="modalNama" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" class="form-control" id="modalHarga" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="modalDeskripsi" rows="3" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="" id="formBeli" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var beliModal = document.getElementById('beliModal');
    beliModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var barang = JSON.parse(button.getAttribute('data-barang'));
        
        var modalNama = document.getElementById('modalNama');
        var modalHarga = document.getElementById('modalHarga');
        var modalDeskripsi = document.getElementById('modalDeskripsi');
        var formBeli = document.getElementById('formBeli');
        
        modalNama.value = barang.nama;
        modalHarga.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(barang.harga);
        modalDeskripsi.value = barang.deskripsi;
        formBeli.action = '/barang-bekas/' + barang.id + '/beli';
    });
});
</script>
@endpush
@endsection 