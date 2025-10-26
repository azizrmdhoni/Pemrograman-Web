<?php
include "config.php";

if (isset($_POST['simpan'])) {
    $id       = $_POST['id'];
    $nama     = $_POST['nama'];
    $alamat   = $_POST['alamat'];
    $jk       = $_POST['jenis_kelamin'];
    $agama    = $_POST['agama'];
    $sekolah  = $_POST['sekolah_asal'];

    $update = mysqli_query($db, "
        UPDATE calon_siswa 
        SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah' 
        WHERE id='$id'
    ");

    if ($update) {
        echo "<script>
                alert('Perubahan data berhasil disimpan!');
                window.location='list-siswa.php';
              </script>";
    } else {
        echo "Gagal menyimpan perubahan!";
    }
} else {
    echo "Akses tidak sah!";
}
?>
