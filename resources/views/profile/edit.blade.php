@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Edit Profile</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Ubah Password (opsional)</h6>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                   id="new_password_confirmation" name="new_password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            @if(!$user->isAdmin())
            <!-- User Stats -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Statistik Akun</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-coins fa-2x text-warning me-2"></i>
                                <h4 class="mb-0">{{ number_format($user->total_poin) }}</h4>
                            </div>
                            <p class="text-muted mb-0">Total Poin</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-award fa-2x text-success me-2"></i>
                                <h4 class="mb-0">{{ ucfirst($user->level) }}</h4>
                            </div>
                            <p class="text-muted mb-0">Level</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-calendar-alt fa-2x text-primary me-2"></i>
                                <h4 class="mb-0">{{ $user->created_at->format('d M Y') }}</h4>
                            </div>
                            <p class="text-muted mb-0">Bergabung Sejak</p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <p class="mb-2">Progress Level</p>
                        @php
                            if ($user->level == 'bronze') {
                                $progress = ($user->total_poin / 500) * 100;
                                $nextLevel = 'Silver';
                                $pointsNeeded = 500 - $user->total_poin;
                            } elseif ($user->level == 'silver') {
                                $progress = (($user->total_poin - 500) / 500) * 100;
                                $nextLevel = 'Gold';
                                $pointsNeeded = 1000 - $user->total_poin;
                            } else {
                                $progress = 100;
                                $nextLevel = null;
                                $pointsNeeded = 0;
                            }
                        @endphp
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: {{ $progress }}%" 
                                 aria-valuenow="{{ $progress }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        @if($nextLevel)
                            <small class="text-muted">{{ $pointsNeeded }} poin lagi menuju {{ $nextLevel }}</small>
                        @else
                            <small class="text-success">Selamat! Anda telah mencapai level tertinggi</small>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 5px;
    }
    .progress-bar {
        border-radius: 5px;
    }
</style>
@endpush 