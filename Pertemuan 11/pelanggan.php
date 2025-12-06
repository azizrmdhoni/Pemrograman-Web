<?php
require_once 'config.php';
cek_login();

$success = '';
$error = '';

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama, alamat, no_hp) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $alamat, $no_hp);
    
    if ($stmt->execute()) {
        $success = "Pelanggan berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan pelanggan!";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    
    $stmt = $conn->prepare("UPDATE pelanggan SET nama=?, alamat=?, no_hp=? WHERE id_pelanggan=?");
    $stmt->bind_param("sssi", $nama, $alamat, $no_hp, $id);
    
    if ($stmt->execute()) {
        $success = "Pelanggan berhasil diupdate!";
    } else {
        $error = "Gagal mengupdate pelanggan!";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $stmt = $conn->prepare("DELETE FROM pelanggan WHERE id_pelanggan=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $success = "Pelanggan berhasil dihapus!";
    } else {
        $error = "Gagal menghapus pelanggan! Mungkin masih ada transaksi terkait.";
    }
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM pelanggan";
if ($search) {
    $query .= " WHERE nama LIKE '%$search%' OR no_hp LIKE '%$search%'";
}
$query .= " ORDER BY id_pelanggan DESC";
$pelanggan = $conn->query($query);

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

<div class="row mb-3">
    <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i> Tambah Pelanggan
        </button>
    </div>
    <div class="col-md-6">
        <form method="GET" class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari nama atau nomor HP..." value="<?php echo $search; ?>">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $pelanggan->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_pelanggan']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['no_hp']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $row['id_pelanggan']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="?hapus=<?php echo $row['id_pelanggan']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="modalEdit<?php echo $row['id_pelanggan']; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Pelanggan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_pelanggan" value="<?php echo $row['id_pelanggan']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" rows="2"><?php echo $row['alamat']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">No. HP</label>
                                            <input type="text" class="form-control" name="no_hp" value="<?php echo $row['no_hp']; ?>">
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
                    <h5 class="modal-title">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" class="form-control" name="no_hp">
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