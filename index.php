<?php
session_start();

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

//-----------------------------------------------------------------------------

require 'functions.php';

//PAGINATION
//konfigurasi
$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// $result = mysqli_query($agisdb, "SELECT * FROM mahasiswa");
// $jumlahData = mysqli_num_rows($result);
// var_dump($jumlahData);

//round membulatkan bilangan pecahan ke desimal terdekat
//floor membulatkan ke bawah
//ceil membulatkan ke atas

// $mahasiswa = query("SELECT * FROM mahasiswa LIMIT 1, 2" );
$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman" );

//MENAMPILKAN SEMUA DATA
// $mahasiswa = query("SELECT * FROM mahasiswa");
// $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id ASC");
// $mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");
// $mahasiswa = query("SELECT * FROM mahasiswa WHERE nrp = '123' ");

//tombol cari di tekan
if(isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>

    <style>
        .gambarLoading {
            width: 40px;
            position: absolute;
            top: 200px;
            left: 400px;
            z-index: -1;
            display: none;
        }
        @media print {
            .logout, .tambah, .form-cari, .nav, .aksi {
                display: none;
            }
        }
    </style>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    
    <a href="logout.php" class="logout">Logout</a> | <a href="cetak.php" target="_blank">cetak pdf</a>
    
    <h1>daftar mahasiswa</h1>
    <br><br><br>
    <a href="tambah.php" class="tambah">tambah data mahasiswa</a>
    <br><br>

<!-- ----------------------------------------------------------------------------------------------------------------------------- -->

    <form action="" method="post" class="form-cari">
        <input type="text" name="keyword" size="50" autofocus placeholder="nyari apa lu bro  ??" autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombol-cari">CAri!!</button>

        <img src="gambar/giphy.gif" class="gambarLoading">

    </form>

<!-- ----------------------------------------------------------------------------------------------------------------------------- -->

<!-- navigasi -->

    <br><br>
<div class="nav">
    <?php if( $halamanAktif > 1 ) : ?>
        <a href="?halaman= <?=$halamanAktif -1; ?>">&lt;-&laquo;</a>
    <?php endif; ?>

    <?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
        <?php if( $i == $halamanAktif) : ?>
            <a href=" ?halaman= <?= $i; ?> " style="font-weight: bold; color:red; "> <?= $i; ?> </a>
        <?php else : ?>
            <a href=" ?halaman= <?= $i; ?> "> <?= $i; ?> </a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if( $halamanAktif < $jumlahHalaman ) : ?>
        <a href="?halaman= <?=$halamanAktif +1; ?>">&raquo;-&gt;</a>
    <?php endif; ?>
</div>
    <br><br><br>

<!-- ----------------------------------------------------------------------------------------------------------------------------- -->

    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">

            <tr>
                <th>No.</th>
                <th class="aksi">Aksi</th>
                <th>Gambar</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>

            <?php $i =1; ?>
            <?php foreach( $mahasiswa as $row ) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td class="aksi">
                    <a href="ubah.php?id= <?= $row["id"];?> ">Ubah !</a> - 
                    <a href="hapus.php?id= <?= $row["id"]; ?> " onclick="return confirm('yakin?');">Hapus !</a>
                </td>
                <td><img src="gambar/<?= $row["gambar"]; ?>"width="50"></td>
                <td><?= $row["nrp"]; ?></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?= $row["jurusan"]; ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
<!-- <script src="js/jquery-3.5.1.min.js"></script>
<script src="js/script.js"></script> -->

</body>
</html>