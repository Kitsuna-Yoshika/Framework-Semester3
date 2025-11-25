<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Perpus</a>
    <div>
        <a href="{{ route('buku.index') }}" class="nav-link d-inline text-light">Buku</a>
        <a href="{{ route('anggota.index') }}" class="nav-link d-inline text-light">Anggota</a>
        <a href="{{ route('pinjam.index') }}" class="nav-link d-inline text-light">Pinjam</a>
    </div>
  </div>
</nav>

@yield('content')

</body>
</html>