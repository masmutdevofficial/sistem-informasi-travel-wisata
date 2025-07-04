<?php
$title = 'CRUD ADMIN';

$customCss = '
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="../assets/plugins/tabler-icons/tabler.min.css">
';

$customJs = '
    <!-- DataTables  & Plugins -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/plugins/jszip/jszip.min.js"></script>
    <script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

';
?>

<?php include '../includes/admin_header.php' ?>
<?php include '../includes/alerts.php' ?>

<?php

// Ambil parameter filter
$tanggal_awal = $_GET['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');
$filter_jenis = $_GET['filter_jenis'] ?? 'semua';

// Query data
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

// Hitung total
$total_pemasukan = 0;
$total_pengeluaran = 0;
$data = [];

while ($row = $result->fetch_assoc()) {
    $pelunasan = $row['tambahan_dp'];
    $total_bayar = $row['jumlah_dp'] + $pelunasan;
    $pengeluaran = $row['total_pengeluaran'] ?? 0;

    if ($filter_jenis === 'pemasukan' && $total_bayar <= 0) continue;
    if ($filter_jenis === 'pengeluaran' && $pengeluaran <= 0) continue;

    $total_pemasukan += $total_bayar;
    $total_pengeluaran += $pengeluaran;
    $data[] = $row;
}

$keuntungan = $total_pemasukan - $total_pengeluaran;
/* =========================================================
   ── Statistik Tambahan ──
========================================================= */
// Hitung jumlah hari periode (inklusif)
$start  = new DateTime($tanggal_awal);
$end    = new DateTime($tanggal_akhir);
$diff   = $start->diff($end)->days + 1;     // +1 agar inklusif

$rata_pemasukan   = $diff ? $total_pemasukan   / $diff : 0;
$rata_pengeluaran = $diff ? $total_pengeluaran / $diff : 0;

/* ---- Top Pengeluaran Terbesar (berdasarkan filter) ---- */
$top_pengeluaran_query = $koneksi->prepare("
    SELECT 
        pg.keterangan,
        pg.jumlah_pengeluaran,
        dp.id AS id_pesanan,
        pl.nama_penumpang,
        dk.nama_kendaraan
    FROM pengeluaran pg
    JOIN data_pesanan dp ON pg.id_data_pesanan = dp.id
    JOIN data_pelanggan pl ON dp.id_data_pelanggan = pl.id
    JOIN data_kendaraan dk ON dp.id_kendaraan = dk.id
    WHERE DATE(pg.created_at) BETWEEN ? AND ?
    ORDER BY pg.jumlah_pengeluaran DESC
    LIMIT 5
");
$top_pengeluaran_query->bind_param('ss', $tanggal_awal, $tanggal_akhir);
$top_pengeluaran_query->execute();
$top_pengeluaran_result = $top_pengeluaran_query->get_result();

$top_pengeluaran = [];
while ($row = $top_pengeluaran_result->fetch_assoc()) {
    $top_pengeluaran[] = $row;
}
?>

<section class="content-header">
    <div class="container-fluid">
        <h1>Laporan Keuangan</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <!-- Filter -->
        <form class="mb-3" method="GET">
            <div class="form-row">
                <div class="col-md-3">
                    <label>Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?>">
                </div>
                <div class="col-md-3">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?>">
                </div>
                <div class="col-md-3">
                    <label>Filter Transaksi</label>
                    <select name="filter_jenis" class="form-control">
                        <option value="semua" <?= $filter_jenis == 'semua' ? 'selected' : '' ?>>Semua</option>
                        <option value="pemasukan" <?= $filter_jenis == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
                        <option value="pengeluaran" <?= $filter_jenis == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3 align-self-end">
                    <button class="btn btn-primary btn-block">Terapkan Filter</button>
                </div>
            </div>
        </form>

        <!-- Tabel Laporan -->
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title mb-0">Data Laporan</h3>
            </div>
            <div class="mb-3 d-flex justify-content-end align-items-center p-3">
                <a href="cetak/cetak-laporan.php?tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>" target="_blank" class="btn btn-success">
                    <i class="fa fa-print"></i> Cetak Laporan
                </a>
            </div>
            <div class="card-body">
                <table id="basicTable" class="table table-bordered table-striped">
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
                                <td>Rp<?= number_format($d['jumlah_dp'] + $d['tambahan_dp'], 0, ',', '.') ?></td>
                                <td>Rp<?= number_format($d['total_pengeluaran'] ?? 0, 0, ',', '.') ?></td>
                                <td>Rp<?= number_format(($d['jumlah_dp'] + $d['tambahan_dp']) - ($d['total_pengeluaran'] ?? 0), 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total:</th>
                            <th>Rp<?= number_format($total_pemasukan, 0, ',', '.') ?></th>
                            <th>Rp<?= number_format($total_pengeluaran, 0, ',', '.') ?></th>
                            <th>Rp<?= number_format($keuntungan, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
                <!-- Statistik Rata-rata & Top Pengeluaran -->
                <div class="row mt-3">

                    <!-- Rata-rata harian -->
                    <div class="col-md-4">
                        <div class="card bg-light shadow-sm h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-4 d-flex flex-column justify-content-center">
                                    <h5 class="card-title text-muted text-center">Rata-rata Pemasukan Harian</h5><br>
                                    <h3 class="text-success font-weight-bold">Rp<?= number_format($rata_pemasukan, 0, ',', '.') ?></h3>
                                </div>
                                <hr>
                                <div class="mt-4 d-flex flex-column justify-content-center">
                                    <h5 class="card-title text-muted text-center">Rata-rata Pengeluaran Harian</h5><br>
                                    <h3 class="text-danger font-weight-bold">Rp<?= number_format($rata_pengeluaran, 0, ',', '.') ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top 5 Pengeluaran -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-danger">
                                <h5 class="mb-0 text-white">Top 5 Pengeluaran Terbesar</h5>
                            </div>
                            <div class="card-body p-0">
                                <?php if ($top_pengeluaran): ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($top_pengeluaran as $tp): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong><?= htmlspecialchars($tp['nama_penumpang']) ?> (<?= htmlspecialchars($tp['nama_kendaraan']) ?>)</strong>
                                                    <small class="d-block text-muted"><?= htmlspecialchars($tp['keterangan'] ?: '-') ?></small>
                                                </div>
                                                <span class="badge badge-danger badge-pill">
                                                    Rp<?= number_format($tp['jumlah_pengeluaran'], 0, ',', '.') ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-center p-3 mb-0">Tidak ada data pengeluaran.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div> <!-- /.row -->
            </div>
        </div>
    </div>
</section>

<?php
    $bodyJs = <<<'EOD'
    <script>

    $(function () {
        $("#basicTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ]
        });
    });
    </script>
    EOD;
?>

<?php include '../includes/admin_footer.php' ?>