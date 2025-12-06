<?php
require_once 'config.php';
cek_login();

$total_pelanggan = $conn->query("SELECT COUNT(*) as total FROM pelanggan")->fetch_assoc()['total'];
$total_transaksi = $conn->query("SELECT COUNT(*) as total FROM transaksi")->fetch_assoc()['total'];
$transaksi_proses = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE status='Proses'")->fetch_assoc()['total'];
$pendapatan_bulan_ini = $conn->query("SELECT COALESCE(SUM(total_harga), 0) as total FROM transaksi WHERE MONTH(tanggal_masuk) = MONTH(CURRENT_DATE) AND YEAR(tanggal_masuk) = YEAR(CURRENT_DATE)")->fetch_assoc()['total'];

$transaksi_terbaru = $conn->query("
    SELECT t.*, p.nama, l.nama_layanan 
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN layanan l ON t.id_layanan = l.id_layanan
    ORDER BY t.created_at DESC
    LIMIT 5
");

include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Pelanggan</h6>
                        <h2 class="fw-bold"><?php echo $total_pelanggan; ?></h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Transaksi</h6>
                        <h2 class="fw-bold"><?php echo $total_transaksi; ?></h2>
                    </div>
                    <i class="bi bi-receipt" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Sedang Proses</h6>
                        <h2 class="fw-bold"><?php echo $transaksi_proses; ?></h2>
                    </div>
                    <i class="bi bi-hourglass-split" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Pendapatan Bulan Ini</h6>
                        <h2 class="fw-bold"><?php echo rupiah($pendapatan_bulan_ini); ?></h2>
                    </div>
                    <i class="bi bi-cash-stack" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat (kg)</th>
                                <th>Total</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $transaksi_terbaru->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_transaksi']; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['nama_layanan']; ?></td>
                                <td><?php echo $row['berat']; ?> kg</td>
                                <td><?php echo rupiah($row['total_harga']); ?></td>
                                <td><?php echo tanggal_indo($row['tanggal_masuk']); ?></td>
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
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>