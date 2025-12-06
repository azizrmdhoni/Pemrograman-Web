<?php
require_once 'config.php';
cek_login();

$success = '';
$error = '';

if (isset($_POST['tambah'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_layanan = $_POST['id_layanan'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $berat = $_POST['berat'];
    $catatan = $_POST['catatan'];
    
    $layanan_data = $conn->query("SELECT harga_per_kg, durasi_hari FROM layanan WHERE id_layanan = $id_layanan")->fetch_assoc();
    $total_harga = $berat * $layanan_data['harga_per_kg'];
    $tanggal_selesai = date('Y-m-d', strtotime($tanggal_masuk . ' +' . $layanan_data['durasi_hari'] . ' days'));
    
    $stmt = $conn->prepare("INSERT INTO transaksi (id_pelanggan, id_layanan, tanggal_masuk, tanggal_selesai, berat, total_harga, catatan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdds", $id_pelanggan, $id_layanan, $tanggal_masuk, $tanggal_selesai, $berat, $total_harga, $catatan);
    
    if ($stmt->execute()) {
        $success = "Transaksi berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan transaksi!";
    }
}

if (isset($_POST['update_status'])) {
    $id = $_POST['id_transaksi'];
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE transaksi SET status=? WHERE id_transaksi=?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        $success = "Status berhasil diupdate!";
    } else {
        $error = "Gagal mengupdate status!";
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $stmt = $conn->prepare("DELETE FROM transaksi WHERE id_transaksi=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $success = "Transaksi berhasil dihapus!";
    } else {
        $error = "Gagal menghapus transaksi!";
    }
}

$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT t.*, p.nama, l.nama_layanan FROM transaksi t
          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
          JOIN layanan l ON t.id_layanan = l.id_layanan WHERE 1=1";

if ($filter_status) {
    $query .= " AND t.status = '$filter_status'";
}
if ($search) {
    $query .= " AND (p.nama LIKE '%$search%' OR t.id_transaksi LIKE '%$search%')";
}
$query .= " ORDER BY t.id_transaksi DESC";
$transaksi = $conn->query($query);

$pelanggan = $conn->query("SELECT * FROM pelanggan ORDER BY nama");
$layanan = $conn->query("SELECT * FROM layanan ORDER BY nama_layanan");

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
    <div class="col-md-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i> Transaksi Baru
        </button>
    </div>
    <div class="col-md-4">
        <select class="form-select" onchange="window.location.href='?status='+this.value">
            <option value="">Semua Status</option>
            <option value="Proses" <?php echo $filter_status == 'Proses' ? 'selected' : ''; ?>>Proses</option>
            <option value="Selesai" <?php echo $filter_status == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
            <option value="Sudah Diambil" <?php echo $filter_status == 'Sudah Diambil' ? 'selected' : ''; ?>>Sudah Diambil</option>
        </select>
    </div>
    <div class="col-md-4">
        <form method="GET" class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari ID/Nama..." value="<?php echo $search; ?>">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i>
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
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $transaksi->fetch_assoc()): ?>
                    <tr>
                        <td><strong>#<?php echo $row['id_transaksi']; ?></strong></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['nama_layanan']; ?></td>
                        <td><?php echo $row['berat']; ?> kg</td>
                        <td><?php echo rupiah($row['total_harga']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_masuk'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_selesai'])); ?></td>
                        <td>
                            <?php
                            $badge = [
                                'Proses' => 'warning',
                                'Selesai' => 'success',
                                'Sudah Diambil' => 'secondary'
                            ];
                            ?>
                            <span class="badge bg-<?php echo $badge[$row['status']]; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalStatus<?php echo $row['id_transaksi']; ?>">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                            <a href="nota.php?id=<?php echo $row['id_transaksi']; ?>" class="btn btn-sm btn-success" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            <a href="?hapus=<?php echo $row['id_transaksi']; ?>" class="btn btn-sm btn-danger" onclick="return confirmDelete()">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="modalStatus<?php echo $row['id_transaksi']; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_transaksi" value="<?php echo $row['id_transaksi']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Status Saat Ini: <strong><?php echo $row['status']; ?></strong></label>
                                            <select class="form-select" name="status" required>
                                                <option value="Proses">Proses</option>
                                                <option value="Selesai">Selesai</option>
                                                <option value="Sudah Diambil">Sudah Diambil</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="update_status" class="btn btn-primary">Update</button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formTransaksi">
                <div class="modal-header">
                    <h5 class="modal-title">Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pelanggan</label>
                            <select class="form-select" name="id_pelanggan" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php while ($p = $pelanggan->fetch_assoc()): ?>
                                <option value="<?php echo $p['id_pelanggan']; ?>"><?php echo $p['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Layanan</label>
                            <select class="form-select" name="id_layanan" id="layanan" required>
                                <option value="">Pilih Layanan</option>
                                <?php while ($l = $layanan->fetch_assoc()): ?>
                                <option value="<?php echo $l['id_layanan']; ?>" data-harga="<?php echo $l['harga_per_kg']; ?>">
                                    <?php echo $l['nama_layanan']; ?> - <?php echo rupiah($l['harga_per_kg']); ?>/kg
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" step="0.1" class="form-control" name="berat" id="berat" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catatan" rows="2"></textarea>
                    </div>
                    <div class="alert alert-info">
                        <strong>Estimasi Total: <span id="estimasiTotal">Rp 0</span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('layanan').addEventListener('change', hitungTotal);
document.getElementById('berat').addEventListener('input', hitungTotal);

function hitungTotal() {
    const layanan = document.getElementById('layanan');
    const berat = parseFloat(document.getElementById('berat').value) || 0;
    const harga = parseFloat(layanan.options[layanan.selectedIndex].dataset.harga) || 0;
    const total = berat * harga;
    
    document.getElementById('estimasiTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>

<?php include 'includes/footer.php'; ?>