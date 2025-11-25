@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Buku</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm card-table">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Buku</h5>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Buku
                    </a>
                @endif
            @endauth
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            @endauth
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($buku as $b)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}</td>
                            <td>{{ $b->judul }}</td>
                            <td>{{ $b->penulis }}</td>
                            <td>{{ $b->penerbit }}</td>
                            <td>{{ $b->tahun }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $b->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $b->stok }}
                                </span>
                            </td>
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <td class="text-center">
                                        <a href="{{ route('buku.edit', $b->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('buku.destroy', $b->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::check() && Auth::user()->role === 'admin' ? '7' : '6' }}" class="text-center text-muted">
                                Tidak ada data buku.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="pagination-wrapper">
                {{ $buku->links() }} 
            </div>
        </div>
    </div>
</div>

@endsection