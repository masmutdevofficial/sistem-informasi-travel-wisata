<?php
session_start();
require '../../config/koneksi.php';

try {
    extract($_POST);

    if (!$id || !$id_kendaraan || !$id_driver || !$nama_penyewa || !$tgl_sewa || !$durasi || !$tujuan || !$harga) {
        throw new Exception("Semua field wajib diisi.");
    }

    $stmt = $koneksi->prepare("UPDATE data_penumpang_carter SET 
        id_kendaraan=?, id_driver=?, nama_penyewa=?, tgl_sewa=?, durasi=?, tujuan=?, harga=?, jumlah_dp=?, status_bayar=? 
        WHERE id=?");
    $stmt->bind_param("iissssdssi", $id_kendaraan, $id_driver, $nama_penyewa, $tgl_sewa, $durasi, $tujuan, $harga, $jumlah_dp, $status_bayar, $id);
    $stmt->execute();

    $_SESSION['success'] = "Data carter berhasil diperbarui.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-carter.php");
