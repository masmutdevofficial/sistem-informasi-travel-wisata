<?php
session_start();
require '../../config/koneksi.php';

try {
    $nama = trim($_POST['nama_wisata']);
    if (!$nama) {
        throw new Exception("Nama wisata tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("INSERT INTO data_paket_wisata (nama_wisata) VALUES (?)");
    $stmt->bind_param("s", $nama);
    $stmt->execute();

    $_SESSION['success'] = "Data wisata berhasil ditambahkan.";
    header("Location: ../kelola-paket-wisata.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-paket-wisata.php");
}
