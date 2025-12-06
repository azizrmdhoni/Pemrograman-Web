<?php
require_once 'config.php';
cek_login();
cek_role('admin');

$success = '';
$error = '';

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $nama_lengkap = $_POST['nama_lengkap'];
    
    $stmt = $conn->prepare("INSERT INTO user (username, password, role, nama_lengkap) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $role, $nama_lengkap);
    
    if ($stmt->execute()) {
        $success = "User berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan user! Username mungkin sudah ada.";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $nama_lengkap = $_POST['nama_lengkap'];
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET username=?, password=?, role=?, nama_lengkap=? WHERE id_user=?");
        $stmt->bind_param("ssssi", $username, $password, $role, $nama_lengkap, $id);
    } else {
        $stmt = $conn->prepare("UPDATE user SET username=?, role=?, nama_lengkap=? WHERE id_user=?");
        $stmt->bind_param("sssi", $username, $role, $nama_lengkap, $id);
    }
    
    if ($stmt->execute()) {
        $success = "User berhasil diupdate!";
    } else {
        $error = "Gagal mengupdate user!";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    if ($id == $_SESSION['user_id']) {
        $error = "Tidak dapat menghapus user yang sedang login!";
    } else {
        $stmt = $conn->prepare("DELETE FROM user WHERE id_user=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $success = "User berhasil dihapus!";
        } else {
            $error = "Gagal menghapus user!";
        }
    }
}

$users = $conn->query("SELECT * FROM user ORDER BY id_user DESC");

include 'includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah User
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_user']; ?></td>
                        <td><strong><?php echo $row['username']; ?></strong></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $row['role'] == 'admin' ? 'danger' : 'info'; ?>">
                                <?php echo strtoupper($row['role']); ?>
                            </span>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $row['id_user']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <?php if ($row['id_user'] != $_SESSION['user_id']): ?>
                            <a href="?hapus=<?php echo $row['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete('Yakin ingin menghapus user ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="modalEdit<?php echo $row['id_user']; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                            <small class="text-muted">Minimal 6 karakter</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Role</label>
                                            <select class="form-select" name="role" required>
                                                <option value="admin" <?php echo $row['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                <option value="kasir" <?php echo $row['role'] == 'kasir' ? 'selected' : ''; ?>>Kasir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required minlength="6">
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>