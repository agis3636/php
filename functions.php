<?php
// koneksi ke database/DBMS
$agisdb = mysqli_connect("localhost","root","","phpdasar");


function query($query) {
    global $agisdb;
    $result = mysqli_query($agisdb, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] =$row;
    }
    return $rows;
}


//--------------------------------------------------------------------------------------

function tambah ($data) {
    global $agisdb;
    //ambil data dari tiap element dalam form
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    //upload gambar
    $gambar = upload();
    if( !$gambar) {
        return false;
    }

    //query insert data
    $query = "INSERT INTO mahasiswa
                VALUES
            ('' , '$nrp' , '$nama' , '$email' , '$jurusan' , '$gambar')
            ";

    mysqli_query($agisdb, $query);

    return mysqli_affected_rows($agisdb);
}

//------------------------------------------------------------------------
function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada  gambar yang diupload
    if( $error === 4 ) {
        echo "<script>
                alert('pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    //cek apakah yang di upload adalahh gambar
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('yang lu upload bkan gambar gblok!');;
            </script>";
        return false;
    }

    //cek jika ukurannya terlalu besar
    if( $ukuranFile > 300000 ) {
        echo "<script>
                alert('KEGEDEAN GAMBARNYA!');
            </script>";
        return false;
    }

    //lolos pengecekan, gambar siap diupload

    //generate nama gambar baru, untuk gambar yang beda tapi nama sama , dan bakal di ubah nama nya di database
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;
    // var_dump($namaFileBaru); die;


    move_uploaded_file($tmpName, 'gambar/' . $namaFileBaru);

    return $namaFileBaru;
}

//___________________________________________________________________________________

function hapus ($id) {
    global $agisdb;
    mysqli_query($agisdb, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($agisdb);
}

//_____________________________________________________________________________________________


function ubah($data) {
    global $agisdb;

    //ambil data dari tiap element dalam form

    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama= htmlspecialchars($data["gambarLama"]);

    //CEK apakah user pilih gambar baru atau ga ngubah gambar
    if($_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    //query insert data
    $query = "UPDATE mahasiswa SET
                nrp = '$nrp' ,
                nama = '$nama' ,
                email = '$email' ,
                jurusan = '$jurusan' ,
                gambar = '$gambar'
                WHERE id = $id
            ";

    mysqli_query($agisdb, $query);

    return mysqli_affected_rows($agisdb);
}


//--------------------------------------------------------------------------------------------
function cari($keyword) {
    $query = "SELECT * FROM mahasiswa
                WHERE
              nama LIKE '%$keyword%' OR
              nrp LIKE '%$keyword%' OR
              email LIKE '%$keyword%' OR
              jurusan LIKE '%$keyword%'
            ";
        return query($query);
}


//--------------------------------------------------------------------------------

function registrasi($data) {
    global $agisdb;

    $username = strtolower ( stripslashes( $data["username"] ) );
    $password = mysqli_real_escape_string($agisdb, $data["password"]);
    $password2 = mysqli_real_escape_string($agisdb, $data["password2"]);


    // cek username sudah ada atau belum
    $result = mysqli_query($agisdb,"SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('user sudah ada / terdaftar!');
            </script>";
        return false;
    }



    //cek konfirmasi password
    if( $password !== $password2 ) {
        echo "<script>
                alert('konfirmasi password tdk sesuai!');
            </script>";
        return false;
    }
    // return 1;

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    //jangan pakai md 5 karena bahaya, enkripsinya bisa di translate di google!
    // $password = md5($password);
    // var_dump($password); die;

    //tambah user baru ke database
    mysqli_query($agisdb, "INSERT INTO user VALUES('','$username','$password')");

    return mysqli_affected_rows($agisdb);

    

}











?>