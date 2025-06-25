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

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Carter/Sewa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Data Carter/Sewa</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <h3 class="card-title">Data Carter/Sewa</h3>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <a class="btn btn-primary mr-2" href="pengeluaran.php">
                                    <i class="fa fa-plus mr-2"></i>Tambah Pengeluaran
                                </a>
                                <a class="btn btn-secondary mr-2" href="cetak/cetak-laporan.php">
                                    <i class="fa fa-print mr-2"></i>Cetak Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <?php
                    // Ambil data dari masing-masing tabel
                    $travel = mysqli_query($koneksi, "
                        SELECT tgl_berangkat AS tanggal, harga, jumlah_dp, status_bayar 
                        FROM data_penumpang_travel 
                        WHERE status_bayar != 'Belum Bayar'
                    ");

                    $carter = mysqli_query($koneksi, "
                        SELECT tgl_sewa AS tanggal, harga, jumlah_dp, status_bayar 
                        FROM data_penumpang_carter 
                        WHERE status_bayar != 'Belum Bayar'
                    ");

                    $wisata = mysqli_query($koneksi, "
                        SELECT tgl_keberangkatan AS tanggal, harga, jumlah_dp, status_bayar 
                        FROM data_peserta_wisata 
                        WHERE status_bayar != 'Belum Bayar'
                    ");

                    $laporan = [];
                    $total = 0;

                    // Ambil total pengeluaran
                    $pengeluaran = 0;
                    $query_pengeluaran = mysqli_query($koneksi, "SELECT jumlah_pengeluaran FROM pengeluaran");
                    while ($row = mysqli_fetch_assoc($query_pengeluaran)) {
                        $pengeluaran += $row['jumlah_pengeluaran'];
                    }

                    // Travel
                    while ($row = mysqli_fetch_assoc($travel)) {
                        $pemasukan = ($row['status_bayar'] === 'DP') ? $row['jumlah_dp'] : $row['harga'];
                        $laporan[] = [
                            'tanggal' => $row['tanggal'],
                            'kategori' => 'Travel',
                            'status_bayar' => $row['status_bayar'],
                            'pemasukan' => $pemasukan
                        ];
                        $total += $pemasukan;
                    }

                    // Carter
                    while ($row = mysqli_fetch_assoc($carter)) {
                        $pemasukan = ($row['status_bayar'] === 'DP') ? $row['jumlah_dp'] : $row['harga'];
                        $laporan[] = [
                            'tanggal' => $row['tanggal'],
                            'kategori' => 'Carter',
                            'status_bayar' => $row['status_bayar'],
                            'pemasukan' => $pemasukan
                        ];
                        $total += $pemasukan;
                    }

                    // Wisata
                    while ($row = mysqli_fetch_assoc($wisata)) {
                        $pemasukan = ($row['status_bayar'] === 'DP') ? $row['jumlah_dp'] : $row['harga'];
                        $laporan[] = [
                            'tanggal' => $row['tanggal'],
                            'kategori' => 'Wisata',
                            'status_bayar' => $row['status_bayar'],
                            'pemasukan' => $pemasukan
                        ];
                        $total += $pemasukan;
                    }

                    // Urutkan berdasarkan tanggal
                    usort($laporan, function($a, $b) {
                        return strtotime($a['tanggal']) - strtotime($b['tanggal']);
                    });

                    $total_bersih = $total - $pengeluaran;
                    ?>

                    <table id="basicTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Status Bayar</th>
                                <th>Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($laporan as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($item['kategori']) ?></td>
                                    <td><?= htmlspecialchars($item['status_bayar']) ?></td>
                                    <td>Rp <?= number_format($item['pemasukan'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total Pemasukan</th>
                                <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                            </tr>
                            <tr>
                                <th colspan="3">Total Pengeluaran</th>
                                <th>Rp <?= number_format($pengeluaran, 0, ',', '.') ?></th>
                            </tr>
                            <tr>
                                <th colspan="3">Total Bersih</th>
                                <th>Rp <?= number_format($total_bersih, 0, ',', '.') ?></th>
                            </tr>
                        </tfoot>
                    </table>


                    </div>
                    <!-- /.card-body -->

                </div>

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
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


    <script>
        function toggleDPCarter() {
            const status = document.getElementById('statusBayarCarter').value;
            const dp = document.getElementById('dpInputCarter');
            dp.style.display = status === 'DP' ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleDPCarter);
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>