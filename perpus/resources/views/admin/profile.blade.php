@extends('layouts.app')

@section('content')
<div class="container" style="max-width:600px;">
    <h2 class="mb-4">Profile Admin</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0">Informasi Akun</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama</label>
                <p class="form-control-plaintext">{{ $user->name }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">NIM</label>
                <p class="form-control-plaintext">{{ $user->nim }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <p class="form-control-plaintext">{{ $user->email }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <p class="form-control-plaintext">
                    <span class="badge bg-danger">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header">
            <h5 class="mb-0">Ubah Password</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.profile.updatePassword') }}">
                @csrf

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" 
                           class="form-control @error('current_password') is-invalid @enderror" 
                           id="current_password" 
                           name="current_password" 
                           required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Minimal 8 karakter</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required>
                </div>

                <button type="submit" class="btn btn-primary">Ubah Password</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

