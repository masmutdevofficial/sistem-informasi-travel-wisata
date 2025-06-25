<?php
session_start();
require '../../config/koneksi.php';

try {
    extract($_POST);

    if (!$id || !$id_rute || !$nama_penumpang || !$hp || !$titik_jemput) {
        throw new Exception("Field wajib tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("UPDATE data_penumpang_travel SET 
        id_rute=?, nama_penumpang=?, hp=?, tgl_berangkat=?, titik_jemput=?, jumlah_penumpang=?, harga=?, jumlah_dp=?, status_bayar=?, catatan=?, status_jemput=? 
        WHERE id=?");
    $stmt->bind_param("issssiddsssi", 
        $id_rute, $nama_penumpang, $hp, $tgl_berangkat, $titik_jemput,
        $jumlah_penumpang, $harga, $jumlah_dp, $status_bayar, $catatan, $status_jemput, $id);
    $stmt->execute();

    $_SESSION['success'] = "Data penumpang berhasil diperbarui.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-penumpang-travel.php");
