<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $stmt = $koneksi->prepare("UPDATE data_kendaraan SET nama_kendaraan = ?, nomor_polisi = ?, kapasitas = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $_POST['nama_kendaraan'], $_POST['nomor_polisi'], $_POST['kapasitas'], $_POST['status'], $id);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil diupdate.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengupdate data: " . $e->getMessage();
}
header("Location: ../data-kendaraan.php");