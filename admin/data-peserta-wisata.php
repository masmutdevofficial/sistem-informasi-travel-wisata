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
                <h1>Data Peserta Wisata</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Data Peserta Wisata</li>
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
                            <h3 class="card-title">Data Peserta Wisata</h3>
                            <div class="d-flex flex-row justify-content-center align-items-center">
                                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalTambahBasic">
                                    <i class="fa fa-plus mr-2"></i>Tambah Peserta Wisata
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <?php
                    $query = mysqli_query($koneksi, "
                        SELECT p.*, d.nama_wisata 
                        FROM data_peserta_wisata p 
                        JOIN data_paket_wisata d ON d.id = p.id_data_paket_wisata 
                        ORDER BY p.id DESC
                    ");
                    ?>

                    <table id="basicTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Paket Wisata</th>
                                <th>Tgl Berangkat</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_peserta']) ?></td>
                                <td><?= htmlspecialchars($row['nama_wisata']) ?></td>
                                <td><?= $row['tgl_keberangkatan'] ?></td>
                                <td><?= $row['jumlah_orang'] ?></td>
                                <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><span class="badge badge-info"><?= $row['status_bayar'] ?></span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus<?= $row['id'] ?>"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="proses/edit_peserta_wisata.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Peserta Wisata</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Paket Wisata</label>
                                                    <select name="id_data_paket_wisata" class="form-control" required>
                                                        <?php
                                                        $paket = mysqli_query($koneksi, "SELECT * FROM data_paket_wisata");
                                                        while ($p = mysqli_fetch_assoc($paket)) {
                                                            $selected = $p['id'] == $row['id_data_paket_wisata'] ? 'selected' : '';
                                                            echo "<option value='{$p['id']}' $selected>{$p['nama_wisata']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama Peserta</label>
                                                    <input type="text" name="nama_peserta" value="<?= $row['nama_peserta'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tanggal Keberangkatan</label>
                                                    <input type="date" name="tgl_keberangkatan" value="<?= $row['tgl_keberangkatan'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Jumlah Orang</label>
                                                    <input type="number" name="jumlah_orang" value="<?= $row['jumlah_orang'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Harga</label>
                                                    <input type="number" step="0.01" name="harga" value="<?= $row['harga'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Status Bayar</label>
                                                    <select name="status_bayar" class="form-control" onchange="this.form.jumlah_dp.disabled = (this.value !== 'DP')">
                                                        <?php foreach (['Belum Bayar', 'DP', 'Lunas'] as $status): ?>
                                                            <option value="<?= $status ?>" <?= $row['status_bayar'] == $status ? 'selected' : '' ?>><?= $status ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Jumlah DP</label>
                                                    <input type="number" step="0.01" name="jumlah_dp" value="<?= $row['jumlah_dp'] ?>" class="form-control" <?= $row['status_bayar'] == 'DP' ? '' : 'disabled' ?>>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Catatan</label>
                                                    <textarea name="catatan" class="form-control"><?= $row['catatan'] ?></textarea>
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
                                    <form action="proses/hapus_peserta_wisata.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Peserta</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus peserta <strong><?= htmlspecialchars($row['nama_peserta']) ?></strong>?
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
                    <div class="modal fade" id="modalTambahBasic" tabindex="-1" aria-labelledby="modalTambahPesertaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="proses/tambah_peserta_wisata.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Peserta Wisata</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Paket Wisata</label>
                                            <select name="id_data_paket_wisata" class="form-control" required>
                                                <option value="">-- Pilih Paket --</option>
                                                <?php
                                                $paket = mysqli_query($koneksi, "SELECT * FROM data_paket_wisata ORDER BY id DESC");
                                                while ($p = mysqli_fetch_assoc($paket)) {
                                                    echo "<option value='{$p['id']}'>{$p['nama_wisata']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Peserta</label>
                                            <input type="text" name="nama_peserta" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tanggal Keberangkatan</label>
                                            <input type="date" name="tgl_keberangkatan" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Jumlah Orang</label>
                                            <input type="number" name="jumlah_orang" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Harga</label>
                                            <input type="number" step="0.01" name="harga" class="form-control" required>
                                        </div>
                                        <div class="mb-3" id="dpInputWrapper" style="display: none;">
                                            <label>Jumlah DP</label>
                                            <input type="number" step="0.01" name="jumlah_dp" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status Bayar</label>
                                            <select name="status_bayar" class="form-control" id="statusBayar" onchange="toggleDPInput()" required>
                                                <option value="Belum Bayar">Belum Bayar</option>
                                                <option value="DP">DP</option>
                                                <option value="Lunas">Lunas</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Catatan</label>
                                            <textarea name="catatan" class="form-control"></textarea>
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
        document.addEventListener("DOMContentLoaded", toggleDPInput);
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>