<?php
$koneksi = mysqli_connect("127.0.0.1:4306", "root", "", "artikel_db");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
