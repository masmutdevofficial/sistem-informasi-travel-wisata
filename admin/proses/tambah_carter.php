<?php
session_start();
require '../../config/koneksi.php';

try {
    extract($_POST);

    if (!$id_kendaraan || !$id_driver || !$nama_penyewa || !$tgl_sewa || !$durasi || !$tujuan || !$harga) {
        throw new Exception("Semua field wajib diisi.");
    }

    // Pastikan jumlah_dp selalu ada nilai (default 0 jika tidak diisi)
    $jumlah_dp = isset($jumlah_dp) && $jumlah_dp !== '' ? floatval($jumlah_dp) : 0;

    $stmt = $koneksi->prepare("INSERT INTO data_penumpang_carter 
        (id_kendaraan, id_driver, nama_penyewa, tgl_sewa, durasi, tujuan, harga, jumlah_dp, status_bayar)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssdss", $id_kendaraan, $id_driver, $nama_penyewa, $tgl_sewa, $durasi, $tujuan, $harga, $jumlah_dp, $status_bayar);
    $stmt->execute();

    $_SESSION['success'] = "Data carter berhasil ditambahkan.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-carter.php");
