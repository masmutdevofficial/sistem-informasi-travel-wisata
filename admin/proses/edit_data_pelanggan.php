<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $stmt = $koneksi->prepare("UPDATE data_pelanggan SET nama_penumpang = ?, alamat_penumpang = ?, hp = ? WHERE id = ?");
        $stmt->bind_param("sssi", $_POST['nama_penumpang'], $_POST['alamat_penumpang'], $_POST['hp'], $id);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil diupdate.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengupdate data: " . $e->getMessage();
}
header("Location: ../data-pelanggan.php");