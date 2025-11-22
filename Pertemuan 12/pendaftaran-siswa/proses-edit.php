<?php
include "config.php";

if (isset($_POST['simpan'])) {
    $id       = $_POST['id'];
    $nama     = $_POST['nama'];
    $alamat   = $_POST['alamat'];
    $jk       = $_POST['jenis_kelamin'];
    $telepon  = $_POST['telepon'];
    $agama    = $_POST['agama'];
    $sekolah  = $_POST['sekolah_asal'];

    if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        
        $query_foto = mysqli_query($db, "SELECT foto FROM calon_siswa WHERE id='$id'");
        $data_foto = mysqli_fetch_assoc($query_foto);
        $foto_lama = "images/" . $data_foto['foto'];

        if (file_exists($foto_lama) && !empty($data_foto['foto'])) {
            unlink($foto_lama);
        }

        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        $fotobaru = date('dmYHis') . $foto;
        $path = "images/" . $fotobaru;

        if (move_uploaded_file($tmp, $path)) {
            $query = "UPDATE calon_siswa SET 
                        nama='$nama', 
                        alamat='$alamat', 
                        jenis_kelamin='$jk', 
                        telepon='$telepon',
                        agama='$agama', 
                        sekolah_asal='$sekolah', 
                        foto='$fotobaru' 
                      WHERE id='$id'";
        } else {
            echo "<script>alert('Gagal upload foto baru!'); window.location='list-siswa.php';</script>";
            exit;
        }
    } else {
        $query = "UPDATE calon_siswa SET 
                    nama='$nama', 
                    alamat='$alamat', 
                    jenis_kelamin='$jk', 
                    telepon='$telepon',
                    agama='$agama', 
                    sekolah_asal='$sekolah' 
                  WHERE id='$id'";
    }

    $update = mysqli_query($db, $query);

    if ($update) {
        echo "<script>alert('Perubahan data berhasil disimpan!'); window.location='list-siswa.php';</script>";
    } else {
        echo "Gagal menyimpan perubahan!";
    }
} else {
    echo "Akses tidak sah!";
}
?>