-- Database: sarasi_db

CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS siswa (
    nisn VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level ENUM('admin', 'petugas') DEFAULT 'admin'
);

CREATE TABLE IF NOT EXISTS aspirasi (
    id_aspirasi INT AUTO_INCREMENT PRIMARY KEY,
    nisn VARCHAR(10) NOT NULL,
    id_kategori INT NOT NULL,
    judul VARCHAR(100) NOT NULL,
    isi TEXT NOT NULL,
    lokasi VARCHAR(100),
    tanggal_input DATETIME DEFAULT CURRENT_TIMESTAMP,
    foto VARCHAR(255),
    status ENUM('Diajukan', 'Diproses', 'Selesai') DEFAULT 'Diajukan',
    FOREIGN KEY (nisn) REFERENCES siswa(nisn) ON DELETE CASCADE,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS umpan_balik (
    id_umpan_balik INT AUTO_INCREMENT PRIMARY KEY,
    id_aspirasi INT NOT NULL,
    id_admin INT NOT NULL,
    tanggapan TEXT NOT NULL,
    tanggal_tanggapan DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_aspirasi) REFERENCES aspirasi(id_aspirasi) ON DELETE CASCADE,
    FOREIGN KEY (id_admin) REFERENCES admin(id_admin) ON DELETE CASCADE
);

-- Dummy Data for Testing
INSERT INTO kategori (nama_kategori) VALUES ('Sarana Belajar'), ('Kebersihan'), ('Fasilitas Umum'), ('Keamanan');

INSERT INTO admin (email, password, nama_lengkap, level) VALUES 
('admin@admin.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'); 
-- password is 'password' (bcrypt standard hash)

INSERT INTO siswa (nisn, nama, kelas, password) VALUES 
('1234567890', 'Budi Santoso', 'XII RPL 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); 
-- password is 'password'
