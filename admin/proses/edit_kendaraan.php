<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];
    $nomor_polisi = trim($_POST['nomor_polisi']);
    $kapasitas = (int) $_POST['kapasitas'];
    $status = $_POST['status'];

    if (!$id || !$nomor_polisi || !$kapasitas) {
        throw new Exception("Semua field wajib diisi.");
    }

    $stmt = $koneksi->prepare("UPDATE data_kendaraan SET nomor_polisi=?, kapasitas=?, status=? WHERE id=?");
    $stmt->bind_param("sisi", $nomor_polisi, $kapasitas, $status, $id);
    $stmt->execute();

    $_SESSION['success'] = "Data kendaraan berhasil diperbarui.";
    header("Location: ../kelola-kendaraan.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-kendaraan.php");
}
