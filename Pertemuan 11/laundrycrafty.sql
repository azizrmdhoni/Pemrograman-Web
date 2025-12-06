
USE laundrycrafty;

CREATE TABLE user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'kasir') NOT NULL,
    nama_lengkap VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE layanan (
    id_layanan INT PRIMARY KEY AUTO_INCREMENT,
    nama_layanan VARCHAR(50) NOT NULL,
    harga_per_kg DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    durasi_hari INT DEFAULT 3
);

CREATE TABLE transaksi (
    id_transaksi INT PRIMARY KEY AUTO_INCREMENT,
    id_pelanggan INT NOT NULL,
    id_layanan INT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    berat DECIMAL(5,2) NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status ENUM('Proses', 'Selesai', 'Sudah Diambil') DEFAULT 'Proses',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE,
    FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan) ON DELETE CASCADE
);

INSERT INTO user (username, password, role, nama_lengkap) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Administrator'),
('kasir1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kasir', 'Kasir Satu');

INSERT INTO layanan (nama_layanan, harga_per_kg, deskripsi, durasi_hari) VALUES
('Cuci Kering', 5000, 'Cuci dan kering saja', 2),
('Cuci Setrika', 7000, 'Cuci, kering, dan setrika', 3),
('Cuci Express', 10000, 'Selesai dalam 1 hari', 1),
('Setrika Saja', 4000, 'Hanya menyetrika', 1);

INSERT INTO pelanggan (nama, alamat, no_hp) VALUES
('Budi Santoso', 'Jl. Merdeka No. 123, Surabaya', '081234567890'),
('Siti Aminah', 'Jl. Pahlawan No. 45, Surabaya', '082345678901'),
('Andi Wijaya', 'Jl. Diponegoro No. 78, Surabaya', '083456789012');

INSERT INTO transaksi (id_pelanggan, id_layanan, tanggal_masuk, tanggal_selesai, berat, total_harga, status) VALUES

bener apa tidak?
