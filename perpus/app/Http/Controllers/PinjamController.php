<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    public function index()
    {
        $pinjam = Pinjam::with(['anggota', 'buku'])->get();
        return view('pinjam.index', compact('pinjam'));
    }

    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::all();
        return view('pinjam.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required',
            'buku_id' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        Pinjam::create($request->all());
        return redirect()->route('pinjam.index')->with('success', 'Data peminjaman berhasil disimpan!');
    }

    public function edit(Pinjam $pinjam)
    {
        $anggota = Anggota::all();
        $buku = Buku::all();
        return view('pinjam.edit', compact('pinjam', 'anggota', 'buku'));
    }

    public function update(Request $request, Pinjam $pinjam)
    {
        $request->validate([
            'anggota_id' => 'required',
            'buku_id' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $pinjam->update($request->all());
        return redirect()->route('pinjam.index')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function destroy(Pinjam $pinjam)
    {
        $pinjam->delete();
        return redirect()->route('pinjam.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}