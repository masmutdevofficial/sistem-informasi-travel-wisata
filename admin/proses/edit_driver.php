<?php
session_start();
require '../../config/koneksi.php';

try {
    $id           = $_POST['id'];
    $nama         = trim($_POST['nama']);
    $hp           = trim($_POST['hp']);
    $rute_biasa   = trim($_POST['rute_biasa']);
    $jadwal_kerja = trim($_POST['jadwal_kerja']);

    if (!$id || !$nama || !$hp || !$rute_biasa || !$jadwal_kerja) {
        throw new Exception("Semua field wajib diisi.");
    }

    // Cek apakah HP sudah dipakai driver lain
    $cek = $koneksi->prepare("SELECT id FROM data_driver WHERE hp = ? AND id != ?");
    $cek->bind_param("si", $hp, $id);
    $cek->execute();
    $result = $cek->get_result();
    if ($result->num_rows > 0) {
        throw new Exception("No HP sudah digunakan oleh driver lain.");
    }

    // Update
    $stmt = $koneksi->prepare("UPDATE data_driver SET nama = ?, hp = ?, rute_biasa = ?, jadwal_kerja = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nama, $hp, $rute_biasa, $jadwal_kerja, $id);

    if (!$stmt->execute()) {
        throw new Exception("Gagal mengedit data driver: " . $stmt->error);
    }

    $_SESSION['success'] = "Data driver berhasil diperbarui.";
    header("Location: ../kelola-driver.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-driver.php");
}
