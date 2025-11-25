@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Admin</h2>
    <p class="text-muted">Selamat datang, {{ Auth::user()->name }}!</p>

    <div class="row g-4 mb-4">
        <!-- Card Buku -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Buku</h5>
                    <p class="card-text">Kelola data buku</p>
                    <a href="{{ route('buku.index') }}" class="btn btn-primary">Kelola Buku</a>
                </div>
            </div>
        </div>

        <!-- Card Anggota -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Anggota</h5>
                    <p class="card-text">Kelola data anggota</p>
                    <a href="{{ route('anggota.index') }}" class="btn btn-success">Kelola Anggota</a>
                </div>
            </div>
        </div>

        <!-- Card Peminjaman -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Peminjaman</h5>
                    <p class="card-text">Kelola data peminjaman</p>
                    <a href="{{ route('pinjam.index') }}" class="btn btn-warning">Kelola Peminjaman</a>
                </div>
            </div>
        </div>

       

    <!-- Quick Access -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Quick Access</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('buku.create') }}" class="btn btn-outline-primary w-100">+ Tambah Buku</a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('anggota.create') }}" class="btn btn-outline-success w-100">+ Tambah Anggota</a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('pinjam.create') }}" class="btn btn-outline-warning w-100">+ Tambah Peminjaman</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

