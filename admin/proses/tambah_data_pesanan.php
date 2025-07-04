<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /* ==============================================
           Ambil & siapkan value
        ============================================== */
        $id_kendaraan      = (int) $_POST['id_kendaraan'];
        $id_driver         = (int) $_POST['id_driver'];
        $id_pelanggan      = (int) $_POST['id_data_pelanggan'];

        // Konversi datetime-local → MySQL DATETIME
        $waktu_berangkat   = date('Y-m-d H:i:s', strtotime($_POST['waktu_berangkat']));
        $waktu_pulang      = date('Y-m-d H:i:s', strtotime($_POST['waktu_pulang']));

        $titik_jemput      = $_POST['titik_jemput'] ?? null;
        $jumlah_penumpang  = (int) ($_POST['jumlah_penumpang'] ?? 0);
        $jumlah_barang     = (int) ($_POST['jumlah_barang'] ?? 0);
        $harga             = (float) $_POST['harga'];
        $jumlah_dp         = (float) ($_POST['jumlah_dp'] ?? 0);
        $tambahan_dp       = (float) ($_POST['tambahan_dp'] ?? 0);
        $jenis_pemesanan   = $_POST['jenis_pemesanan'];
        $status_bayar      = $_POST['status_bayar'];
        $catatan           = $_POST['catatan'] ?? '';
        $status_jemput     = $_POST['status_jemput'];

        /* ==============================================
           Query
        ============================================== */
        $sql = "
            INSERT INTO data_pesanan (
                id_kendaraan, id_driver, id_data_pelanggan,
                waktu_berangkat, waktu_pulang, titik_jemput,
                jumlah_penumpang, jumlah_barang, harga,
                jumlah_dp, tambahan_dp, jenis_pemesanan,
                status_bayar, catatan, status_jemput
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";

        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param(
            "iiisssiidddssss",
            $id_kendaraan,
            $id_driver,
            $id_pelanggan,
            $waktu_berangkat,
            $waktu_pulang,
            $titik_jemput,
            $jumlah_penumpang,
            $jumlah_barang,
            $harga,
            $jumlah_dp,
            $tambahan_dp,
            $jenis_pemesanan,
            $status_bayar,
            $catatan,
            $status_jemput
        );
        $stmt->execute();

        $_SESSION['success'] = "Data berhasil ditambahkan.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
}

header("Location: ../data-pemesanan.php");
