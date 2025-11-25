<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>
    <form action="{{ url('buku/save') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="id" value="{{ $id ?? '' }}" />
        <input type="hidden" name="is_update" value="{{ $is_update ?? 0 }}" />
        
        Judul: <input type="text" name="judul" value="{{ $judul ?? '' }}" size="50" maxlength="100" />
        <br/><br/>
        
        Pengarang: <input type="text" name="pengarang" value="{{ $pengarang ?? '' }}" size="50" maxlength="150" />
        <br/><br/>
        
        Kategori: <select name="kategori">
            @foreach($optkategori as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <br/><br/>
        
        <input type="submit" name="btn_simpan" value="Simpan" />
    </form>
    <br/>
    <a href="{{ url('buku') }}">Kembali</a>
</body>
</html>