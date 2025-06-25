<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];

    if (empty($id)) {
        throw new Exception("ID tidak ditemukan.");
    }

    // Cegah hapus admin ID = 1
    if ($id == 1) {
        throw new Exception("Admin utama tidak boleh dihapus.");
    }

    $query = "DELETE FROM admin WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menghapus data: " . $stmt->error);
    }

    $_SESSION['success'] = "Data admin berhasil dihapus.";
    header("Location: ../kelola-admin.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-admin.php");
}
