<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = intval($_POST['id']);
    $keterangan = trim($_POST['keterangan']);
    $jumlah = floatval($_POST['jumlah_pengeluaran']);

    if (!$id || !$keterangan || !$jumlah) {
        throw new Exception("Semua field wajib diisi.");
    }

    $stmt = $koneksi->prepare("UPDATE pengeluaran SET keterangan = ?, jumlah_pengeluaran = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("sdi", $keterangan, $jumlah, $id);
    $stmt->execute();

    $_SESSION['success'] = "Pengeluaran berhasil diperbarui.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header("Location: ../pengeluaran.php");
