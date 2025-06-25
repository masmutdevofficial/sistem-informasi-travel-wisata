<?php
session_start();
require '../../config/koneksi.php';

try {
    $nomor_polisi = trim($_POST['nomor_polisi']);
    $kapasitas = (int) $_POST['kapasitas'];
    $status = $_POST['status'];

    if (!$nomor_polisi || !$kapasitas) {
        throw new Exception("Nomor polisi dan kapasitas wajib diisi.");
    }

    $stmt = $koneksi->prepare("INSERT INTO data_kendaraan (nomor_polisi, kapasitas, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nomor_polisi, $kapasitas, $status);
    $stmt->execute();

    $_SESSION['success'] = "Data kendaraan berhasil ditambahkan.";
    header("Location: ../kelola-kendaraan.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-kendaraan.php");
}
