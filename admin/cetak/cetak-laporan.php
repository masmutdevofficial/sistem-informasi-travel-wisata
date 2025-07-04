<?php
require '../../config/koneksi.php';

$tanggal_awal = $_GET['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');

$query = $koneksi->prepare("
    SELECT 
        dp.*, 
        SUM(pg.jumlah_pengeluaran) AS total_pengeluaran,
        dk.nama_kendaraan,
        dd.nama AS nama_driver,
        pl.nama_penumpang
    FROM data_pesanan dp
    LEFT JOIN pengeluaran pg ON pg.id_data_pesanan = dp.id
    JOIN data_kendaraan dk ON dk.id = dp.id_kendaraan
    JOIN data_driver dd ON dd.id = dp.id_driver
    JOIN data_pelanggan pl ON pl.id = dp.id_data_pelanggan
    WHERE DATE(dp.created_at) BETWEEN ? AND ?
    GROUP BY dp.id
    ORDER BY dp.created_at DESC
");
$query->bind_param('ss', $tanggal_awal, $tanggal_akhir);
$query->execute();
$result = $query->get_result();

$total_pemasukan = 0;
$total_pengeluaran = 0;
$data = [];

while ($row = $result->fetch_assoc()) {
    $total_bayar = $row['jumlah_dp'] + $row['tambahan_dp'];
    $total_pemasukan += $total_bayar;
    $total_pengeluaran += $row['total_pengeluaran'] ?? 0;
    $row['total_bayar'] = $total_bayar;
    $row['keuntungan'] = $total_bayar - ($row['total_pengeluaran'] ?? 0);
    $data[] = $row;
}
$keuntungan = $total_pemasukan - $total_pengeluaran;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h4 { text-align: center; margin: 0; }
        .summary { margin-top: 30px; width: 100%; }
        .summary td { border: none; padding: 6px; }
    </style>
</head>
<body onload="window.print()">
    <h2>LAPORAN PEMASUKAN & PENGELUARAN</h2>
    <h4>Periode: <?= date('d/m/Y', strtotime($tanggal_awal)) ?> - <?= date('d/m/Y', strtotime($tanggal_akhir)) ?></h4>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Kendaraan</th>
                <th>Driver</th>
                <th>Total Bayar</th>
                <th>Pengeluaran</th>
                <th>Keuntungan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $d): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($d['created_at'])) ?></td>
                    <td><?= htmlspecialchars($d['nama_penumpang']) ?></td>
                    <td><?= htmlspecialchars($d['nama_kendaraan']) ?></td>
                    <td><?= htmlspecialchars($d['nama_driver']) ?></td>
                    <td>Rp<?= number_format($d['total_bayar'], 0, ',', '.') ?></td>
                    <td>Rp<?= number_format($d['total_pengeluaran'] ?? 0, 0, ',', '.') ?></td>
                    <td>Rp<?= number_format($d['keuntungan'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td><strong>Total Pemasukan</strong></td>
            <td>: Rp<?= number_format($total_pemasukan, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Total Pengeluaran</strong></td>
            <td>: Rp<?= number_format($total_pengeluaran, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td><strong>Keuntungan Bersih</strong></td>
            <td>: Rp<?= number_format($keuntungan, 0, ',', '.') ?></td>
        </tr>
    </table>
</body>
</html>
