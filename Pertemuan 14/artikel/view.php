<?php
include "../auth.php";
include "../koneksi.php";

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM articles WHERE id=$id");
$row = mysqli_fetch_assoc($result);
?>

<h2><?= $row['title'] ?></h2>
<p><?= nl2br($row['content']) ?></p>
<a href="list.php">Kembali</a>