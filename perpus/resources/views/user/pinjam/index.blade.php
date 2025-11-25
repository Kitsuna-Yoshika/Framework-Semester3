@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Buku yang Tersedia untuk Dipinjam</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($buku_tersedia as $buku)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $buku->judul }}</h5>
                        <p class="card-text">
                            <strong>Penulis:</strong> {{ $buku->penulis }}<br>
                            <strong>Penerbit:</strong> {{ $buku->penerbit }}<br>
                            <strong>Tahun:</strong> {{ $buku->tahun }}<br>
                            <strong>Stok:</strong> <span class="badge bg-success">{{ $buku->stok }}</span>
                        </p>
                        @if($buku->stok > 0)
                            <a href="{{ route('user.pinjam.create', $buku->id) }}" class="btn btn-primary">Pinjam Buku</a>
                        @else
                            <button class="btn btn-secondary" disabled>Stok Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada buku yang tersedia untuk dipinjam.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection

