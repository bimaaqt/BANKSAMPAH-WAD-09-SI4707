@extends('admin.layouts.app')

@section('title', 'Kelola Redeem')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Reward List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Reward</h5>
                    <a href="{{ route('admin.redeem.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus me-1"></i>Tambah Reward
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Poin</th>
                                    <th>Stok</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rewards as $reward)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reward->name }}</td>
                                    <td>{{ Str::limit($reward->description, 50) }}</td>
                                    <td>{{ number_format($reward->points_required) }}</td>
                                    <td>{{ number_format($reward->stock) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.redeem.edit', $reward->id) }}" 
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.redeem.destroy', $reward->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus reward ini?')"
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada reward</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Redeem History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Riwayat Penukaran</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Pengguna</th>
                                    <th>Reward</th>
                                    <th>Jumlah</th>
                                    <th>Poin Digunakan</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($redeems as $redeem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $redeem->redeemed_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $redeem->user->name }}</td>
                                    <td>{{ $redeem->reward->name }}</td>
                                    <td>{{ $redeem->quantity }}</td>
                                    <td>{{ number_format($redeem->points_spent) }}</td>
                                    <td>
                                        <form action="{{ route('admin.redeem.destroy', $redeem->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan penukaran ini? Poin akan dikembalikan ke user.')"
                                                    title="Batalkan">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada riwayat penukaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 