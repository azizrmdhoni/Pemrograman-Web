<?php
$host       = "127.0.0.1:4306";
$user       = "root";
$password   = "";
$database   = "sekolah_db";

$connect = mysqli_connect($host, $user, $password, $database);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
