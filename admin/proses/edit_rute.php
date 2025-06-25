<?php
session_start();
require '../../config/koneksi.php';

try {
    $id     = $_POST['id'];
    $asal   = trim($_POST['rute_asal']);
    $tujuan = trim($_POST['rute_tujuan']);

    if (!$id || !$asal || !$tujuan) {
        throw new Exception("Field tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("UPDATE data_rute SET rute_asal = ?, rute_tujuan = ? WHERE id = ?");
    $stmt->bind_param("ssi", $asal, $tujuan, $id);
    $stmt->execute();

    $_SESSION['success'] = "Data rute berhasil diperbarui.";
    header("Location: ../kelola-rute.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-rute.php");
}
