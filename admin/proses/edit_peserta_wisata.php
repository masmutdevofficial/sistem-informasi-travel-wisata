<?php
session_start();
require '../../config/koneksi.php';

try {
    extract($_POST);

    if (!$id || !$id_data_paket_wisata || !$nama_peserta || !$tgl_keberangkatan || !$jumlah_orang || !$harga) {
        throw new Exception("Field wajib tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("UPDATE data_peserta_wisata SET 
        id_data_paket_wisata=?, nama_peserta=?, tgl_keberangkatan=?, jumlah_orang=?, harga=?, jumlah_dp=?, status_bayar=?, catatan=? 
        WHERE id=?");
    $stmt->bind_param("issiddssi", $id_data_paket_wisata, $nama_peserta, $tgl_keberangkatan, $jumlah_orang, $harga, $jumlah_dp, $status_bayar, $catatan, $id);
    $stmt->execute();

    $_SESSION['success'] = "Data peserta berhasil diperbarui.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-peserta-wisata.php");
