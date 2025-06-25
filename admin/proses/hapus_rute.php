<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];
    if (!$id) {
        throw new Exception("ID tidak ditemukan.");
    }

    $stmt = $koneksi->prepare("DELETE FROM data_rute WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Data rute berhasil dihapus.";
    header("Location: ../kelola-rute.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-rute.php");
}
