@extends('layouts.app')

@section('title', 'Input Sampah')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $isAdmin ? 'Kelola Data Sampah' : 'Input Sampah' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(!$isAdmin)
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-scale-balanced fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Sampah Disetor</h6>
                            <h4 class="mb-0">{{ number_format($totalBerat ?? 0, 2) }} kg</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Pendapatan</h6>
                            <h4 class="mb-0">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-gradient-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Poin Diperoleh</h6>
                            <h4 class="mb-0">{{ number_format($totalPoin ?? 0, 0, ',', '.') }} poin</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">{{ $isAdmin ? 'Data Sampah' : 'Input Data Sampah' }}</h5>
                </div>
                <div class="card-body">
                    @if(!$isAdmin)
                    <form action="{{ route('sampah.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('jenis_sampah_id') is-invalid @enderror" 
                                        name="jenis_sampah_id" id="jenis_sampah_id" required>
                                        <option value="">Pilih Jenis Sampah</option>
                                        @foreach($jenisSampahs as $jenisSampah)
                                            <option value="{{ $jenisSampah->id }}" 
                                                data-harga="{{ $jenisSampah->harga_per_kg }}"
                                                data-poin="{{ $jenisSampah->poin_per_kg }}">
                                                {{ $jenisSampah->nama }} ({{ ucfirst($jenisSampah->kategori) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Jenis Sampah</label>
                                    @error('jenis_sampah_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-select @error('berat') is-invalid @enderror" 
                                        name="berat" id="berat" step="0.01" min="0.01" required>
                                    <label>Berat (kg)</label>
                                    @error('berat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                        name="deskripsi" id="deskripsi" style="height: 100px"></textarea>
                                    <label>Deskripsi (Opsional)</label>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1">Harga per Kg:</p>
                                        <h5 class="mb-0" id="displayHarga">Rp 0</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1">Poin per Kg:</p>
                                        <h5 class="mb-0" id="displayPoin">0 poin</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1">Total Estimasi:</p>
                                        <h5 class="mb-0" id="displayTotal">Rp 0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Data
                            </button>
                        </div>
                    </form>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    @if($isAdmin)
                                        <th>Nama User</th>
                                    @endif
                                    <th>Jenis</th>
                                    <th>Nama Sampah</th>
                                    <th>Berat (kg)</th>
                                    <th>Harga/kg</th>
                                    <th>Total Harga</th>
                                    <th>Total Poin</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sampahs as $sampah)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($isAdmin)
                                        <td>{{ $sampah->user->name }}</td>
                                    @endif
                                    <td>
                                        <span class="badge bg-{{ $sampah->jenis === 'organik' ? 'success' : 'primary' }}">
                                            {{ ucfirst($sampah->jenis) }}
                                        </span>
                                    </td>
                                    <td>{{ $sampah->nama }}</td>
                                    <td>{{ number_format($sampah->berat, 2) }}</td>
                                    <td>Rp {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($sampah->total_harga, 0, ',', '.') }}</td>
                                    <td>{{ number_format($sampah->total_poin, 0) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-info" title="Detail"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal{{ $sampah->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if(!$isAdmin)
                                            <button type="button" class="btn btn-warning" title="Edit"
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $sampah->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('sampah.destroy', $sampah->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $isAdmin ? '9' : '8' }}" class="text-center">
                                        Tidak ada data sampah
                                    </td>
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

<!-- Modal Detail -->
@foreach($sampahs as $sampah)
<div class="modal fade" id="detailModal{{ $sampah->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Sampah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Sampah</label>
                    <input type="text" class="form-control" value="{{ $sampah->nama }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <input type="text" class="form-control" value="{{ ucfirst($sampah->jenis) }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Berat</label>
                    <input type="text" class="form-control" value="{{ number_format($sampah->berat, 2) }} kg" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga per Kg</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($sampah->harga_per_kg, 0, ',', '.') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Harga</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($sampah->total_harga, 0, ',', '.') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Poin</label>
                    <input type="text" class="form-control" value="{{ number_format($sampah->total_poin, 0) }} poin" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" rows="3" readonly>{{ $sampah->deskripsi ?? '-' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $sampah->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Sampah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sampah.update', $sampah->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <select class="form-select @error('jenis_sampah_id') is-invalid @enderror" 
                            name="jenis_sampah_id" id="edit_jenis_sampah_id{{ $sampah->id }}" required>
                            @foreach($jenisSampahs as $jenisSampah)
                                <option value="{{ $jenisSampah->id }}" 
                                    data-harga="{{ $jenisSampah->harga_per_kg }}"
                                    data-poin="{{ $jenisSampah->poin_per_kg }}"
                                    {{ $sampah->jenis_sampah_id == $jenisSampah->id ? 'selected' : '' }}>
                                    {{ $jenisSampah->nama }} ({{ ucfirst($jenisSampah->kategori) }})
                                </option>
                            @endforeach
                        </select>
                        <label>Jenis Sampah</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control @error('berat') is-invalid @enderror" 
                            name="berat" id="edit_berat{{ $sampah->id }}" 
                            value="{{ $sampah->berat }}" step="0.01" min="0.01" required>
                        <label>Berat (kg)</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                            name="deskripsi" id="edit_deskripsi{{ $sampah->id }}" 
                            style="height: 100px">{{ $sampah->deskripsi }}</textarea>
                        <label>Deskripsi (Opsional)</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1">Harga per Kg:</p>
                                    <h5 class="mb-0" id="edit_displayHarga{{ $sampah->id }}">Rp 0</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1">Poin per Kg:</p>
                                    <h5 class="mb-0" id="edit_displayPoin{{ $sampah->id }}">0 poin</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1">Total Estimasi:</p>
                                    <h5 class="mb-0" id="edit_displayTotal{{ $sampah->id }}">Rp 0</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Input form calculation
    const jenisSampahSelect = document.getElementById('jenis_sampah_id');
    const beratInput = document.getElementById('berat');
    const displayHarga = document.getElementById('displayHarga');
    const displayPoin = document.getElementById('displayPoin');
    const displayTotal = document.getElementById('displayTotal');

    function updateDisplay() {
        const selectedOption = jenisSampahSelect.selectedOptions[0];
        const berat = parseFloat(beratInput.value) || 0;
        
        if (selectedOption) {
            const hargaPerKg = parseFloat(selectedOption.dataset.harga) || 0;
            const poinPerKg = parseInt(selectedOption.dataset.poin) || 0;
            
            displayHarga.textContent = `Rp ${hargaPerKg.toLocaleString('id-ID')}`;
            displayPoin.textContent = `${poinPerKg.toLocaleString('id-ID')} poin`;
            displayTotal.textContent = `Rp ${(hargaPerKg * berat).toLocaleString('id-ID')}`;
        } else {
            displayHarga.textContent = 'Rp 0';
            displayPoin.textContent = '0 poin';
            displayTotal.textContent = 'Rp 0';
        }
    }

    jenisSampahSelect.addEventListener('change', updateDisplay);
    beratInput.addEventListener('input', updateDisplay);

    // Edit form calculations
    @foreach($sampahs as $sampah)
    const editJenisSampahSelect{{ $sampah->id }} = document.getElementById('edit_jenis_sampah_id{{ $sampah->id }}');
    const editBeratInput{{ $sampah->id }} = document.getElementById('edit_berat{{ $sampah->id }}');
    const editDisplayHarga{{ $sampah->id }} = document.getElementById('edit_displayHarga{{ $sampah->id }}');
    const editDisplayPoin{{ $sampah->id }} = document.getElementById('edit_displayPoin{{ $sampah->id }}');
    const editDisplayTotal{{ $sampah->id }} = document.getElementById('edit_displayTotal{{ $sampah->id }}');

    function updateEditDisplay{{ $sampah->id }}() {
        const selectedOption = editJenisSampahSelect{{ $sampah->id }}.selectedOptions[0];
        const berat = parseFloat(editBeratInput{{ $sampah->id }}.value) || 0;
        
        if (selectedOption) {
            const hargaPerKg = parseFloat(selectedOption.dataset.harga) || 0;
            const poinPerKg = parseInt(selectedOption.dataset.poin) || 0;
            
            editDisplayHarga{{ $sampah->id }}.textContent = `Rp ${hargaPerKg.toLocaleString('id-ID')}`;
            editDisplayPoin{{ $sampah->id }}.textContent = `${poinPerKg.toLocaleString('id-ID')} poin`;
            editDisplayTotal{{ $sampah->id }}.textContent = `Rp ${(hargaPerKg * berat).toLocaleString('id-ID')}`;
        } else {
            editDisplayHarga{{ $sampah->id }}.textContent = 'Rp 0';
            editDisplayPoin{{ $sampah->id }}.textContent = '0 poin';
            editDisplayTotal{{ $sampah->id }}.textContent = 'Rp 0';
        }
    }

    editJenisSampahSelect{{ $sampah->id }}.addEventListener('change', updateEditDisplay{{ $sampah->id }});
    editBeratInput{{ $sampah->id }}.addEventListener('input', updateEditDisplay{{ $sampah->id }});
    
    // Initialize display
    updateEditDisplay{{ $sampah->id }}();
    @endforeach
});
</script>
@endpush

@endsection 