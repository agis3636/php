<?php

session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

//-----------------------------------------------------------------------------

require 'functions.php';

//ambil data di url
$id = $_GET["id"];

//query data mahasiswa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


// cek apakah tombol submit sudah di tekan atau belum
if(isset($_POST["submit"])){ 
    //cek apakah data berhasil diubah atau tidak
    if (ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ngubah data mahasiswa</title>
</head>
<body>
    <h1>update data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value=" <?= $mhs["id"]; ?>">
        <input type="hidden" name="gambarLama" value=" <?= $mhs["gambar"]; ?>">
        <ul>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required
                value=" <?= $mhs["nrp"]; ?>">
            </li><br>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required
                value=" <?= $mhs["nama"]; ?>">
            </li><br>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" required
                value=" <?= $mhs["email"]; ?>">
            </li><br>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required
                value=" <?= $mhs["jurusan"]; ?>">
            </li><br>
            <li>
                <label for="gambar">Gambar :</label><br>
                <img src="gambar/<?= $mhs['gambar']; ?>" width="60"><br>
                <input type="file" name="gambar" id="gambar"><br>
            </li><br>
            
            <button type="submit" name="submit">ubah data !</button>
            
        </ul>
    
    </form>
</body>
</html>