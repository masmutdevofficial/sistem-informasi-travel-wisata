<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Format waktu dari datetime-local: 2025-07-04T18:59 → 2025-07-04 18:59:00
        $waktu_berangkat = date('Y-m-d H:i:s', strtotime($_POST['waktu_berangkat']));
        $waktu_pulang = date('Y-m-d H:i:s', strtotime($_POST['waktu_pulang']));
        $status_bayar = $_POST['status_bayar'];
        $harga = floatval($_POST['harga']);
        $tambahan_dp = floatval($_POST['tambahan_dp']);

        if ($status_bayar === 'Lunas' && $tambahan_dp < $harga) {
            $_SESSION['error'] = "Jumlah pelunasan tidak boleh kurang dari harga.";
            header("Location: ../data-pemesanan.php");
            exit;
        }
        $stmt = $koneksi->prepare("UPDATE data_pesanan 
            SET 
                id_kendaraan = ?, 
                id_driver = ?, 
                id_data_pelanggan = ?, 
                waktu_berangkat = ?, 
                waktu_pulang = ?, 
                titik_jemput = ?, 
                jumlah_penumpang = ?, 
                jumlah_barang = ?, 
                harga = ?, 
                jumlah_dp = ?, 
                tambahan_dp = ?, 
                jenis_pemesanan = ?, 
                status_bayar = ?, 
                catatan = ?, 
                status_jemput = ?
            WHERE id = ?");

        // Cocokkan tipe parameter
        $stmt->bind_param(
            "iiisssiidddssssi",  // ← ini sudah benar 16 param
            $_POST['id_kendaraan'],            // i
            $_POST['id_driver'],               // i
            $_POST['id_data_pelanggan'],       // i
            $waktu_berangkat,                  // s
            $waktu_pulang,                     // s
            $_POST['titik_jemput'],            // s
            $_POST['jumlah_penumpang'],        // i
            $_POST['jumlah_barang'],           // i
            $_POST['harga'],                   // d
            $_POST['jumlah_dp'],               // d
            $_POST['tambahan_dp'],             // d
            $_POST['jenis_pemesanan'],         // s
            $_POST['status_bayar'],            // s
            $_POST['catatan'],                 // s
            $_POST['status_jemput'],           // s 
            $_POST['id']                       // i
        );

        $stmt->execute();
        $_SESSION['success'] = "Data berhasil diupdate.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengupdate data: " . $e->getMessage();
}
header("Location: ../data-pemesanan.php");
exit;
