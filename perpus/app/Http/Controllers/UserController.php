<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:users,nim,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        $data = [
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->input('redirect_to') === 'anggota') {
            return redirect()->route('anggota.index')->with('success', 'Profil user berhasil diperbarui!');
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Cegah admin menghapus akun sendiri
        if (Auth::check() && Auth::id() == $user->id) {
            if ($request->input('redirect_to') === 'anggota') {
                return redirect()->route('anggota.index')
                    ->with('error', 'Tidak dapat menghapus akun sendiri!');
            }
            return redirect()->route('users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        
        // Simpan data admin yang sedang login sebelum delete
        $currentUser = Auth::check() ? Auth::user() : null;
        $currentUserId = $currentUser ? $currentUser->id : null;
        $currentUserEmail = $currentUser ? $currentUser->email : null;
        
        $user->delete();

        // Mengurutkan ulang ID setelah delete (dengan mempertahankan session admin)
        $newUserId = $this->reorderUserIds($currentUserId);

        // Refresh session admin yang sedang login setelah reorder
        if ($currentUser && Auth::check()) {
            // Cari user dengan email (lebih reliable daripada ID yang mungkin berubah)
            $updatedUser = User::where('email', $currentUserEmail)->first();
            if ($updatedUser) {
                // Update session dengan user yang baru
                Auth::login($updatedUser);
                $request->session()->regenerate();
            }
        }

        // Cek apakah redirect ke halaman anggota
        if ($request->input('redirect_to') === 'anggota') {
            return redirect()->route('anggota.index')
                ->with('success', 'User berhasil dihapus dan ID diurutkan ulang!');
        }

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus dan ID diurutkan ulang!');
    }

    /**
     * Mengurutkan ulang ID users secara berurutan mulai dari 1
     * @param int|null $currentUserId ID user yang sedang login (untuk mempertahankan session)
     */
    private function reorderUserIds($currentUserId = null)
    {
        try {
            // Disable foreign key checks sementara (untuk MySQL/MariaDB)
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Ambil semua users yang tersisa, diurutkan berdasarkan ID lama
            $users = User::orderBy('id', 'asc')->get();

            if ($users->isEmpty()) {
                // Jika tidak ada user, reset AUTO_INCREMENT ke 1
                DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                return;
            }

            // Simpan mapping ID lama ke ID baru untuk user yang sedang login
            $currentUserNewId = null;

            // Update ID secara berurutan mulai dari 1
            $newId = 1;
            foreach ($users as $user) {
                if ($user->id != $newId) {
                    // Jika ini adalah user yang sedang login, simpan ID barunya
                    if ($currentUserId && $user->id == $currentUserId) {
                        $currentUserNewId = $newId;
                    }
                    
                    // Update ID user dengan menggunakan temporary ID untuk menghindari konflik
                    $tempId = 999999 + $newId; // ID sementara yang besar
                    
                    // Update ke ID sementara dulu
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['id' => $tempId]);
                    
                    // Kemudian update ke ID yang sebenarnya
                    DB::table('users')
                        ->where('id', $tempId)
                        ->update(['id' => $newId]);
                } else {
                    // Jika ID sudah benar, tapi ini user yang sedang login
                    if ($currentUserId && $user->id == $currentUserId) {
                        $currentUserNewId = $newId;
                    }
                }
                $newId++;
            }

            // Reset AUTO_INCREMENT
            $maxId = User::max('id') ?? 0;
            DB::statement("ALTER TABLE users AUTO_INCREMENT = " . ($maxId + 1));

            // Enable foreign key checks kembali
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            // Return ID baru untuk user yang sedang login jika ada perubahan
            return $currentUserNewId;
        } catch (\Exception $e) {
            // Jika terjadi error, enable kembali foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            // Log error jika diperlukan
            \Log::error('Error reordering user IDs: ' . $e->getMessage());
            return null;
        }
    }
}

