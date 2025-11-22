<?php include "config.php"; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <style>
        body { font-family: serif; }
        h2 { margin-bottom: 10px; }
        a { text-decoration: none; color: blue; }
        a:hover { text-decoration: underline; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px;
        }
        th, td { 
            border: 1px solid #999; 
            padding: 8px; 
            text-align: left; 
            vertical-align: top;
        }
        th {
            background-color: #fff;
            text-align: center;
            font-weight: bold;
        }
        
        .img-siswa {
            width: 100px;
            height: auto;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body>
    
    <h2>Data Siswa</h2>

    <a href="form-daftar.php">Tambah Data</a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM calon_siswa";
            $query = mysqli_query($db, $sql);

            while($siswa = mysqli_fetch_array($query)){
                
                $gambar_path = "images/" . $siswa['foto'];
                if (!empty($siswa['foto']) && file_exists($gambar_path)) {
                    $foto_tampil = "<img src='$gambar_path' class='img-siswa'>";
                } else {
                    $foto_tampil = "<i>Tidak ada foto</i>";
                }

                echo "<tr>";
                echo "<td align='center'>".$foto_tampil."</td>";
                echo "<td>".$siswa['id']."</td>";
                echo "<td>".$siswa['nama']."</td>";
                echo "<td>".$siswa['jenis_kelamin']."</td>";    
                echo "<td>".$siswa['telepon']."</td>";
                echo "<td>".$siswa['alamat']."</td>";
                echo "<td>";
                echo "<a href='form-edit.php?id=".$siswa['id']."'>Ubah</a> | ";
                echo "<a href='hapus.php?id=".$siswa['id']."' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <p>Total: <?php echo mysqli_num_rows($query) ?></p>

</body>
</html>