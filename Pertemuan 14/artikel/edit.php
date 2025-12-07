<?php
include "../auth.php";
include "../role_check.php";

check_role(['admin', 'editor']);

include "../koneksi.php";

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM articles WHERE id=$id");
$artikel = mysqli_fetch_assoc($result);

if ($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    mysqli_query($koneksi, "UPDATE articles SET title='$title', content='$content' WHERE id=$id");
    header("Location: list.php");
}
?>

<h3>Edit Artikel</h3>
<form method="POST">
    Judul: <input name="title" value="<?= $artikel['title'] ?>" required><br><br>
    Konten:<br>
    <textarea name="content" rows="5" cols="50" required><?= $artikel['content'] ?></textarea><br><br>
    <button type="submit">Update</button>
</form>