<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pinjam;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $total_buku = Buku::count();
        $buku_tersedia = Buku::where('stok', '>', 0)->count();
        $peminjaman_aktif = Pinjam::where('tgl_kembali', '>=', Carbon::today())->count();

        return view('user.dashboard', compact('total_buku', 'buku_tersedia', 'peminjaman_aktif'));
    }
}

