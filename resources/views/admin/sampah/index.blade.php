@extends('admin.layouts.app')

@section('title', 'Kelola Jenis Sampah')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Jenis Sampah</h5>
                <a href="{{ route('admin.sampah.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus me-1"></i>
                    Tambah Jenis Sampah
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga/Kg</th>
                                <th>Poin/Kg</th>
                                <th>Deskripsi</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jenisSampahs as $jenisSampah)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jenisSampah->nama }}</td>
                                <td>
                                    <span class="badge bg-{{ $jenisSampah->kategori === 'organik' ? 'success' : 'warning' }}">
                                        {{ ucfirst($jenisSampah->kategori) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($jenisSampah->harga_per_kg, 0, ',', '.') }}</td>
                                <td>{{ number_format($jenisSampah->poin_per_kg) }}</td>
                                <td>{{ $jenisSampah->deskripsi ?: '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.sampah.edit', $jenisSampah->id) }}" 
                                           class="btn btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.sampah.destroy', $jenisSampah->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus jenis sampah ini?')"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data jenis sampah</td>
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