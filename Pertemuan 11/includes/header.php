<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .content-wrapper {
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="fw-bold">
                        <i class="bi bi-droplet-half"></i> <?php echo APP_NAME; ?>
                    </h4>
                    <p class="small mb-4">Versi <?php echo APP_VERSION; ?></p>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pelanggan.php' ? 'active' : ''; ?>" href="pelanggan.php">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'active' : ''; ?>" href="layanan.php">
                        <i class="bi bi-list-check"></i> Layanan
                    </a>
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : ''; ?>" href="transaksi.php">
                        <i class="bi bi-receipt"></i> Transaksi
                    </a>
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : ''; ?>" href="laporan.php">
                        <i class="bi bi-graph-up"></i> Laporan
                    </a>
                    
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                    <hr class="bg-white">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'user.php' ? 'active' : ''; ?>" href="user.php">
                        <i class="bi bi-person-gear"></i> Manajemen User
                    </a>
                    <?php endif; ?>
                    
                    <hr class="bg-white">
                    <a class="nav-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </nav>
                
                <div class="p-3 mt-4">
                    <div class="bg-white bg-opacity-10 rounded p-3">
                        <small>Login sebagai:</small>
                        <div class="fw-bold"><?php echo $_SESSION['nama_lengkap']; ?></div>
                        <small class="badge bg-light text-dark"><?php echo strtoupper($_SESSION['role']); ?></small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-10 content-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">
                        <?php
                        $page_titles = [
                            'dashboard.php' => 'Dashboard',
                            'pelanggan.php' => 'Manajemen Pelanggan',
                            'layanan.php' => 'Manajemen Layanan',
                            'transaksi.php' => 'Manajemen Transaksi',
                            'laporan.php' => 'Laporan Keuangan',
                            'user.php' => 'Manajemen User'
                        ];
                        echo $page_titles[basename($_SERVER['PHP_SELF'])] ?? 'LaundryCrafty';
                        ?>
                    </h2>
                    <div>
                        <i class="bi bi-calendar3"></i> <?php echo date('d F Y'); ?>
                    </div>
                </div>