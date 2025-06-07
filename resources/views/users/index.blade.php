@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Kelola Users</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Level</th>
                        <th>Poin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ ucfirst($user->level) }}</td>
                        <td>{{ number_format($user->points) }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUser{{ $user->id }}">
                                Edit Role
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Role User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <select class="form-select" name="role" required>
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Level</label>
                                            <select class="form-select" name="level" required>
                                                <option value="bronze" {{ $user->level === 'bronze' ? 'selected' : '' }}>Bronze</option>
                                                <option value="silver" {{ $user->level === 'silver' ? 'selected' : '' }}>Silver</option>
                                                <option value="gold" {{ $user->level === 'gold' ? 'selected' : '' }}>Gold</option>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 