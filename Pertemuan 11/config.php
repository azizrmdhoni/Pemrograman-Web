<?php
define('DB_HOST', '127.0.0.1:4306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'laundrycrafty');

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

define('APP_NAME', 'LaundryCrafty');
define('APP_VERSION', '1.0');
define('BASE_URL', 'http://localhost/laundrycrafty/');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

function tanggal_indo($tanggal) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function cek_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function cek_role($role) {
    if ($_SESSION['role'] != $role) {
        header("Location: dashboard.php");
        exit();
    }
}
?>
