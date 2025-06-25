<?php
session_start();
require '../../config/koneksi.php';

try {
    extract($_POST);

    if (!$id_rute || !$nama_penumpang || !$hp || !$titik_jemput) {
        throw new Exception("Field wajib tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("INSERT INTO data_penumpang_travel 
        (id_rute, nama_penumpang, hp, tgl_berangkat, titik_jemput, jumlah_penumpang, harga, jumlah_dp, status_bayar, catatan, status_jemput)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssiddsss", 
        $id_rute, $nama_penumpang, $hp, $tgl_berangkat, $titik_jemput, 
        $jumlah_penumpang, $harga, $jumlah_dp, $status_bayar, $catatan, $status_jemput);
    $stmt->execute();

    $_SESSION['success'] = "Data penumpang berhasil ditambahkan.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-penumpang-travel.php");
