-- Tabel admin
CREATE TABLE admin (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    nama VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    hp VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    status TINYINT(1) DEFAULT 1 COMMENT '1 = Aktif, 0 = Tidak Aktif',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO admin (username, nama, email, hp, password, status)
VALUES (
    'admin',
    'Admin',
    'admin@gmail.com',
    '081234567890',
    '$2y$12$J7rfQMum6CsitEIuaNKlAO1lT5HvBq2Glj2YFHCkm2w2AkznIyzTS',
    1
);

-- Tabel data_kendaraan
CREATE TABLE data_kendaraan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_kendaraan VARCHAR(255) NOT NULL,
    nomor_polisi VARCHAR(255) NOT NULL,
    kapasitas INT NOT NULL,
    status ENUM('Aktif', 'Perbaikan') DEFAULT 'Aktif',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel data_driver
CREATE TABLE data_driver (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel data_pelanggan
CREATE TABLE data_pelanggan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_penumpang VARCHAR(100) NOT NULL,
    alamat_penumpang VARCHAR(100) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE data_pesanan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_kendaraan BIGINT NOT NULL,
    id_driver BIGINT NOT NULL,
    id_data_pelanggan BIGINT NOT NULL,
    waktu_berangkat DATETIME NULL,
    waktu_pulang DATETIME NULL,
    titik_jemput VARCHAR(100) DEFAULT NULL,
    jumlah_penumpang INT DEFAULT NULL,
    jumlah_barang INT DEFAULT NULL,
    harga DECIMAL(20,2) DEFAULT 0,
    jumlah_dp DECIMAL(20,2) DEFAULT 0,
    tambahan_dp DECIMAL(20,2) DEFAULT 0,
    jenis_pemesanan ENUM('Travel', 'Sewa/Carter', 'Paket Wisata') DEFAULT 'Travel',
    status_bayar ENUM('Lunas', 'DP', 'Belum Bayar') DEFAULT 'Belum Bayar',
    catatan TEXT DEFAULT NULL,
    status_jemput ENUM('Sudah Dijemput', 'Batal', 'Menunggu Konfirmasi') DEFAULT 'Menunggu Konfirmasi',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_kendaraan) REFERENCES data_kendaraan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_driver) REFERENCES data_driver(id) ON DELETE CASCADE,
    FOREIGN KEY (id_data_pelanggan) REFERENCES data_pelanggan(id) ON DELETE CASCADE
);

-- Tabel pengeluaran
CREATE TABLE pengeluaran (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_data_pesanan BIGINT NOT NULL,
    keterangan TEXT NOT NULL,
    jumlah_pengeluaran DECIMAL(20,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_data_pesanan) REFERENCES data_pesanan(id) ON DELETE CASCADE
);


