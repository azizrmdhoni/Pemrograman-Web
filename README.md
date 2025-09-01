Source code pertemuan 2

<!DOCTYPE html>
<html>
<head>
    <title>Muhamad Aziz Romdhoni</title>
</head>
<body>
    <h1>Profil Mahasiswa</h1>

    <h2>Deskripsi Singkat</h2>
    <p>Halo nama saya <b>Muhamad Aziz Romdhoni</b>. Saya seorang mahasiswa Teknik Informatika tahun kedua.
        Saya tertarik untuk menjadi seorang full stack developer</p>

    <!-- Foto Profil dan biodata diri-->
    <h2>Biodata Diri</h2>
    <table border="1" cellpadding="5">
        <tr>
            <td rowspan="8" align="center">
                <img src="profil.jpg" width="200">
            </td>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>Muhamad Aziz Romdhoni</td>
        </tr>
        <tr>
            <td>Tempat,Tanggal Lahir</td>
            <td>:</td>
            <td>Jakarta,16 Oktober 2005</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>Laki - Laki</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>Islam</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>Jln. Keputih Tegal Bakti 1 No. 7A, Kec. Sukolilo, Surabaya, Jawa Timur 60111 </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>Belum Menikah</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>Mahasiswa</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>:</td>
            <td>Indonesia</td>
        </tr>
    </table>

    <!-- Daftar Hobi -->
    <h2>Hobi</h2>
    <ul>
        <li>Bermain game</li>
        <li>Mendengarkan musik</li>
        <li>Membaca</li>
    </ul>

    <!-- Tabel Riwayat Pendidikan -->
    <h2>Riwayat Jenjang Pendidikan Formal</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Jenjang Pendidikan</th>
            <th>Keterangan</th>
            <th>Tahun</th>
        </tr>
        <tr>
            <td>Taman Kanak - Kanak</td>
            <td>TK An - Ni'mah</td>
            <td>2011 - 2012</td>
        </tr>
        <tr>
            <td>Sekolah Dasar</td>
            <td>SDN Cilangkap 01 Pagi</td>
            <td>2012 - 2018</td>
        </tr>
        <tr>
            <td>Sekolah Menengah Pertama</td>
            <td>SMPN 9 Jakarta Timur </td>
            <td>2018 - 2021</td>
        </tr>
        <tr>
            <td>Sekolah Menengah Atas</td>
            <td>MAN 15 Jakarta</td>
            <td>2021 - 2024</td>
        </tr>
        <tr>
            <td>Perguruan Tinggi</td>
            <td>Institut Teknologi Sepuluh Nopember</td>
            <td>2024 - sekarang</td>
        </tr>
    </table>

    <!-- Form Kontak-->
    <h2>Kontak Saya</h2>
    <form>
        <label>Nama:</label><br>
        <input type="text" name="nama"><br>

        <label>Email:</label><br>
        <input type="email" name="email"><br>

        <label>Pesan:</label><br>
        <textarea name="pesan" rows="4" cols="30"></textarea><br><br>

        <input type="submit" value="Kirim">
    </form>

    <!-- Link -->
    <h2>Media Sosial</h2>
    <p>Kunjungi <a href="https://azizrmdhoni.blogspot.com/" target="_blank">Blogspot</a>,  
        <a href="https://instagram.com/azizrmdhoni" target="_blank">Instagram</a> 
        saya untuk melihat informasi lebih lanjut.</p>

</body>
</html>

