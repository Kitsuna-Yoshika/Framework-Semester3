@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard User</h2>
    <p class="text-muted">Selamat datang, {{ Auth::user()->name }}!</p>

    <div class="row g-4">
        <!-- Card Buku -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Buku</h5>
                    <p class="card-text">Lihat daftar buku yang tersedia</p>
                    <a href="{{ route('buku.index') }}" class="btn btn-primary">Lihat Buku</a>
                </div>
            </div>
        </div>

        <!-- Card Peminjaman -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Peminjaman</h5>
                    <p class="card-text">Pinjam buku yang tersedia</p>
                    <a href="{{ route('user.pinjam.index') }}" class="btn btn-success">Pinjam Buku</a>
                </div>
            </div>
        </div>

        <!-- Card Pengembalian -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Pengembalian</h5>
                    <p class="card-text">Lihat buku yang perlu dikembalikan</p>
                    <a href="{{ route('user.pengembalian.index') }}" class="btn btn-warning">Lihat Pengembalian</a>
                </div>
            </div>
        </div>

        <!-- Card Profile -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">Kelola profil dan ubah password</p>
                    <a href="{{ route('user.profile') }}" class="btn btn-info">Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cepat -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Statistik</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h4>{{ $total_buku ?? 0 }}</h4>
                            <p class="text-muted">Total Buku</p>
                        </div>
                        <div class="col-md-4">
                            <h4>{{ $buku_tersedia ?? 0 }}</h4>
                            <p class="text-muted">Buku Tersedia</p>
                        </div>
                        <div class="col-md-4">
                            <h4>{{ $peminjaman_aktif ?? 0 }}</h4>
                            <p class="text-muted">Peminjaman Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection