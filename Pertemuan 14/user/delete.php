<?php
include "../auth.php";
include "../role_check.php";

check_role(['admin']);

include "../koneksi.php";

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM users WHERE id=$id");
header("Location: list.php");
?>