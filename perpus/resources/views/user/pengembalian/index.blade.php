@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Buku yang Perlu Dikembalikan</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @error('error')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @enderror

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Data Pengembalian Buku</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Penulis</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalian as $p)
                            @php
                                $tgl_kembali = \Carbon\Carbon::parse($p->tgl_kembali);
                                $hari_ini = \Carbon\Carbon::today();
                                $is_terlambat = $tgl_kembali->lt($hari_ini);
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->buku->penulis }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    @if($is_terlambat)
                                        <span class="badge bg-danger">Terlambat</span>
                                    @elseif($tgl_kembali->isToday())
                                        <span class="badge bg-warning">Hari Ini</span>
                                    @else
                                        <span class="badge bg-success">Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('user.pengembalian.kembalikan', $p->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-success btn-sm">Kembalikan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada buku yang perlu dikembalikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection

