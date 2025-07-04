<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_pesanan  = (int) $_POST['id_data_pesanan'];
        $keterangan  = $_POST['keterangan'];
        $jumlah      = (float) $_POST['jumlah_pengeluaran'];

        /* --- cek id pesanan --- */
        $cek = $koneksi->prepare("SELECT id FROM data_pesanan WHERE id = ?");
        $cek->bind_param("i", $id_pesanan);
        $cek->execute();
        if ($cek->get_result()->num_rows === 0) {
            $_SESSION['error'] = "ID pemesanan tidak valid.";
            header("Location: ../data-pengeluaran.php?id={$id_pesanan}");
            exit;
        }

        /* --- insert pengeluaran --- */
        $stmt = $koneksi->prepare("INSERT INTO pengeluaran (id_data_pesanan, keterangan, jumlah_pengeluaran)
                                   VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $id_pesanan, $keterangan, $jumlah);
        $stmt->execute();

        $_SESSION['success'] = "Pengeluaran berhasil ditambahkan.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
}

/* kembali ke halaman pengeluaran pesanan ini */
header("Location: ../data-pengeluaran.php?id={$id_pesanan}");
exit;
