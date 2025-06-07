@extends('admin.layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Profil Admin</h5>
            </div>
            <div class="card-body">
                <!-- @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif -->

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-primary me-3">
                            <i class="bi bi-person-circle fs-1"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                            <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-4">
                    <h6 class="mb-3">Ubah Password</h6>
                    <form action="{{ route('admin.profile.update-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-key me-2"></i>
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 