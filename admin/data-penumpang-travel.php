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
                <h1>Data Penumpang Travel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Data Penumpang Travel</li>
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
                            <h3 class="card-title">Data Penumpang Travel</h3>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalTambahBasic">
                                    <i class="fa fa-plus mr-2"></i>Tambah Travel
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <?php
                    $query = mysqli_query($koneksi, "SELECT t.*, r.rute_asal, r.rute_tujuan 
                        FROM data_penumpang_travel t 
                        JOIN data_rute r ON r.id = t.id_rute 
                        ORDER BY t.id DESC");
                    ?>

                    <table id="basicTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Penumpang</th>
                                <th>Rute</th>
                                <th>Tgl Berangkat</th>
                                <th>Jumlah</th>
                                <th>Status Bayar</th>
                                <th>Status Jemput</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_penumpang']) ?><br><small><?= $row['hp'] ?></small></td>
                                <td><?= "{$row['rute_asal']} → {$row['rute_tujuan']}" ?></td>
                                <td><?= $row['tgl_berangkat'] ?></td>
                                <td><?= $row['jumlah_penumpang'] ?></td>
                                <td><span class="badge badge-info"><?= $row['status_bayar'] ?></span></td>
                                <td><span class="badge badge-secondary"><?= $row['status_jemput'] ?></span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus<?= $row['id'] ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <form action="proses/edit_penumpang_travel.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Penumpang</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Rute</label>
                                                        <select name="id_rute" class="form-control" required>
                                                            <?php
                                                            $rute = mysqli_query($koneksi, "SELECT * FROM data_rute");
                                                            while ($r = mysqli_fetch_assoc($rute)) {
                                                                $selected = $r['id'] == $row['id_rute'] ? 'selected' : '';
                                                                echo "<option value='{$r['id']}' $selected>{$r['rute_asal']} → {$r['rute_tujuan']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Nama Penumpang</label>
                                                        <input type="text" name="nama_penumpang" value="<?= $row['nama_penumpang'] ?>" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>HP</label>
                                                        <input type="text" name="hp" value="<?= $row['hp'] ?>" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Tanggal</label>
                                                        <input type="date" name="tgl_berangkat" value="<?= $row['tgl_berangkat'] ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label>Titik Jemput</label>
                                                        <input type="text" name="titik_jemput" value="<?= $row['titik_jemput'] ?>" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jumlah</label>
                                                        <input type="number" name="jumlah_penumpang" value="<?= $row['jumlah_penumpang'] ?>" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Harga</label>
                                                        <input type="number" step="0.01" name="harga" value="<?= $row['harga'] ?>" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>DP</label>
                                                        <input type="number" step="0.01" name="jumlah_dp" value="<?= $row['jumlah_dp'] ?>" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Status Bayar</label>
                                                        <select name="status_bayar" class="form-control">
                                                            <?php foreach (['Belum Bayar', 'DP', 'Lunas'] as $val): ?>
                                                                <option value="<?= $val ?>" <?= $row['status_bayar'] == $val ? 'selected' : '' ?>><?= $val ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Status Jemput</label>
                                                        <select name="status_jemput" class="form-control">
                                                            <?php foreach (['Menunggu Konfirmasi', 'Sudah Dijemput', 'Batal'] as $val): ?>
                                                                <option value="<?= $val ?>" <?= $row['status_jemput'] == $val ? 'selected' : '' ?>><?= $val ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Catatan</label>
                                                        <textarea name="catatan" class="form-control"><?= $row['catatan'] ?></textarea>
                                                    </div>
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
                                    <form action="proses/hapus_penumpang_travel.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Penumpang</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus data <strong><?= htmlspecialchars($row['nama_penumpang']) ?></strong>?
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
                    <div class="modal fade" id="modalTambahBasic" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="proses/tambah_penumpang_travel.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Penumpang Travel</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label>Rute</label>
                                                <select name="id_rute" class="form-control" required>
                                                    <option value="">-- Pilih Rute --</option>
                                                    <?php
                                                    $rute = mysqli_query($koneksi, "SELECT * FROM data_rute ORDER BY id DESC");
                                                    while ($r = mysqli_fetch_assoc($rute)) {
                                                        echo "<option value='{$r['id']}'>{$r['rute_asal']} → {$r['rute_tujuan']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Nama Penumpang</label>
                                                <input type="text" name="nama_penumpang" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>No HP</label>
                                                <input type="text" name="hp" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Tgl Berangkat</label>
                                                <input type="date" name="tgl_berangkat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label>Titik Jemput</label>
                                                <input type="text" name="titik_jemput" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Jumlah Penumpang</label>
                                                <input type="number" name="jumlah_penumpang" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>Harga</label>
                                                <input type="number" step="0.01" name="harga" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>Status Bayar</label>
                                                <select name="status_bayar" class="form-control" id="statusBayar" onchange="toggleDPInput()" required>
                                                    <option value="Belum Bayar">Belum Bayar</option>
                                                    <option value="DP">DP</option>
                                                    <option value="Lunas">Lunas</option>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="dpInputWrapper" style="display: none;">
                                                <label>Jumlah DP</label>
                                                <input type="number" step="0.01" name="jumlah_dp" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label>Status Jemput</label>
                                                <select name="status_jemput" class="form-control">
                                                    <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                                    <option value="Sudah Dijemput">Sudah Dijemput</option>
                                                    <option value="Batal">Batal</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Catatan</label>
                                                <textarea name="catatan" class="form-control"></textarea>
                                            </div>
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

    <script>
        function toggleDPInput() {
            const status = document.getElementById('statusBayar').value;
            const dpInput = document.getElementById('dpInputWrapper');
            dpInput.style.display = status === 'DP' ? 'block' : 'none';
        }

        // Panggil saat load halaman untuk inisialisasi
        document.addEventListener("DOMContentLoaded", toggleDPInput);
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>