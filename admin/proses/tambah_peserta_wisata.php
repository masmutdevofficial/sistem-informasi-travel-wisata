<?php
session_start();
require '../../config/koneksi.php';

try {
    extract($_POST);

    if (!$id_data_paket_wisata || !$nama_peserta || !$tgl_keberangkatan || !$jumlah_orang || !$harga) {
        throw new Exception("Field wajib tidak boleh kosong.");
    }

    $stmt = $koneksi->prepare("INSERT INTO data_peserta_wisata (id_data_paket_wisata, nama_peserta, tgl_keberangkatan, jumlah_orang, harga, jumlah_dp, status_bayar, catatan) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiddss", $id_data_paket_wisata, $nama_peserta, $tgl_keberangkatan, $jumlah_orang, $harga, $jumlah_dp, $status_bayar, $catatan);
    $stmt->execute();

    $_SESSION['success'] = "Peserta wisata berhasil ditambahkan.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header("Location: ../data-peserta-wisata.php");
