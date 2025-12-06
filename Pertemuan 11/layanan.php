<?php
require_once 'config.php';
cek_login();

$success = '';
$error = '';

if (isset($_POST['tambah'])) {
    $nama_layanan = $_POST['nama_layanan'];
    $harga_per_kg = $_POST['harga_per_kg'];
    $deskripsi = $_POST['deskripsi'];
    $durasi_hari = $_POST['durasi_hari'];
    
    $stmt = $conn->prepare("INSERT INTO layanan (nama_layanan, harga_per_kg, deskripsi, durasi_hari) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsi", $nama_layanan, $harga_per_kg, $deskripsi, $durasi_hari);
    
    if ($stmt->execute()) {
        $success = "Layanan berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan layanan!";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id_layanan'];
    $nama_layanan = $_POST['nama_layanan'];
    $harga_per_kg = $_POST['harga_per_kg'];
    $deskripsi = $_POST['deskripsi'];
    $durasi_hari = $_POST['durasi_hari'];
    
    $stmt = $conn->prepare("UPDATE layanan SET nama_layanan=?, harga_per_kg=?, deskripsi=?, durasi_hari=? WHERE id_layanan=?");
    $stmt->bind_param("sdsii", $nama_layanan, $harga_per_kg, $deskripsi, $durasi_hari, $id);
    
    if ($stmt->execute()) {
        $success = "Layanan berhasil diupdate!";
    } else {
        $error = "Gagal mengupdate layanan!";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $stmt = $conn->prepare("DELETE FROM layanan WHERE id_layanan=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $success = "Layanan berhasil dihapus!";
    } else {
        $error = "Gagal menghapus layanan! Mungkin masih ada transaksi terkait.";
    }
}

$layanan = $conn->query("SELECT * FROM layanan ORDER BY id_layanan DESC");

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
        <i class="bi bi-plus-circle"></i> Tambah Layanan
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Layanan</th>
                        <th>Harga/Kg</th>
                        <th>Durasi (Hari)</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $layanan->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_layanan']; ?></td>
                        <td><strong><?php echo $row['nama_layanan']; ?></strong></td>
                        <td><?php echo rupiah($row['harga_per_kg']); ?></td>
                        <td><?php echo $row['durasi_hari']; ?> hari</td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $row['id_layanan']; ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="?hapus=<?php echo $row['id_layanan']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="modalEdit<?php echo $row['id_layanan']; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Layanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_layanan" value="<?php echo $row['id_layanan']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Layanan</label>
                                            <input type="text" class="form-control" name="nama_layanan" value="<?php echo $row['nama_layanan']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Harga per Kg</label>
                                            <input type="number" class="form-control" name="harga_per_kg" value="<?php echo $row['harga_per_kg']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Durasi (Hari)</label>
                                            <input type="number" class="form-control" name="durasi_hari" value="<?php echo $row['durasi_hari']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" name="deskripsi" rows="2"><?php echo $row['deskripsi']; ?></textarea>
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
                    <h5 class="modal-title">Tambah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" name="nama_layanan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga per Kg</label>
                        <input type="number" class="form-control" name="harga_per_kg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durasi (Hari)</label>
                        <input type="number" class="form-control" name="durasi_hari" value="3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2"></textarea>
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