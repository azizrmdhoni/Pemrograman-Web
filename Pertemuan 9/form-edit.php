<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: list-siswa.php');
    exit;
}

$id = $_GET['id'];

$result = mysqli_query($db, "SELECT * FROM calon_siswa WHERE id = $id");
$siswa = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) < 1) {
    die("Data tidak ditemukan...");
}
?>

<!DOCTYPE html>
<head>
    <title>Edit Data Siswa | SMK Coding</title>
</head>
<body>
    <header>
        <h3>Edit Data Siswa</h3>
    </header>

    <form action="proses-edit.php" method="POST">
        <fieldset>
            <input type="hidden" name="id" value="<?= $siswa['id']; ?>">

            <p>
                <label>Nama:</label>
                <input type="text" name="nama" placeholder="Nama lengkap" value="<?= $siswa['nama']; ?>">
            </p>

            <p>
                <label>Alamat:</label>
                <textarea name="alamat"><?= $siswa['alamat']; ?></textarea>
            </p>

            <p>
                <label>Jenis Kelamin:</label>
                <?php $jk = $siswa['jenis_kelamin']; ?>
                <label><input type="radio" name="jenis_kelamin" value="laki-laki" <?= ($jk == 'laki-laki') ? 'checked' : ''; ?>> Laki-laki</label>
                <label><input type="radio" name="jenis_kelamin" value="perempuan" <?= ($jk == 'perempuan') ? 'checked' : ''; ?>> Perempuan</label>
            </p>

            <p>
                <label>Agama:</label>
                <?php $agama = $siswa['agama']; ?>
                <select name="agama">
                    <option <?= ($agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                    <option <?= ($agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                    <option <?= ($agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                    <option <?= ($agama == 'Budha') ? 'selected' : ''; ?>>Budha</option>
                    <option <?= ($agama == 'Atheis') ? 'selected' : ''; ?>>Atheis</option>
                </select>
            </p>

            <p>
                <label>Sekolah Asal:</label>
                <input type="text" name="sekolah_asal" placeholder="Nama sekolah" value="<?= $siswa['sekolah_asal']; ?>">
            </p>

            <p>
                <input type="submit" name="simpan" value="Simpan">
            </p>
        </fieldset>
    </form>
</body>
</html>
