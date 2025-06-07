@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Barang Bekas</h1>
        <a href="{{ route('admin.barang-bekas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Barang Bekas</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">Nama Barang</th>
                            <td>{{ $barangBekas->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $barangBekas->kategori->nama }}</td>
                        </tr>
                        <tr>
                            <th>Kondisi</th>
                            <td>
                                @switch($barangBekas->kondisi)
                                    @case('baru')
                                        <span class="badge bg-success">Baru</span>
                                        @break
                                    @case('bekas_sangat_baik')
                                        <span class="badge bg-info">Bekas - Sangat Baik</span>
                                        @break
                                    @case('bekas_baik')
                                        <span class="badge bg-primary">Bekas - Baik</span>
                                        @break
                                    @case('bekas_cukup')
                                        <span class="badge bg-warning">Bekas - Cukup</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $barangBekas->kondisi }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Estimasi Poin</th>
                            <td>{{ number_format($barangBekas->estimasi_poin) }} poin</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @switch($barangBekas->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('diterima')
                                        <span class="badge bg-success">Diterima</span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $barangBekas->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $barangBekas->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $barangBekas->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    @if($barangBekas->foto)
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $barangBekas->foto) }}" 
                                 alt="Foto {{ $barangBekas->nama_barang }}" 
                                 class="img-fluid rounded">
                        </div>
                    @endif

                    <div class="mt-4">
                        <h5>Deskripsi:</h5>
                        <p class="text-muted">
                            {{ $barangBekas->deskripsi ?: 'Tidak ada deskripsi' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.barang-bekas.edit', $barangBekas->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.barang-bekas.destroy', $barangBekas->id) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 