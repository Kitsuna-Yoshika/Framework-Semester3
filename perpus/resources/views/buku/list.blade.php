<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
</head>
<body>
    <h1>Daftar Buku</h1>
    <a href="{{ url('buku/add') }}">Tambah Buku Baru</a>
    <br/><br/>
    
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($query as $index => $buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $buku->Judul }}</td>
                <td>{{ $buku->Pengarang }}</td>
                <td>{{ $optkategori[$buku->Kategori] ?? $buku->Kategori }}</td>
                <td>
                    <a href="{{ url('buku/edit/' . $buku->id) }}">Edit</a>
                    <a href="{{ url('buku/delete/' . $buku->id) }}" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>