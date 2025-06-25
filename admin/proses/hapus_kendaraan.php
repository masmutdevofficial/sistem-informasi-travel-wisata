<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];

    if (!$id) {
        throw new Exception("ID tidak ditemukan.");
    }

    $stmt = $koneksi->prepare("DELETE FROM data_kendaraan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Data kendaraan berhasil dihapus.";
    header("Location: ../kelola-kendaraan.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-kendaraan.php");
}
