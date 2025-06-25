<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];
    if (!$id) throw new Exception("ID tidak ditemukan.");

    $stmt = $koneksi->prepare("DELETE FROM data_peserta_wisata WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Peserta wisata berhasil dihapus.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-peserta-wisata.php");
