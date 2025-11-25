<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi dasar
        $rules = [
            'name'  => 'required|string|max:100',
            'nim'   => 'required|unique:users|regex:/^[AU]\.\d{3}\.\d{2}\.\d{4}$/',
            'email' => 'required|email|unique:users',
            'password_option' => 'required|in:generate,set'
        ];

        // Jika memilih set password sendiri, validasi password
        if ($request->password_option === 'set') {
            $rules['password'] = 'required|string|min:8';
        }

        // Jika NIM dimulai dengan U, wajibkan prodi
        if (str_starts_with($request->nim, 'U.')) {
            $rules['prodi'] = 'required|string|max:100';
        }

        $request->validate($rules);

        // ROLE otomatis berdasarkan format NIM
        $role = str_starts_with($request->nim, 'A.') ? 'admin' : 'user';

        // Tentukan password
        if ($request->password_option === 'generate') {
            // Autogenerate password
            $plainPassword = Str::random(10);
            $hashedPassword = Hash::make($plainPassword);
            $showPassword = true;
        } else {
            // Gunakan password yang diinput user
            $plainPassword = $request->password;
            $hashedPassword = Hash::make($plainPassword);
            $showPassword = false;
        }

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'nim'      => $request->nim,
            'email'    => $request->email,
            'password' => $hashedPassword,
            'role'     => $role
        ]);

        // Jika NIM dimulai dengan U, buat data anggota otomatis
        if (str_starts_with($request->nim, 'U.')) {
            // Cek apakah anggota sudah ada dengan NIM yang sama
            $anggota = Anggota::where('nim', $request->nim)->first();
            
            if (!$anggota) {
                // Buat anggota baru
                Anggota::create([
                    'nim'  => $request->nim,
                    'nama' => $request->name,
                    'prodi' => $request->prodi
                ]);
            } else {
                // Update anggota yang sudah ada
                $anggota->update([
                    'nama' => $request->name,
                    'prodi' => $request->prodi
                ]);
            }
        }

        $message = 'Registrasi berhasil!';
        if (str_starts_with($request->nim, 'U.')) {
            $message .= ' Anda telah terdaftar sebagai anggota perpustakaan.';
        }
        
        $data = ['success' => $message];
        
        // Hanya tampilkan password jika di-generate otomatis
        if ($showPassword) {
            $data['password_generated'] = $plainPassword;
        }

        return back()->with($data);
    }
}
