<?php
require_once 'config.php';
cek_login();

$periode = isset($_GET['periode']) ? $_GET['periode'] : 'bulan';
$tanggal_dari = isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-01');
$tanggal_sampai = isset($_GET['sampai']) ? $_GET['sampai'] : date('Y-m-d');
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

$where = "WHERE tanggal_masuk BETWEEN '$tanggal_dari' AND '$tanggal_sampai'";

if ($status_filter != '') {
    $where .= " AND status = '$status_filter'";
}

$total_pendapatan = $conn->query("SELECT COALESCE(SUM(total_harga), 0) as total FROM transaksi $where")->fetch_assoc()['total'];
$total_transaksi = $conn->query("SELECT COUNT(*) as total FROM transaksi $where")->fetch_assoc()['total'];
$total_berat = $conn->query("SELECT COALESCE(SUM(berat), 0) as total FROM transaksi $where")->fetch_assoc()['total'];

$per_layanan = $conn->query("
    SELECT l.nama_layanan, COUNT(t.id_transaksi) as jumlah, SUM(t.total_harga) as pendapatan, SUM(t.berat) as total_berat
    FROM transaksi t
    JOIN layanan l ON t.id_layanan = l.id_layanan
    $where
    GROUP BY l.id_layanan
    ORDER BY pendapatan DESC
");

$per_hari = $conn->query("
    SELECT DATE(tanggal_masuk) as tanggal, COUNT(*) as jumlah, SUM(total_harga) as pendapatan
    FROM transaksi
    $where
    GROUP BY DATE(tanggal_masuk)
    ORDER BY tanggal
");

include 'includes/header.php';
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Periode</label>
                        <select class="form-select" name="periode" onchange="setPeriode(this.value)">
                            <option value="hari" <?php echo $periode == 'hari' ? 'selected' : ''; ?>>Hari Ini</option>
                            <option value="minggu" <?php echo $periode == 'minggu' ? 'selected' : ''; ?>>Minggu Ini</option>
                            <option value="bulan" <?php echo $periode == 'bulan' ? 'selected' : ''; ?>>Bulan Ini</option>
                            <option value="custom" <?php echo $periode == 'custom' ? 'selected' : ''; ?>>Custom</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" name="dari" value="<?php echo $tanggal_dari; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="sampai" value="<?php echo $tanggal_sampai; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status_filter">
                            <option value="">Semua Status</option>
                            <option value="Proses" <?php echo $status_filter == 'Proses' ? 'selected' : ''; ?>>Proses</option>
                            <option value="Selesai" <?php echo $status_filter == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="Sudah Diambil" <?php echo $status_filter == 'Sudah Diambil' ? 'selected' : ''; ?>>Sudah Diambil</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Pendapatan <?php echo $status_filter ? "($status_filter)" : ""; ?></h6>
                <h2 class="fw-bold"><?php echo rupiah($total_pendapatan); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Transaksi <?php echo $status_filter ? "($status_filter)" : ""; ?></h6>
                <h2 class="fw-bold"><?php echo $total_transaksi; ?> transaksi</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Total Berat</h6>
                <h2 class="fw-bold"><?php echo $total_berat; ?> kg</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Pendapatan per Layanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Transaksi</th>
                                <th>Berat</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $per_layanan->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['nama_layanan']; ?></td>
                                <td><?php echo $row['jumlah']; ?>x</td>
                                <td><?php echo $row['total_berat']; ?> kg</td>
                                <td><strong><?php echo rupiah($row['pendapatan']); ?></strong></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Grafik Pendapatan Harian</h5>
            </div>
            <div class="card-body">
                <canvas id="chartPendapatan"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = [];
const data = [];

<?php 
$per_hari->data_seek(0);
while ($row = $per_hari->fetch_assoc()): 
?>
labels.push('<?php echo date("d/m", strtotime($row['tanggal'])); ?>');
data.push(<?php echo $row['pendapatan']; ?>);
<?php endwhile; ?>

const ctx = document.getElementById('chartPendapatan').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: data,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function setPeriode(periode) {
    const today = new Date();
    let dari, sampai;
    
    switch(periode) {
        case 'hari':
            dari = sampai = today.toISOString().split('T')[0];
            break;
        case 'minggu':
            const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
            dari = firstDay.toISOString().split('T')[0];
            sampai = new Date().toISOString().split('T')[0];
            break;
        case 'bulan':
            dari = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            sampai = new Date().toISOString().split('T')[0];
            break;
        default:
            return;
    }
    
    document.querySelector('[name="dari"]').value = dari;
    document.querySelector('[name="sampai"]').value = sampai;
}
</script>

<?php include 'includes/footer.php'; ?>