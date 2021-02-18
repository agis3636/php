// console.log('ok');
    // ambil elemen-element yang di butuhkan

var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

// tombolCari.addEventListener('mouseover', function() {
//     alert('berhasil');
// });

    // tambahkan event ketika keyword di tulis
keyword.addEventListener('keyup', function() {
    // alert('ok');
    // console.log(keyword.value);

        //buat object ajax
    var xhr = new XMLHttpRequest();

        //cek kesiapan ajax
    xhr.onreadystatechange = function() {
        if( xhr.readyState == 4 && xhr.status == 200 ) {
            // console.log(xhr.responseText);
            container.innerHTML = xhr.responseText;
        }
    }

        //eksekusi ajax
    xhr.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);
    xhr.send();
});