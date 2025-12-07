<?php
include "../auth.php";
include "../role_check.php";

check_role(['admin', 'editor']);

include "../koneksi.php";

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM articles WHERE id=$id");
header("Location: list.php");
?>