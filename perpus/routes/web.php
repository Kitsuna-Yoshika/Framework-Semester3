<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\InfoController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PinjamUserController;
use App\Http\Controllers\User\PengembalianUserController;
use App\Http\Controllers\Admin\AdminProfileController;

use App\Models\Buku;

// Halaman Home (Publik)
Route::get('/', function () {
    $buku = Buku::all();
    return view('index', compact('buku'));
})->name('home');


// Info Mahasiswa (Jika butuh)
Route::get('/info/{kl}', [InfoController::class, 'infoMhs']);


// Buku – Publik 

// Publik boleh lihat daftar buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

// Bagian CRUD wajib login sebagai admin
Route::middleware(['auth', 'admin'])->group(function () {

    // Create - HARUS sebelum route dengan parameter {buku}
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');

    // Edit
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');

    // Delete
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});



// Anggota & Pinjam – Semua wajib login
Route::middleware(['auth'])->group(function () {
    Route::resource('anggota', AnggotaController::class);
    Route::resource('pinjam', PinjamController::class);
});


// Login & Register & Logout Routes

// Login
Route::get('/login', [LoginController::class,'showLogin'])->name('login');

// Register
Route::get('/register', [RegisterController::class,'showRegister'])->name('register');
Route::post('/register', [RegisterController::class,'register'])->name('register.post');

// Logout
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

// Limit percobaan login: max 5x per menit
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post')
    ->middleware('throttle:5,1');


// Dashboard User & Admin
Route::middleware(['auth','user'])->group(function(){
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // Profile User
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.updatePassword');
    
    // Peminjaman User
    Route::get('/user/pinjam', [PinjamUserController::class, 'index'])->name('user.pinjam.index');
    Route::get('/user/pinjam/create/{buku_id}', [PinjamUserController::class, 'create'])->name('user.pinjam.create');
    Route::post('/user/pinjam', [PinjamUserController::class, 'store'])->name('user.pinjam.store');
    
    // Pengembalian User
    Route::get('/user/pengembalian', [PengembalianUserController::class, 'index'])->name('user.pengembalian.index');
    Route::delete('/user/pengembalian/{id}', [PengembalianUserController::class, 'kembalikan'])->name('user.pengembalian.kembalikan');
});

Route::middleware(['auth','admin'])->group(function(){
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    
    // Profile Admin
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::post('/admin/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.updatePassword');
    
    // User Management (hanya admin)
    Route::resource('users', UserController::class);
});
