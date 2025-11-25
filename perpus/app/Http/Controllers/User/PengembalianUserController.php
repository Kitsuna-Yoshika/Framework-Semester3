<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pinjam;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianUserController extends Controller
{
    public function index()
    {
        // Ambil NIM dari user yang login
        $userNim = Auth::user()->nim;
        
        // Cari anggota berdasarkan NIM
        $anggota = \App\Models\Anggota::where('nim', $userNim)->first();
        
        if (!$anggota) {
            // Jika anggota tidak ditemukan, return empty collection
            $pengembalian = collect();
        } else {
            // Peminjaman yang belum dikembalikan sesuai dengan NIM user yang login
            $pengembalian = Pinjam::with(['anggota', 'buku'])
                ->where('anggota_id', $anggota->id)
                ->orderBy('tgl_kembali', 'asc')
                ->get();
        }
        
        return view('user.pengembalian.index', compact('pengembalian'));
    }

    public function kembalikan($id)
    {
        // Ambil NIM dari user yang login
        $userNim = Auth::user()->nim;
        
        // Cari anggota berdasarkan NIM
        $anggota = \App\Models\Anggota::where('nim', $userNim)->first();
        
        if (!$anggota) {
            return redirect()->route('user.pengembalian.index')
                ->with('error', 'Anggota tidak ditemukan!');
        }
        
        $pinjam = Pinjam::where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->firstOrFail();
        
        $buku = $pinjam->buku;
        
        // Tambah stok kembali
        $buku->stok += 1;
        $buku->save();
        
        // Hapus data peminjaman
        $pinjam->delete();
        
        return redirect()->route('user.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan! Stok buku ditambah.');
    }
}

