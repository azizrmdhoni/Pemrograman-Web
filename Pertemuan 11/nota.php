<?php
require_once 'config.php';

$id = $_GET['id'];
$transaksi = $conn->query("
    SELECT t.*, p.nama, p.alamat, p.no_hp, l.nama_layanan, l.harga_per_kg
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN layanan l ON t.id_layanan = l.id_layanan
    WHERE t.id_transaksi = $id
")->fetch_assoc();

if (!$transaksi) {
    die("Transaksi tidak ditemukan!");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota #<?php echo $transaksi['id_transaksi']; ?></title>
    <style>
        @media print {
            .no-print { display: none; }
        }
        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .info {
            margin: 10px 0;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        .total {
            border-top: 2px dashed #000;
            border-bottom: 2px dashed #000;
            padding: 10px 0;
            margin: 10px 0;
            font-weight: bold;
            font-size: 1.2em;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }
        .btn-print {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ Cetak Nota</button>
    
    <div class="header">
        <h2><?php echo APP_NAME; ?></h2>
        <p>Jl. Contoh No. 123, Surabaya<br>
        Telp: 081234567890</p>
    </div>
    
    <div class="info">
        <table>
            <tr>
                <td>No. Nota</td>
                <td>: <strong>#<?php echo $transaksi['id_transaksi']; ?></strong></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?php echo tanggal_indo($transaksi['tanggal_masuk']); ?></td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: <?php echo $transaksi['nama']; ?></td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>: <?php echo $transaksi['no_hp']; ?></td>
            </tr>
        </table>
    </div>
    
    <div style="border-top: 1px dashed #000; padding-top: 10px;">
        <table style="width: 100%;">
            <tr>
                <td>Layanan</td>
                <td>: <?php echo $transaksi['nama_layanan']; ?></td>
            </tr>
            <tr>
                <td>Berat</td>
                <td>: <?php echo $transaksi['berat']; ?> kg</td>
            </tr>
            <tr>
                <td>Harga/kg</td>
                <td>: <?php echo rupiah($transaksi['harga_per_kg']); ?></td>
            </tr>
        </table>
    </div>
    
    <div class="total">
        <table style="width: 100%;">
            <tr>
                <td>TOTAL BAYAR</td>
                <td style="text-align: right;"><?php echo rupiah($transaksi['total_harga']); ?></td>
            </tr>
        </table>
    </div>
    
    <div class="info">
        <table>
            <tr>
                <td>Estimasi Selesai</td>
                <td>: <?php echo tanggal_indo($transaksi['tanggal_selesai']); ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: <strong><?php echo $transaksi['status']; ?></strong></td>
            </tr>
        </table>
    </div>
    
    <?php if ($transaksi['catatan']): ?>
    <div style="margin-top: 10px; font-size: 0.9em;">
        <strong>Catatan:</strong><br>
        <?php echo $transaksi['catatan']; ?>
    </div>
    <?php endif; ?>
    
    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda!<br>
        Simpan nota ini sebagai bukti pengambilan</p>
        <p style="margin-top: 20px; font-size: 0.8em;">
            Dicetak: <?php echo date('d/m/Y H:i'); ?>
        </p>
    </div>
</body>
</html>