<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Mahasiswa</title>
</head>
<body>
    <h1>Saya adalah mahasiswa Program Studi :</h1>
    <?php 
    if($prodi=="TI")
        echo "Teknologi Informasi";
    elseif($prodi=="SI")
        echo "Sistem Informasi";
    else if($prodi=="IL")
        echo "Ilmu Komputer";
    else
        echo "Tidak ada prodi tersebut di fakultas TIK";
    ?>
</body>
</html>