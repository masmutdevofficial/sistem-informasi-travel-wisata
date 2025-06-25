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
                                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalTambahBasic">
                                    <i class="fa fa-plus mr-2"></i>Tambah Carter/Sewa
                                </button>
                                <a class="btn btn-secondary mr-2" href="cetak/cetak-data-carter.php">
                                    <i class="fa fa-print mr-2"></i>Cetak Carter
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <?php
                    $query = mysqli_query($koneksi, "
                        SELECT c.*, k.nomor_polisi, d.nama AS nama_driver 
                        FROM data_penumpang_carter c 
                        JOIN data_kendaraan k ON c.id_kendaraan = k.id 
                        JOIN data_driver d ON c.id_driver = d.id 
                        ORDER BY c.id DESC
                    ");
                    ?>

                    <table id="basicTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Penyewa</th>
                                <th>Driver</th>
                                <th>Kendaraan</th>
                                <th>Tgl Sewa</th>
                                <th>Durasi</th>
                                <th>Tujuan</th>
                                <th>Harga</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
                                <td><?= htmlspecialchars($row['nama_driver']) ?></td>
                                <td><?= htmlspecialchars($row['nomor_polisi']) ?></td>
                                <td><?= $row['tgl_sewa'] ?></td>
                                <td><?= $row['durasi'] ?></td>
                                <td><?= $row['tujuan'] ?></td>
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
                                    <form action="proses/edit_carter.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Carter</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Kendaraan</label>
                                                    <select name="id_kendaraan" class="form-control" required>
                                                        <?php
                                                        $kendaraan = mysqli_query($koneksi, "SELECT * FROM data_kendaraan");
                                                        while ($k = mysqli_fetch_assoc($kendaraan)) {
                                                            $sel = $k['id'] == $row['id_kendaraan'] ? 'selected' : '';
                                                            echo "<option value='{$k['id']}' $sel>{$k['nomor_polisi']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Driver</label>
                                                    <select name="id_driver" class="form-control" required>
                                                        <?php
                                                        $driver = mysqli_query($koneksi, "SELECT * FROM data_driver");
                                                        while ($d = mysqli_fetch_assoc($driver)) {
                                                            $sel = $d['id'] == $row['id_driver'] ? 'selected' : '';
                                                            echo "<option value='{$d['id']}' $sel>{$d['nama']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama Penyewa</label>
                                                    <input type="text" name="nama_penyewa" value="<?= $row['nama_penyewa'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tanggal Sewa</label>
                                                    <input type="date" name="tgl_sewa" value="<?= $row['tgl_sewa'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Durasi</label>
                                                    <input type="text" name="durasi" value="<?= $row['durasi'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tujuan</label>
                                                    <input type="text" name="tujuan" value="<?= $row['tujuan'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Harga</label>
                                                    <input type="number" step="0.01" name="harga" value="<?= $row['harga'] ?>" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Status Bayar</label>
                                                    <select name="status_bayar" class="form-control" onchange="this.form.jumlah_dp.disabled = (this.value !== 'DP')">
                                                        <?php foreach (['Belum Bayar', 'DP', 'Lunas'] as $s): ?>
                                                            <option value="<?= $s ?>" <?= $row['status_bayar'] == $s ? 'selected' : '' ?>><?= $s ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Jumlah DP</label>
                                                    <input type="number" step="0.01" name="jumlah_dp" value="<?= $row['jumlah_dp'] ?>" class="form-control" <?= $row['status_bayar'] == 'DP' ? '' : 'disabled' ?>>
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
                                    <form action="proses/hapus_carter.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Data Carter</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Yakin ingin menghapus data carter untuk <strong><?= htmlspecialchars($row['nama_penyewa']) ?></strong>?
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
                    <div class="modal fade" id="modalTambahBasic" tabindex="-1" aria-labelledby="modalTambahCarterLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="proses/tambah_carter.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Carter</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Kendaraan</label>
                                            <select name="id_kendaraan" class="form-control" required>
                                                <option value="">-- Pilih Kendaraan --</option>
                                                <?php
                                                $kendaraan = mysqli_query($koneksi, "SELECT * FROM data_kendaraan");
                                                while ($k = mysqli_fetch_assoc($kendaraan)) {
                                                    echo "<option value='{$k['id']}'>{$k['nomor_polisi']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Driver</label>
                                            <select name="id_driver" class="form-control" required>
                                                <option value="">-- Pilih Driver --</option>
                                                <?php
                                                $driver = mysqli_query($koneksi, "SELECT * FROM data_driver");
                                                while ($d = mysqli_fetch_assoc($driver)) {
                                                    echo "<option value='{$d['id']}'>{$d['nama']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Nama Penyewa</label>
                                            <input type="text" name="nama_penyewa" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tanggal Sewa</label>
                                            <input type="date" name="tgl_sewa" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Durasi</label>
                                            <input type="text" name="durasi" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Tujuan</label>
                                            <input type="text" name="tujuan" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Harga</label>
                                            <input type="number" step="0.01" name="harga" class="form-control" required>
                                        </div>
                                        <div class="mb-3" id="dpInputCarter" style="display: none;">
                                            <label>Jumlah DP</label>
                                            <input type="number" step="0.01" name="jumlah_dp" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Status Bayar</label>
                                            <select name="status_bayar" class="form-control" id="statusBayarCarter" onchange="toggleDPCarter()" required>
                                                <option value="Belum Bayar">Belum Bayar</option>
                                                <option value="DP">DP</option>
                                                <option value="Lunas">Lunas</option>
                                            </select>
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