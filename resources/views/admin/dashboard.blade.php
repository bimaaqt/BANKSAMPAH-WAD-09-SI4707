@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold">Dashboard</h4>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total User</h6>
                    <h2 class="card-title mb-0">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Setoran Sampah</h6>
                    <h2 class="card-title mb-0">{{ $totalSampah }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Redeem</h6>
                    <h2 class="card-title mb-0">{{ $totalRedeem }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Barang Bekas</h6>
                    <h2 class="card-title mb-0">{{ $totalBarangBekas }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Setoran Sampah Terbaru -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Setoran Sampah Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Jenis Sampah</th>
                                    <th>Berat (kg)</th>
                                    <!-- <th>Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestSetoranSampah as $setoran)
                                <tr>
                                    <td>{{ $setoran->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $setoran->user->name }}</td>
                                    <td>{{ $setoran->jenisSampah->nama }}</td>
                                    <td>{{ $setoran->berat }}</td>
                                    <!-- <td>
                                        <span class="badge bg-{{ 
                                            $setoran->status === 'verified' ? 'success' : 
                                            ($setoran->status === 'pending' ? 'warning' : 'danger') 
                                        }}">
                                            {{ ucfirst($setoran->status) }}
                                        </span>
                                    </td> -->
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada setoran sampah</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Redeem Terbaru -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Redeem Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                    <th>Reward</th>
                                    <th>Poin</th>
                                    <!-- <th>Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestRedeem as $redeem)
                                <tr>
                                    <td>{{ $redeem->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $redeem->user->name }}</td>
                                    <td>{{ $redeem->reward->nama }}</td>
                                    <td>{{ $redeem->reward->poin }}</td>
                                    <!-- <td>
                                        <span class="badge bg-{{ 
                                            $redeem->status === 'selesai' ? 'success' : 
                                            ($redeem->status === 'pending' ? 'warning' : 
                                            ($redeem->status === 'diproses' ? 'info' : 'danger')) 
                                        }}">
                                            {{ ucfirst($redeem->status) }}
                                        </span>
                                    </td> -->
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada redeem</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Bekas Terbaru -->
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Barang Bekas Terbaru</h5>
                <a href="{{ route('admin.barang-bekas.index') }}" class="btn btn-primary btn-sm">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Penjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestBarangBekas as $barang)
                            <tr>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->kategori }}</td>
                                <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td>{{ $barang->user->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data barang bekas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 