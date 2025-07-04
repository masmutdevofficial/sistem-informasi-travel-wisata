<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $koneksi->prepare("INSERT INTO data_pelanggan (nama_penumpang, alamat_penumpang, hp) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['nama_penumpang'], $_POST['alamat_penumpang'], $_POST['hp']);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil ditambahkan.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
}
header("Location: ../data-pelanggan.php");