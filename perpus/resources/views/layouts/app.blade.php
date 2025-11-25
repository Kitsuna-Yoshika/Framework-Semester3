<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%,rgb(21, 42, 235) 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1000;
        }
        .navbar.navbar-admin {
            background: linear-gradient(135deg,rgb(86, 18, 196) 0%,rgb(2, 99, 245) 100%);
        }
        .navbar a {
            color: white !important;
            margin-right: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 500;
        }
        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            text-decoration: none;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .navbar-brand:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        .navbar .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        .navbar .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: white;
            transform: translateY(-2px);
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .navbar .d-flex {
            display: flex !important;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        @media (max-width: 768px) {
            .navbar .d-flex {
                flex-direction: column;
                width: 100%;
                margin-top: 1rem;
            }
            .navbar .nav-link {
                width: 100%;
                text-align: center;
            }
        }
        .table {
            background-color: white;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            border: none;
        }
        h2 {
            margin-bottom: 25px;
            color: #343a40;
        }
        .container {
            margin-top: 40px;
        }
        .auth-container {
            width: min(100%, 520px);
            max-width: 520px;
            padding-left: 1rem;
            padding-right: 1rem;
            margin: 0 auto;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card.card-table {
            width: 100%;
        }
        .card.card-table .card-body {
            padding: 0;
        }
        .card.card-table .table-responsive {
            padding: 1rem;
        }
        .pagination {
            font-size: 0.875rem;
            margin-bottom: 0;
        }
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
            min-width: 36px;
            text-align: center;
        }
        .pagination svg {
            width: 16px;
            height: 16px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 {{ Auth::check() && Auth::user()->role === 'admin' ? 'navbar-admin' : '' }}">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Perpus</a>
            <div class="d-flex align-items-center flex-wrap">
                <a href="{{ route('home') }}" class="nav-link">Halaman Utama</a>
                @guest
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                @endguest
                @auth
                    @if(Auth::user()->role === 'admin')
                        {{-- Menu khusus Admin --}}
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                        <a href="{{ route('buku.index') }}" class="nav-link">Buku</a>
                        <a href="{{ route('anggota.index') }}" class="nav-link">Anggota dan Users</a>
                        <a href="{{ route('pinjam.index') }}" class="nav-link">Pinjam</a>
                        <a href="{{ route('admin.profile') }}" class="nav-link">Profile</a>
                    @else
                        {{-- Menu khusus User --}}
                        <a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a>
                        <a href="{{ route('buku.index') }}" class="nav-link">Buku</a>
                        <a href="{{ route('user.pinjam.index') }}" class="nav-link">Peminjaman</a>
                        <a href="{{ route('user.pengembalian.index') }}" class="nav-link">Pengembalian</a>
                        <a href="{{ route('user.profile') }}" class="nav-link">Profile</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container-fluid px-3 px-md-4 px-lg-5 pb-5">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>