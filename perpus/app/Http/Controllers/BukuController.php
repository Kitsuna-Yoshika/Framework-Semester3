<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Http\Requests\BukuRequest;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::paginate(5);

        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(BukuRequest $request)
    {
        Buku::create($request->validated());

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(BukuRequest $request, Buku $buku)
    {
        $buku->update($request->validated());

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus!');
    }
}