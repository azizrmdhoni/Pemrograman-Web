<?php
include "config.php";

if (isset($_POST['daftar'])) {
    $nama     = $_POST['nama'];
    $alamat   = $_POST['alamat'];
    $jk       = $_POST['jenis_kelamin'];
    $agama    = $_POST['agama'];
    $sekolah  = $_POST['sekolah_asal'];

    $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal)
            VALUES ('$nama', '$alamat', '$jk', '$agama', '$sekolah')";

    if (mysqli_query($db, $sql)) {
        echo "<script>
                alert('Pendaftaran berhasil!');
                window.location='index.php?status=sukses';
              </script>";
    } else {
        echo "<script>
                alert('Pendaftaran gagal!');
                window.location='index.php?status=gagal';
              </script>";
    }
} else {
    echo "Akses tidak diizinkan!";
}
?>
