@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jenis Sampah {{ $jenis_sampah }}</h1>
        <div>
            <a href="{{ route('admin.sampah.organik') }}" class="btn btn-success {{ $jenis_sampah === 'Organik' ? 'active' : '' }}">
                <i class="fas fa-leaf fa-sm"></i> Sampah Organik
            </a>
            <a href="{{ route('admin.sampah.non-organik') }}" class="btn btn-info {{ $jenis_sampah === 'Non-Organik' ? 'active' : '' }}">
                <i class="fas fa-recycle fa-sm"></i> Sampah Non-Organik
            </a>
            <a href="{{ route('admin.sampah.create') }}" class="btn btn-primary">
                <i class="fas fa-plus fa-sm"></i> Tambah Jenis Sampah
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($sampahs as $sampah)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <img src="{{ asset('storage/' . $sampah->gambar) }}" class="card-img-top" alt="{{ $sampah->nama }}" 
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold text-primary">{{ $sampah->nama }}</h5>
                    <p class="card-text">
                        <span class="badge badge-{{ $sampah->jenis_sampah === 'organik' ? 'success' : 'info' }}">
                            {{ ucfirst($sampah->jenis) }}
                        </span>
                    </p>
                    <p class="card-text">
                        <strong>Harga:</strong> Rp {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}/kg<br>
                        <strong>Poin:</strong> {{ $sampah->poin_per_kg }} poin/kg
                    </p>
                    <div class="btn-group">
                        <a href="{{ route('admin.sampah.edit', $sampah) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.sampah.destroy', $sampah) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus jenis sampah ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Belum ada data sampah {{ strtolower($jenis) }}.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection 