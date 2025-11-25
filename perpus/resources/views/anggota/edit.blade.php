@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Anggota</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Form Edit Anggota</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('anggota.update', $anggota->id) }}" class="w-100">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" 
                               value="{{ old('nim', $anggota->nim) }}" placeholder="Masukkan NIM" required>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $anggota->nama) }}" placeholder="Masukkan nama lengkap" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                        <select name="prodi" class="form-select @error('prodi') is-invalid @enderror" required>
                            <option value="">-- Pilih Program Studi --</option>
                            <option value="Teknik Informatika" {{ old('prodi', $anggota->prodi) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="Sistem Informasi" {{ old('prodi', $anggota->prodi) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            <option value="Ilmu Komunikasi" {{ old('prodi', $anggota->prodi) == 'Ilmu Komunikasi' ? 'selected' : '' }}>Ilmu Komunikasi</option>
                        </select>
                        @error('prodi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection