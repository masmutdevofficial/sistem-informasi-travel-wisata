<?php
session_start();
require '../../config/koneksi.php';

try {
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        if ($id === 1) {
            $_SESSION['error'] = "Admin utama tidak boleh dihapus.";
        } else {
            $stmt = $koneksi->prepare("DELETE FROM admin WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $_SESSION['success'] = "Data berhasil dihapus.";
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
}

header("Location: ../data-admin.php");
