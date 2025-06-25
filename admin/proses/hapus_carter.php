<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];
    if (!$id) throw new Exception("ID tidak ditemukan.");

    $stmt = $koneksi->prepare("DELETE FROM data_penumpang_carter WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['success'] = "Data carter berhasil dihapus.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-carter.php");
