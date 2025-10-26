<?php
include "config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Akses tidak valid!";
    exit;
}

if (mysqli_query($db, "DELETE FROM calon_siswa WHERE id='$id'")) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location='list-siswa.php';
          </script>";
} else {
    echo "Gagal menghapus data!";
}
?>
