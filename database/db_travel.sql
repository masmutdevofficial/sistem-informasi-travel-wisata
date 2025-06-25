-- Tabel admin
CREATE TABLE admin (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    nama VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    hp VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    status TINYINT(1) COMMENT '1 = Aktif, 0 = Tidak Aktif',
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
    nomor_polisi VARCHAR(100) NOT NULL,
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
    rute_biasa VARCHAR(100) NOT NULL,
    jadwal_kerja VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel data_paket_wisata
CREATE TABLE data_paket_wisata (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_wisata VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel data_rute
CREATE TABLE data_rute (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    rute_asal VARCHAR(100) NOT NULL,
    rute_tujuan VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel data_penumpang_travel
CREATE TABLE data_penumpang_travel (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_rute BIGINT NOT NULL,
    nama_penumpang VARCHAR(100) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    tgl_berangkat DATE,
    titik_jemput VARCHAR(20) NOT NULL,
    jumlah_penumpang INT,
    harga DECIMAL(20,2),
    jumlah_dp DECIMAL(20,2) DEFAULT 0,
    status_bayar ENUM('Lunas', 'DP', 'Belum Bayar') DEFAULT 'Belum Bayar',
    catatan TEXT,
    status_jemput ENUM('Sudah Dijemput', 'Batal', 'Menunggu Konfirmasi') DEFAULT 'Menunggu Konfirmasi',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rute) REFERENCES data_rute(id) ON DELETE CASCADE
);

-- Tabel data_penumpang_carter
CREATE TABLE data_penumpang_carter (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_kendaraan BIGINT NOT NULL,
    id_driver BIGINT NOT NULL,
    nama_penyewa VARCHAR(100),
    tgl_sewa DATE,
    durasi VARCHAR(100),
    tujuan VARCHAR(100),
    harga DECIMAL(20,2),
    jumlah_dp DECIMAL(20,2) DEFAULT 0,
    status_bayar ENUM('Lunas', 'DP', 'Belum Bayar') DEFAULT 'Belum Bayar',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kendaraan) REFERENCES data_kendaraan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_driver) REFERENCES data_driver(id) ON DELETE CASCADE
);

-- Tabel data_peserta_wisata
CREATE TABLE data_peserta_wisata (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_data_paket_wisata BIGINT NOT NULL,
    nama_peserta VARCHAR(100),
    tgl_keberangkatan DATE,
    jumlah_orang INT,
    harga DECIMAL(20,2),
    jumlah_dp DECIMAL(20,2) DEFAULT 0,
    status_bayar ENUM('Lunas', 'DP', 'Belum Bayar') DEFAULT 'Belum Bayar',
    catatan TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_data_paket_wisata) REFERENCES data_paket_wisata(id) ON DELETE CASCADE
);

-- Tabel pengeluaran
CREATE TABLE pengeluaran (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    keterangan TEXT NOT NULL,
    jumlah_pengeluaran DECIMAL(20,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
