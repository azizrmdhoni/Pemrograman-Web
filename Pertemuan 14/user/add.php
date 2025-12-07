<?php
include "../auth.php";
include "../role_check.php";

check_role(['admin']);

include "../koneksi.php";

if ($_POST) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    header("Location: list.php");
}
?>

<h3>Tambah User</h3>
<form method="POST">
    Username: <input name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Role: 
    <select name="role">
        <option value="admin">Admin</option>
        <option value="editor">Editor</option>
        <option value="viewer">Viewer</option>
    </select><br><br>
    <button type="submit">Simpan</button>
</form>
