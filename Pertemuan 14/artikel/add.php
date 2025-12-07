<?php
include "../auth.php";
include "../role_check.php";

check_role(['admin', 'editor']);

include "../koneksi.php";

if ($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['user']['id'];

    mysqli_query($koneksi, "INSERT INTO articles (title, content, author_id) VALUES ('$title', '$content', '$author')");
    header("Location: list.php");
}
?>

<h3>Tambah Artikel</h3>
<form method="POST">
    Judul: <input name="title" required><br><br>
    Konten:<br>
    <textarea name="content" rows="5" cols="50" required></textarea><br><br>
    <button type="submit">Simpan</button>
</form>
