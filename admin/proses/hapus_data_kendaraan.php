<?php
session_start();
require '../../config/koneksi.php';

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $koneksi->prepare("DELETE FROM data_kendaraan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil dihapus.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
}
header("Location: ../data-kendaraan.php");