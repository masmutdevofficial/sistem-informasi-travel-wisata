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
                <h1>Data Pengeluaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Pengeluaran</li>
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
                            <h3 class="card-title">Data Pengeluaran</h3>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalTambahBasic">
                                    <i class="fa fa-plus mr-2"></i>Tambah Pengeluaran
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM pengeluaran ORDER BY id DESC");
                    ?>

                    <table id="basicTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th>Jumlah Pengeluaran</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                                <td>Rp<?= number_format($row['jumlah_pengeluaran'], 0, ',', '.') ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus<?= $row['id'] ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="proses/edit_pengeluaran.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Pengeluaran</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" required><?= htmlspecialchars($row['keterangan']) ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Jumlah Pengeluaran</label>
                                                    <input type="number" step="0.01" name="jumlah_pengeluaran" value="<?= $row['jumlah_pengeluaran'] ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-warning">Update</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Hapus -->
                            <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="proses/hapus_pengeluaran.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Pengeluaran</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus pengeluaran dengan keterangan:
                                                <strong><?= htmlspecialchars($row['keterangan']) ?></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    </div>
                    <!-- /.card-body -->

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="modalTambahBasic" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="proses/tambah_pengeluaran.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Tambah Pengeluaran</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Pengeluaran</label>
                                    <input type="number" step="0.01" name="jumlah_pengeluaran" class="form-control" required>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

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

    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>