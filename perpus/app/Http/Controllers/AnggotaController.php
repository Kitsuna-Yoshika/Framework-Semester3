<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\User;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        // Ambil semua users untuk ditampilkan di halaman anggota
        $users = User::all();
        return view('anggota.index', compact('anggota', 'users'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'prodi' => 'required',
        ]);

        Anggota::create($request->all());
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->update($request->all());
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}