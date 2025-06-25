<?php
session_start();
require '../../config/koneksi.php';

try {
    $nama         = trim($_POST['nama']);
    $hp           = trim($_POST['hp']);
    $rute_biasa   = trim($_POST['rute_biasa']);
    $jadwal_kerja = trim($_POST['jadwal_kerja']);

    if (!$nama || !$hp || !$rute_biasa || !$jadwal_kerja) {
        throw new Exception("Semua field wajib diisi.");
    }

    // Cek apakah HP sudah terdaftar
    $cek = $koneksi->prepare("SELECT id FROM data_driver WHERE hp = ?");
    $cek->bind_param("s", $hp);
    $cek->execute();
    $result = $cek->get_result();
    if ($result->num_rows > 0) {
        throw new Exception("No HP sudah terdaftar.");
    }

    // Insert
    $stmt = $koneksi->prepare("INSERT INTO data_driver (nama, hp, rute_biasa, jadwal_kerja) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $hp, $rute_biasa, $jadwal_kerja);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menambah data driver: " . $stmt->error);
    }

    $_SESSION['success'] = "Data driver berhasil ditambahkan.";
    header("Location: ../kelola-driver.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-driver.php");
}
