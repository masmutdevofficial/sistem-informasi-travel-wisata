<?php
session_start();
require '../../config/koneksi.php';

try {
    $id   = $_POST['id'];
    $nama = trim($_POST['nama_wisata']);

    if (!$id || !$nama) {
        throw new Exception("Field tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("UPDATE data_paket_wisata SET nama_wisata = ? WHERE id = ?");
    $stmt->bind_param("si", $nama, $id);
    $stmt->execute();

    $_SESSION['success'] = "Data wisata berhasil diperbarui.";
    header("Location: ../kelola-paket-wisata.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-paket-wisata.php");
}
