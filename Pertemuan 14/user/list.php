<?php
include "../auth.php";
include "../role_check.php";

check_role(['admin']);

include "../koneksi.php";
$result = mysqli_query($koneksi, "SELECT * FROM users");
?>

<h2>Manajemen User</h2>
<a href="../artikel/list.php">Kembali ke Artikel</a> | 
<a href="add.php">Tambah User</a>
<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr><th>Username</th><th>Role</th><th>Aksi</th></tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['username'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus user?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>