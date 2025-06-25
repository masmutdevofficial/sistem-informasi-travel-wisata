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
                            <h3 class="card-title">Basic Tables</h3>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalTambahBasic">
                                    <i class="fa fa-plus mr-2"></i>Tambah Data
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-print mr-2"></i>Export Data
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="export_excel.php"><i class="fa fa-file-excel mr-2 text-success"></i>Export Excel</a>
                                        <a class="dropdown-item" href="export_pdf.php"><i class="fa fa-file-pdf mr-2 text-danger"></i>Export PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
                ?>
                        <table id="basicTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>HP</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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
                                    <td><?= $row['status'] == 1 ? 'Aktif' : 'Nonaktif' ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <!-- Tombol Modal -->
                                            <button class="btn btn-sm btn-warning mr-2" data-toggle="modal"
                                                data-target="#modalEdit<?= $row['id'] ?>">
                                                <i class="fa fa-edit mr-1"></i>Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#modalHapus<?= $row['id'] ?>">
                                                <i class="fa fa-trash mr-1"></i>Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="edit-user.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama"
                                                            value="<?= htmlspecialchars($row['nama']) ?>"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email"
                                                            value="<?= htmlspecialchars($row['email']) ?>"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>No HP</label>
                                                        <input type="text" name="hp"
                                                            value="<?= htmlspecialchars($row['hp']) ?>"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Alamat</label>
                                                        <textarea name="alamat"
                                                            class="form-control"><?= htmlspecialchars($row['alamat']) ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="hapus-user.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Yakin ingin menghapus data user
                                                    <strong><?= htmlspecialchars($row['nama']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
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
                    <div class="modal fade" id="modalTambahBasic" tabindex="-1" aria-labelledby="modalTambahBasicLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="tambah-user.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTambahBasicLabel">Tambah Data User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- input fields -->
                                        <div class="mb-3">
                                            <label>Nama</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>No HP</label>
                                            <input type="text" name="hp" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Alamat</label>
                                            <textarea name="alamat" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <span id="batas" class="d-block"></span>

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <h3 class="card-title">Advanced Tables</h3>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button"
                                    id="dropdownAdvancedAction" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-cogs mr-1"></i> Menu
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAdvancedAction">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalTambahAdvanced">
                                    <i class="fa fa-plus mr-2 text-primary"></i>Tambah Data
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalExportExcelAdvanced">
                                    <i class="fa fa-file-excel mr-2 text-success"></i>Export Excel
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalExportPDFAdvanced">
                                    <i class="fa fa-file-pdf mr-2 text-danger"></i>Export PDF
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalBulkEditAdvanced">
                                    <i class="fa fa-edit mr-2 text-warning"></i>Bulk Edit
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalBulkDeleteAdvanced">
                                    <i class="fa fa-trash mr-2 text-danger"></i>Bulk Delete
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#modalBersihkanAdvanced">
                                    <i class="fa fa-eraser mr-2 text-danger"></i>Bersihkan
                                </a>
                            </div>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 px-3 pt-2">
                        <div class="col-md-4">
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
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
                ?>
                        <table id="advancedTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>HP</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="<?= $row['id'] ?>"></td>
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
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <!-- Dropdown Aksi -->
                                            <div class="btn-group mr-2">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="detail-user.php?id=<?= $row['id'] ?>"><i
                                                            class="fa fa-eye mr-1"></i>Detail</a>
                                                    <a class="dropdown-item" href="edit-user.php?id=<?= $row['id'] ?>"><i
                                                            class="fa fa-edit mr-1"></i>Edit</a>
                                                    <a class="dropdown-item text-danger"
                                                        href="hapus-user.php?id=<?= $row['id'] ?>"
                                                        onclick="return confirm('Yakin?')"><i
                                                            class="fa fa-trash mr-1"></i>Hapus</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-file-excel mr-1"></i>Export Excel</a>
                                                    <a class="dropdown-item" href="#"><i
                                                            class="fa fa-file-pdf mr-1"></i>Export PDF</a>
                                                    <a class="dropdown-item" href="#"><i class="fa fa-image mr-1"></i>Export
                                                        PNG</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item copy-url" href="#"
                                                        data-url="https://example.com/u/<?= $row['id'] ?>"><i
                                                            class="fa fa-copy mr-1"></i>Copy URL</a>
                                                    <a class="dropdown-item"
                                                        href="https://wa.me/<?= $row['hp'] ?>?text=Halo+<?= urlencode($row['nama']) ?>"
                                                        target="_blank">
                                                        <i class="ti ti-brand-whatsapp mr-1"></i>WhatsApp
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Toggle Aktif / Tidak Aktif -->
                                            <button
                                                class="btn btn-sm toggle-btn-status mr-2 <?= $row['status'] == 1 ? 'btn-success' : 'btn-secondary' ?>"
                                                data-id="<?= $row['id'] ?>" data-status="<?= $row['status'] ?>">
                                                <?= $row['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?>
                                            </button>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input toggle-switch-status"
                                                    id="statusSwitch<?= $row['id'] ?>" data-id="<?= $row['id'] ?>"
                                                    <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                                <label class="custom-control-label" for="statusSwitch<?= $row['id'] ?>">
                                                    <?= $row['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
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
    $("#basicTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "lengthMenu": [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ]
    });

    const table = $("#advancedTable").DataTable({
    "responsive": true,
    "lengthChange": true,
    "autoWidth": false,
    "lengthMenu": [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ],
    "order": [[1, 'asc']], // Atur default order ke kolom ke-2 (nama)
    "columnDefs": [
        { "orderable": false, "targets": 0 } // Nonaktifkan urutan untuk kolom index 0 (pertama)
    ]
    });

    // Filter Level (kolom ke-5, index 4)
    $('#filterLevel').on('change', function () {
        const val = $(this).val();
        table.column(5).search(val).draw(); // index kolom dimulai dari 0
    });

    // Filter Tanggal
    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
        const start = $('#startDate').val();
        const end = $('#endDate').val();
        const createdAt = data[7] || ''; // created_at di kolom ke-7 (index 6)

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

    $(document).on('click', '.toggle-btn-status', function () {
        const $btn = $(this);
        const currentStatus = parseInt($btn.attr('data-status'));
        const newStatus = currentStatus === 1 ? 0 : 1;

        // Update UI
        $btn
        .toggleClass('btn-success btn-secondary')
        .text(newStatus === 1 ? 'Aktif' : 'Tidak Aktif')
        .attr('data-status', newStatus);

        // Optional: AJAX update ke database
        // const userId = $btn.data('id');
        // $.post('update-status.php', { id: userId, status: newStatus }, function(res) {
        //   console.log(res);
        // });
    });

    $(document).on('change', '.toggle-switch-status', function () {
        const $checkbox = $(this);
        const isChecked = $checkbox.is(':checked');
        const label = $checkbox.next('label');
        const newStatus = isChecked ? 1 : 0;

        // Update label text
        label.text(isChecked ? 'Aktif' : 'Tidak Aktif');

        // Optional: Ajax ke server
        // const userId = $checkbox.data('id');
        // $.post('update-status.php', { id: userId, status: newStatus }, function (res) {
        //     console.log(res);
        // });
    });
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>