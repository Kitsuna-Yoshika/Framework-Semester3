@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pinjam Buku</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Form Peminjaman Buku: {{ $buku->judul }}</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.pinjam.store') }}">
                @csrf

                <input type="hidden" name="buku_id" value="{{ $buku->id }}">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Buku</label>
                        <input type="text" class="form-control" value="{{ $buku->judul }} - {{ $buku->penulis }}" readonly>
                        <small class="form-text text-muted">Stok tersedia: {{ $buku->stok }}</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Anggota <span class="text-danger">*</span></label>
                        <input type="hidden" name="anggota_id" value="{{ $anggota->id }}">
                        <input type="text" 
                               class="form-control" 
                               value="{{ $anggota->nama }} ({{ $anggota->nim }})" 
                               readonly>
                        <small class="form-text text-muted">Otomatis sesuai dengan NIM yang login</small>
                        @error('anggota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                        <input type="date" 
                               name="tgl_pinjam" 
                               class="form-control @error('tgl_pinjam') is-invalid @enderror" 
                               value="{{ old('tgl_pinjam', date('Y-m-d')) }}" 
                               required>
                        @error('tgl_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" 
                               name="tgl_kembali" 
                               class="form-control @error('tgl_kembali') is-invalid @enderror" 
                               value="{{ old('tgl_kembali') }}" 
                               required>
                        @error('tgl_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Harus setelah atau sama dengan tanggal pinjam</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('user.pinjam.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-book"></i> Pinjam Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

