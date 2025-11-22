<?php
include "config.php";

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];
    $sql_cek = "SELECT foto FROM calon_siswa WHERE id='$id'";
    $query_cek = mysqli_query($db, $sql_cek);
    if (mysqli_num_rows($query_cek) > 0) {
        $data = mysqli_fetch_assoc($query_cek);

        if (!empty($data['foto'])) {
            $file_path = "images/" . $data['foto'];
        
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }

    $sql_hapus = "DELETE FROM calon_siswa WHERE id='$id'";
    $query_hapus = mysqli_query($db, $sql_hapus);

    if ($query_hapus) {
        echo "<script>
                alert('Data siswa dan fotonya berhasil dihapus!');
                window.location='list-siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.location='list-siswa.php';
              </script>";
    }

} else {
    die("Akses dilarang...");
}
?>