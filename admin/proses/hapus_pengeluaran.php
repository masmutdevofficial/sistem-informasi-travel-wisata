<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = intval($_POST['id']);

    if (!$id) {
        throw new Exception("ID tidak ditemukan.");
    }

    $stmt = $koneksi->prepare("DELETE FROM pengeluaran WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Pengeluaran berhasil dihapus.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header("Location: ../pengeluaran.php");
