<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan.
     */
    public function authorize(): bool
    {
        return true; // WAJIB true supaya validasi bisa digunakan
    }

    /**
     * Aturan validasi form.
     */
    public function rules(): array
    {
        return [
            'judul'    => 'required|min:3|max:100',
            'penulis'  => 'required|min:3|max:50',
            'penerbit' => 'required|min:3|max:50',
            'tahun'    => 'required|digits:4|integer',
            'stok'     => 'required|integer|min:1',
        ];
    }
}