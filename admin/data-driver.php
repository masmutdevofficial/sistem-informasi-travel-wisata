<?php
$title = 'ADMIN TRAVEL';

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
                <h1>Data Driver</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Data Driver</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title mb-0">Data Driver</h3>
                        <div class="ml-auto">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="basicTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = $koneksi->query("SELECT * FROM data_driver ORDER BY created_at DESC");
                                while ($row = $query->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['hp']) ?></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>">Edit</a>
                                        <a href="proses/hapus_data_driver.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="proses/edit_data_driver.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama" class="form-control" value="<?= isset($row) ? htmlspecialchars($row['nama']) : '' ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>No HP</label>
                                                        <input type="text" name="hp" class="form-control" value="<?= isset($row) ? htmlspecialchars($row['hp']) : '' ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
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
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="proses/tambah_data_driver.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?= isset($row) ? htmlspecialchars($row['nama']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="hp" class="form-control" value="<?= isset($row) ? htmlspecialchars($row['hp']) : '' ?>" required>
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