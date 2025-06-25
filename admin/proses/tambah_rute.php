<?php
session_start();
require '../../config/koneksi.php';

try {
    $asal   = trim($_POST['rute_asal']);
    $tujuan = trim($_POST['rute_tujuan']);

    if (!$asal || !$tujuan) {
        throw new Exception("Rute asal dan tujuan wajib diisi.");
    }

    $stmt = $koneksi->prepare("INSERT INTO data_rute (rute_asal, rute_tujuan) VALUES (?, ?)");
    $stmt->bind_param("ss", $asal, $tujuan);
    $stmt->execute();

    $_SESSION['success'] = "Data rute berhasil ditambahkan.";
    header("Location: ../kelola-rute.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-rute.php");
}
