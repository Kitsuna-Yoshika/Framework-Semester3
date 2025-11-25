@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm card-table">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Anggota</h5>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Anggota
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body p-0">
            {{-- Tabel Anggota --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $a)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $a->nim }}</td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->prodi }}</td>
                            <td class="text-center">
                                <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data anggota.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabel Users --}}
        <div class="card shadow-sm card-table mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Users (Kelola Profil)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nim }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <button type="button"
                                                class="btn btn-info btn-sm mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUserModal-{{ $user->id }}">
                                            Edit Profil
                                        </button>
                                    @endif
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini? ID akan diurutkan ulang.')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="redirect_to" value="anggota">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus User</button>
                                    </form>
                                </td>
                            </tr>

                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <!-- Modal Edit User -->
                                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Edit Profil: {{ $user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="redirect_to" value="anggota">
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nama Lengkap</label>
                                                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">NIM</label>
                                                            <input type="text" name="nim" class="form-control" value="{{ old('nim', $user->nim) }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Role</label>
                                                            <select name="role" class="form-select" required>
                                                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                                                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Password Baru</label>
                                                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti">
                                                            <small class="text-muted">Minimal 8 karakter. Kosongkan bila ingin mempertahankan password lama.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data user.
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
@endsection