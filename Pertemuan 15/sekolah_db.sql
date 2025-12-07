CREATE TABLE siswa_rpl (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) NOT NULL,
    nama_siswa VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    no_hp VARCHAR(15) NOT NULL
);

INSERT INTO siswa_rpl (nis, nama_siswa, kelas, no_hp) VALUES 
('21001', 'Ahmad Dani', 'IX RPL 1', '081234567890'),
('21002', 'Budi Santoso', 'IX RPL 1', '081298765432'),
('21003', 'Citra Kirana', 'IX RPL 1', '085712312311');
