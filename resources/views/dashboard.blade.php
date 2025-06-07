@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- User Info Card -->
    @if(!auth()->user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-1">Selamat datang, {{ Auth::user()->name }}!</h4>
                            <p class="mb-0">Level: {{ ucfirst(Auth::user()->level) }}</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <h5 class="mb-1">Total Poin</h5>
                            <div class="d-flex align-items-center justify-content-end">
                                <i class="fas fa-coins fa-2x me-2"></i>
                                <h2 class="mb-0">{{ number_format(Auth::user()->total_poin) }}</h2>
                            </div>
                            <small class="text-white-50">
                                @if(Auth::user()->level == 'bronze')
                                    {{ 500 - Auth::user()->total_poin }} poin lagi menuju Silver
                                @elseif(Auth::user()->level == 'silver')
                                    {{ 1000 - Auth::user()->total_poin }} poin lagi menuju Gold
                                @else
                                    Selamat! Anda telah mencapai level tertinggi
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient p-3 rounded">
                                <i class="fas fa-trash-alt fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Sampah</p>
                            <h4 class="mb-0">{{ number_format($totalSampah, 2) }} kg</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient p-3 rounded">
                                <i class="fas fa-money-bill-wave fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Pendapatan</p>
                            <h4 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient p-3 rounded">
                                <i class="fas fa-gift fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Redeem</p>
                            <h4 class="mb-0">{{ number_format($totalRedeem) }}x</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient p-3 rounded">
                                <i class="fas fa-store fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Barang Bekas</p>
                            <h4 class="mb-0">{{ number_format($totalPembelian) }} item</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    @if(!Auth::user()->isAdmin())
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-4">Menu Utama</h5>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="bg-primary bg-gradient p-3 rounded-circle d-inline-block">
                            <i class="fas fa-trash-alt fa-3x text-white"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Setor Sampah</h5>
                    <p class="card-text text-muted mb-4">Setorkan sampah Anda dan dapatkan poin untuk setiap kilogramnya</p>
                    <a href="{{ route('sampah.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Setor Sekarang
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="bg-success bg-gradient p-3 rounded-circle d-inline-block">
                            <i class="fas fa-gift fa-3x text-white"></i>
                        </div>
                    </div>
                    <h5 class="card-title">Redeem Poin</h5>
                    <p class="card-text text-muted mb-4">Tukarkan poin Anda dengan berbagai hadiah menarik</p>
                    <a href="{{ route('redeem.index') }}" class="btn btn-success">
                        <i class="fas fa-exchange-alt me-2"></i>Tukar Poin
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush 