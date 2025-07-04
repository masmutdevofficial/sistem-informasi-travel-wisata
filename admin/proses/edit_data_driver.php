<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $stmt = $koneksi->prepare("UPDATE data_driver SET nama = ?, hp = ? WHERE id = ?");
        $stmt->bind_param("ssi", $_POST['nama'], $_POST['hp'], $id);
        $stmt->execute();
        $_SESSION['success'] = "Data berhasil diupdate.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengupdate data: " . $e->getMessage();
}
header("Location: ../data-driver.php");