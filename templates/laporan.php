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

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>DataTables</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">DataTables</li>
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
                            <h3 class="card-title">Advanced Tables</h3>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button"
                                    id="dropdownAdvancedAction" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-cogs mr-1"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAdvancedAction">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#modalExportExcelAdvanced">
                                        <i class="fa fa-file-excel mr-2"></i>Export Excel
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#modalExportPDFAdvanced">
                                        <i class="fa fa-file-pdf mr-2"></i>Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 px-3 pt-2">
                        <div class="col-md-2">
                            <label>Filter Level:</label>
                            <select id="filterLevel" class="form-control">
                                <option value="">Semua Level</option>
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Dari Tanggal:</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Sampai Tanggal:</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label>Export:</label>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button"
                                    id="dropdownAdvancedAction" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-cogs mr-1"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAdvancedAction">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#modalExportExcelAdvanced">
                                        <i class="fa fa-file-excel mr-2"></i>Export Excel
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#modalExportPDFAdvanced">
                                        <i class="fa fa-file-pdf mr-2"></i>Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
                ?>
                        <table id="advancedTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>HP</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['hp']) ?></td>
                                    <td><?= $row['level'] == 1 ? 'User' : 'Admin' ?></td>
                                    <td>
                                        <span
                                            class="badge badge-<?= $row['status'] == 1 ? 'success' : 'secondary' ?> toggle-status"
                                            data-id="<?= $row['id'] ?>" style="cursor:pointer">
                                            <?= $row['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </td>
                                    <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
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
        const table = $("#advancedTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "lengthMenu": [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ],
        });

        // Filter Level (kolom ke-5, index 4)
        $('#filterLevel').on('change', function () {
            const val = $(this).val();
            table.column(4).search(val).draw(); // index kolom dimulai dari 0
        });

        // Filter Tanggal
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
            const start = $('#startDate').val();
            const end = $('#endDate').val();
            const createdAt = data[6] || ''; // created_at di kolom ke-6 (index 6)

            if (!start && !end) return true;

            const date = new Date(createdAt);
            const startDate = start ? new Date(start) : null;
            const endDate = end ? new Date(end) : null;

            if ((startDate === null || date >= startDate) &&
                (endDate === null || date <= endDate)) {
                return true;
            }

            return false;
            }
        );

        $('#startDate, #endDate').on('change', function () {
            table.draw();
        });
    });
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>