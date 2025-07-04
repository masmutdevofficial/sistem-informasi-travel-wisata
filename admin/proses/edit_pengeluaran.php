<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_pengeluaran = (int) $_POST['id'];                // id baris pengeluaran
        $id_pesanan     = (int) $_POST['id_data_pesanan'];   // relasi pesanan
        $keterangan     = $_POST['keterangan'];
        $jumlah         = (float) $_POST['jumlah_pengeluaran'];

        /* --- pastikan id pesanan valid --- */
        $cekPesanan = $koneksi->prepare("SELECT id FROM data_pesanan WHERE id = ?");
        $cekPesanan->bind_param("i", $id_pesanan);
        $cekPesanan->execute();
        if ($cekPesanan->get_result()->num_rows === 0) {
            $_SESSION['error'] = "ID pemesanan tidak valid.";
            header("Location: ../data-pengeluaran.php?id={$id_pesanan}");
            exit;
        }

        /* --- update pengeluaran --- */
        $stmt = $koneksi->prepare("UPDATE pengeluaran
                                   SET id_data_pesanan = ?, keterangan = ?, jumlah_pengeluaran = ?
                                   WHERE id = ?");
        $stmt->bind_param("isdi", $id_pesanan, $keterangan, $jumlah, $id_pengeluaran);
        $stmt->execute();

        $_SESSION['success'] = "Pengeluaran berhasil diupdate.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengupdate data: " . $e->getMessage();
}

header("Location: ../data-pengeluaran.php?id={$id_pesanan}");
exit;
