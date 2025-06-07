@extends('admin.layouts.app')

@section('title', 'Kelola Users')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <!-- {{ session('success') }} -->
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Users</h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah User
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Total Poin</th>
                                <th>Tanggal Daftar</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $user->level === 'gold' ? 'warning' : 
                                        ($user->level === 'silver' ? 'secondary' : 'danger') 
                                    }}">
                                        {{ ucfirst($user->level) }}
                                    </span>
                                </td>
                                <td>{{ number_format($user->total_poin ?? 0) }}</td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" 
                                            class="btn btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editLevelModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-user-level="{{ $user->level }}">
                                            <i class="bi bi-award"></i>
                                        </button>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Level -->
<div class="modal fade" id="editLevelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editLevelForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Level User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Mengubah level untuk user: <strong id="userName"></strong></p>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select class="form-select" name="level" required>
                            <option value="bronze">Bronze</option>
                            <option value="silver">Silver</option>
                            <option value="gold">Gold</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editLevelModal = document.getElementById('editLevelModal');
    if (editLevelModal) {
        editLevelModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userLevel = button.getAttribute('data-user-level');
            
            const form = this.querySelector('#editLevelForm');
            const userNameElement = this.querySelector('#userName');
            
            form.action = `/admin/users/${userId}/level`;
            userNameElement.textContent = userName;
            form.querySelector('select[name="level"]').value = userLevel;
        });
    }
});
</script>
@endpush

@endsection 