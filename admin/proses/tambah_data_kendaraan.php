<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $koneksi->prepare("INSERT INTO data_kendaraan (nama_kendaraan, nomor_polisi, kapasitas, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $_POST['nama_kendaraan'], $_POST['nomor_polisi'], $_POST['kapasitas'], $_POST['status']);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil ditambahkan.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
}
header("Location: ../data-kendaraan.php");