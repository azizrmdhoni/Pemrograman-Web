<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa | SMK Coding</title>
</head>
<body>
    <header>
        <h2>Data Pendaftar SMK Coding</h2>
    </header>

    <nav>
        <a href="form-daftar.php">[+] Tambah Pendaftar</a>
    </nav>

    <br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>Sekolah Asal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($db, "SELECT * FROM calon_siswa");

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['alamat']}</td>
                            <td>{$row['jenis_kelamin']}</td>
                            <td>{$row['agama']}</td>
                            <td>{$row['sekolah_asal']}</td>
                            <td>
                                <a href='form-edit.php?id={$row['id']}'>Edit</a> | 
                                <a href='hapus.php?id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>
                            </td>
                        </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7' align='center'>Belum ada data siswa</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <p>Total pendaftar: <strong><?php echo mysqli_num_rows($result); ?></strong></p>
</body>
</html>
