<?php
include "config.php";

if (isset($_POST['daftar'])) {

    $nis      = $_POST['nis'];    
    $nama     = $_POST['nama'];
    $alamat   = $_POST['alamat'];
    $jk       = $_POST['jenis_kelamin'];
    $telepon  = $_POST['telepon'];
    $agama    = $_POST['agama'];
    $sekolah  = $_POST['sekolah_asal'];

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    
    $fotobaru = date('dmYHis').$foto;
    $path = "images/".$fotobaru;

    if(move_uploaded_file($tmp, $path)){
        
        $sql = "INSERT INTO calon_siswa (id, nama, alamat, jenis_kelamin, telepon, agama, sekolah_asal, foto)
                VALUES ('$nis', '$nama', '$alamat', '$jk', '$telepon', '$agama', '$sekolah', '$fotobaru')";

        $query = mysqli_query($db, $sql);

        if ($query) {
            echo "<script>alert('Pendaftaran berhasil!'); window.location='index.php?status=sukses';</script>";
        } else {
            $error = mysqli_error($db);
            echo "<script>alert('Pendaftaran gagal! Error: $error'); window.location='form-daftar.php';</script>";
        }

    } else {
        echo "<script>alert('Maaf, Gambar gagal diupload!'); window.location='form-daftar.php';</script>";
    }

} else {
    echo "Akses tidak diizinkan!";
}
?>