<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamUserController extends Controller
{
    public function index()
    {
        // Buku yang tersedia (stok > 0)
        $buku_tersedia = Buku::where('stok', '>', 0)->get();
        return view('user.pinjam.index', compact('buku_tersedia'));
    }

    public function create($buku_id)
    {
        $buku = Buku::findOrFail($buku_id);
        
        // Ambil NIM dari user yang login
        $userNim = Auth::user()->nim;
        
        // Cari anggota berdasarkan NIM yang sama dengan user yang login
        $anggota = Anggota::where('nim', $userNim)->firstOrFail();
        
        return view('user.pinjam.create', compact('buku', 'anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'buku_id' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        // Ambil NIM dari user yang login
        $userNim = Auth::user()->nim;
        
        // Cari anggota berdasarkan NIM yang sama dengan user yang login
        $anggota = Anggota::where('nim', $userNim)->firstOrFail();
        
        // Validasi bahwa anggota_id yang dikirim sesuai dengan anggota yang login
        if ($request->anggota_id != $anggota->id) {
            return back()->withErrors(['anggota_id' => 'Anggota tidak sesuai dengan user yang login.'])->withInput();
        }

        $buku = Buku::findOrFail($request->buku_id);
        
        // Cek stok
        if ($buku->stok <= 0) {
            return back()->withErrors(['buku_id' => 'Buku tidak tersedia.'])->withInput();
        }

        // Kurangi stok
        $buku->stok -= 1;
        $buku->save();

        Pinjam::create($request->all());
        
        return redirect()->route('user.pinjam.index')
            ->with('success', 'Peminjaman berhasil! Stok buku dikurangi.');
    }
}

