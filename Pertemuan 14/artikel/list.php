<?php
include "../auth.php";
include "../koneksi.php";
?>

<!DOCTYPE html>
<html>
<head><title>Daftar Artikel</title></head>
<body>
    <h2>Daftar Artikel</h2>
    
    <p>Halo, <?= $_SESSION['user']['username'] ?> (<?= $_SESSION['user']['role'] ?>) | <a href="../logout.php">Logout</a></p>
    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
        <a href="../user/list.php">Manajemen User</a> | 
    <?php endif; ?>

    <hr>

    <?php if ($_SESSION['user']['role'] != 'viewer'): ?>
        <a href="add.php">Tambah Artikel</a>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0" style="margin-top:10px;">
        <tr><th>Judul</th><th>Aksi</th></tr>
        <?php
        $result = mysqli_query($koneksi, "SELECT * FROM articles");
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td>
                <a href="view.php?id=<?= $row['id'] ?>">Lihat</a>
                <?php if ($_SESSION['user']['role'] != 'viewer'): ?>
                    | <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    | <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>