@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Peminjaman Buku</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Form Tambah Peminjaman</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pinjam.store') }}" method="POST" class="w-100">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Anggota <span class="text-danger">*</span></label>
                        <select name="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama }} ({{ $a->nim }})
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Buku <span class="text-danger">*</span></label>
                        <select name="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->judul }} - {{ $b->penulis }}
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_pinjam" class="form-control @error('tgl_pinjam') is-invalid @enderror" 
                               value="{{ old('tgl_pinjam', date('Y-m-d')) }}" required>
                        @error('tgl_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_kembali" class="form-control @error('tgl_kembali') is-invalid @enderror" 
                               value="{{ old('tgl_kembali') }}" required>
                        @error('tgl_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Tanggal kembali harus setelah tanggal pinjam</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('pinjam.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection