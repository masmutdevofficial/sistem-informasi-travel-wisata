<?php
session_start();
require '../config/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid");
}
$id = (int) $_GET['id'];

$sql = "
SELECT 
    dp.*, 
    dk.nama_kendaraan, dk.nomor_polisi,
    dr.nama AS nama_driver, 
    pl.nama_penumpang, pl.alamat_penumpang, pl.hp AS hp_pelanggan
FROM data_pesanan dp
JOIN data_kendaraan dk ON dk.id = dp.id_kendaraan
JOIN data_driver dr ON dr.id = dp.id_driver
JOIN data_pelanggan pl ON pl.id = dp.id_data_pelanggan
WHERE dp.id = ?
";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) die("Data tidak ditemukan.");
$p = $res->fetch_assoc();

// Format
function rp($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}
function tgl($t) {
    return date('d/m/Y H:i', strtotime($t));
}
$tagihan     = (float) $p['harga'];
$dp          = (float) $p['jumlah_dp'];
$pelunasan   = (float) $p['tambahan_dp'];
$sisa        = max(0, $tagihan - $dp - $pelunasan);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $id ?></title>
    <style>
        body { font-family: 'Courier New', monospace; background: #f9f9f9; padding: 20px; }
        .receipt {
            width: 360px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border: 1px dashed #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .center { text-align: center; }
        .line { border-top: 1px dashed #ccc; margin: 10px 0; }
        .label { display: flex; justify-content: space-between; }
        .bold { font-weight: bold; }
        .mt-2 { margin-top: 10px; }
        .small { font-size: 12px; color: #777; }
        .btn-print {
            display: block;
            margin: 20px auto 0;
            padding: 8px 20px;
            font-weight: bold;
        }
        @media print {
            .btn-print { display: none; }
            body { background: #fff; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="center">
            <h3>TRAVEL WISATA</h3>
            <div class="small">Jl. Contoh No.1, Telp 0812-3456-7890</div>
        </div>
        <div class="line"></div>

        <div class="label"><span>No Invoice</span><span>#INV-<?= sprintf('%05d', $id) ?></span></div>
        <div class="label"><span>Tanggal</span><span><?= date('d/m/Y') ?></span></div>

        <div class="line"></div>
        <div class="bold">Pelanggan</div>
        <div><?= htmlspecialchars($p['nama_penumpang']) ?></div>
        <div class="small"><?= htmlspecialchars($p['alamat_penumpang']) ?> - <?= $p['hp_pelanggan'] ?></div>

        <div class="line"></div>
        <div class="bold">Detail Perjalanan</div>
        <div class="label"><span>Jenis</span><span><?= $p['jenis_pemesanan'] ?></span></div>
        <div class="label"><span>Berangkat</span><span><?= tgl($p['waktu_berangkat']) ?></span></div>
        <div class="label"><span>Pulang</span><span><?= tgl($p['waktu_pulang']) ?></span></div>
        <div class="label"><span>Kendaraan</span><span><?= $p['nama_kendaraan'] ?></span></div>
        <div class="label"><span>Plat</span><span><?= $p['nomor_polisi'] ?></span></div>
        <div class="label"><span>Driver</span><span><?= $p['nama_driver'] ?></span></div>
        <?php if ($p['titik_jemput']): ?>
            <div class="label"><span>Jemput</span><span><?= htmlspecialchars($p['titik_jemput']) ?></span></div>
        <?php endif; ?>
        <?php if ($p['jumlah_penumpang']): ?>
            <div class="label"><span>Penumpang</span><span><?= $p['jumlah_penumpang'] ?></span></div>
        <?php endif; ?>
        <?php if ($p['jumlah_barang']): ?>
            <div class="label"><span>Barang</span><span><?= $p['jumlah_barang'] ?></span></div>
        <?php endif; ?>

        <div class="line"></div>
        <div class="bold">Ringkasan Biaya</div>
        <div class="label"><span>Total</span><span><?= rp($tagihan) ?></span></div>
        <div class="label"><span>DP</span><span>- <?= rp($dp) ?></span></div>
        <div class="label"><span>Pelunasan</span><span>- <?= rp($pelunasan) ?></span></div>
        <div class="label bold"><span>Sisa Bayar</span><span><?= rp($sisa) ?></span></div>

        <?php if ($p['catatan']): ?>
            <div class="line"></div>
            <div class="bold">Catatan</div>
            <div class="small"><?= nl2br(htmlspecialchars($p['catatan'])) ?></div>
        <?php endif; ?>

        <div class="line"></div>
        <div class="center small">Terima kasih telah menggunakan layanan kami</div>
    </div>

    <button onclick="window.print()" class="btn-print">Cetak / Simpan PDF</button>
</body>
</html>
