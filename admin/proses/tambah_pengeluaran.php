<?php
session_start();
require '../../config/koneksi.php';

try {
    $keterangan = trim($_POST['keterangan']);
    $jumlah = floatval($_POST['jumlah_pengeluaran']);

    if (!$keterangan || !$jumlah) {
        throw new Exception("Semua field wajib diisi.");
    }

    $stmt = $koneksi->prepare("INSERT INTO pengeluaran (keterangan, jumlah_pengeluaran) VALUES (?, ?)");
    $stmt->bind_param("sd", $keterangan, $jumlah);
    $stmt->execute();

    $_SESSION['success'] = "Pengeluaran berhasil ditambahkan.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header("Location: ../pengeluaran.php");
