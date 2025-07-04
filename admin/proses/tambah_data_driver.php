<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $koneksi->prepare("INSERT INTO data_driver (nama, hp) VALUES (?, ?)");
        $stmt->bind_param("ss", $_POST['nama'], $_POST['hp']);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil ditambahkan.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
}
header("Location: ../data-driver.php");