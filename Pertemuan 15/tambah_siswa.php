<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nis        = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $kelas      = $_POST['kelas'];
    $no_hp      = $_POST['no_hp'];

    $query = "INSERT INTO siswa_rpl (nis, nama_siswa, kelas, no_hp) 
              VALUES ('$nis', '$nama_siswa', '$kelas', '$no_hp')";

    if (mysqli_query($connect, $query)) {
        echo "<script>
                alert('Data berhasil disimpan!');
                window.location.href='tambah_siswa.php';
              </script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: none; }
        .header-title { color: #2c3e50; font-weight: bold; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Form Tambah Siswa</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="number" name="nis" class="form-control" placeholder="Contoh: 21005" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_siswa" class="form-control" placeholder="Contoh: Ahsin ITDEV" required>
                        </div>

                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="IX RPL 1">IX RPL 1</option>
                                <option value="IX RPL 2">IX RPL 2</option>
                                <option value="IX RPL 3">IX RPL 3</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="number" name="no_hp" class="form-control" placeholder="Contoh: 0812..." required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="simpan" class="btn btn-success">Simpan Data</button>
                            <a href="cetak_siswa.php" target="_blank" class="btn btn-outline-danger">Cetak Laporan PDF</a>
                        </div>

                    </form>
                </div>
            </div>
            <div class="text-center mt-3 text-muted">
                <small>SMK Negeri 2 Langsa - Sistem Informasi</small>
            </div>
        </div>
    </div>
</div>

</body>
</html>