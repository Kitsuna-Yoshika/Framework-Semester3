@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Daftar Buku</h2>

    <div class="card shadow-sm card-table">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Buku Perpustakaan</h5>
        </div>
        <div class="card-body">
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
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($buku as $b)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $b->judul }}</td>
                                <td>{{ $b->penulis }}</td>
                                <td>{{ $b->penerbit }}</td>
                                <td>{{ $b->tahun }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $b->stok > 0 ? 'success' : 'danger' }}">
                                        {{ $b->stok }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Tidak ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection