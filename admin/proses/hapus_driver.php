<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];

    if (!$id) {
        throw new Exception("ID tidak ditemukan.");
    }

    $stmt = $koneksi->prepare("DELETE FROM data_driver WHERE id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menghapus data driver: " . $stmt->error);
    }

    $_SESSION['success'] = "Data driver berhasil dihapus.";
    header("Location: ../kelola-driver.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-driver.php");
}
