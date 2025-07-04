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
                <h1>Data Pemesanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Data Pemesanan</li>
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
                        <h3 class="card-title mb-0">Data Pemesanan</h3>
                        <div class="ml-auto">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="basicTable" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pesanan</th> <!-- Gabungan kendaraan, driver, pelanggan -->
                                    <th>Waktu</th>   <!-- Gabungan waktu berangkat dan pulang -->
                                    <th>Rincian</th> <!-- Gabungan titik jemput, penumpang, barang -->
                                    <th>Bayar</th>   <!-- Gabungan harga, DP, pelunasan -->
                                    <th>Status</th>  <!-- Jenis pemesanan, status bayar, jemput -->
                                    <th>Pengeluaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = $koneksi->query("
                                    SELECT 
                                        dp.*,
                                        dk.nama_kendaraan,
                                        dk.nomor_polisi,
                                        dd.nama AS nama_driver,
                                        pl.nama_penumpang
                                    FROM data_pesanan dp
                                    JOIN data_kendaraan dk ON dk.id = dp.id_kendaraan
                                    JOIN data_driver dd ON dd.id = dp.id_driver
                                    JOIN data_pelanggan pl ON pl.id = dp.id_data_pelanggan
                                    ORDER BY dp.created_at DESC
                                ");
                                $all_kendaraan = $koneksi->query("SELECT id, nama_kendaraan, nomor_polisi FROM data_kendaraan");
                                $all_driver = $koneksi->query("SELECT id, nama FROM data_driver");
                                $all_pelanggan = $koneksi->query("SELECT id, nama_penumpang FROM data_pelanggan");

                                $kendaraan_list = $all_kendaraan->fetch_all(MYSQLI_ASSOC);
                                $driver_list = $all_driver->fetch_all(MYSQLI_ASSOC);
                                $pelanggan_list = $all_pelanggan->fetch_all(MYSQLI_ASSOC);

                                $pengeluaran_query = $koneksi->query("SELECT id_data_pesanan, keterangan, jumlah_pengeluaran FROM pengeluaran");
                                $pengeluaran_data = [];
                                while ($p = $pengeluaran_query->fetch_assoc()) {
                                    $pengeluaran_data[$p['id_data_pesanan']][] = $p;
                                }
                                
                                while ($row = $query->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>

                                    <!-- Pesanan -->
                                    <td>
                                        <b>Kendaraan:</b> <?= htmlspecialchars($row['nama_kendaraan']) ?> (<?= htmlspecialchars($row['nomor_polisi']) ?>)<br>
                                        <b>Driver:</b> <?= htmlspecialchars($row['nama_driver']) ?><br>
                                        <b>Pelanggan:</b> <?= htmlspecialchars($row['nama_penumpang']) ?>
                                    </td>

                                    <!-- Waktu -->
                                    <td>
                                        <b>Berangkat:</b><br><?= date('d M Y H:i', strtotime($row['waktu_berangkat'])) ?><br>
                                        <b>Pulang:</b><br><?= date('d M Y H:i', strtotime($row['waktu_pulang'])) ?>
                                    </td>

                                    <!-- Rincian -->
                                    <td>
                                        <b>Titik Jemput:</b> <?= !empty($row['titik_jemput']) ? htmlspecialchars($row['titik_jemput']) : '-' ?><br>
                                        <b>Penumpang:</b> <?= $row['jumlah_penumpang'] ?><br>
                                        <b>Barang:</b> <?= $row['jumlah_barang'] ?>
                                    </td>

                                    <!-- Bayar -->
                                    <td>
                                        <b>Harga:</b> Rp<?= number_format($row['harga'], 0, ',', '.') ?><br>
                                        <b>DP:</b> Rp<?= number_format($row['jumlah_dp'], 0, ',', '.') ?><br>
                                        <b>Pelunasan:</b> Rp<?= number_format($row['tambahan_dp'], 0, ',', '.') ?>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <b>Pemesanan:</b> <?= htmlspecialchars($row['jenis_pemesanan']) ?><br>
                                        <b>Bayar:</b> <?= htmlspecialchars($row['status_bayar']) ?><br>
                                        <b>Jemput:</b> <?= htmlspecialchars($row['status_jemput']) ?>
                                    </td>

                                    <td>
                                        <strong>Pengeluaran:</strong>
                                        <?php if (!empty($pengeluaran_data[$row['id']])): ?>
                                            <ul class="mb-0">
                                                <?php foreach ($pengeluaran_data[$row['id']] as $peng): ?>
                                                    <li><?= htmlspecialchars($peng['keterangan']) ?> - Rp<?= number_format($peng['jumlah_pengeluaran'], 0, ',', '.') ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="text-muted mb-0">Belum Ada Data Pengeluaran</p>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Aksi -->
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <a href="#" class="btn btn-warning btn-sm mb-1" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#modalHapus<?= $row['id'] ?>">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                            <a href="invoice-pesanan.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm mb-1">
                                                <i class="fa fa-receipt"></i> Invoice
                                            </a>
                                            <a href="data-pengeluaran.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-plus"></i> Tambah Pengeluaran
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <form action="proses/edit_data_pesanan.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data Pesanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- Kendaraan -->
                                                        <div class="form-group col-md-6">
                                                            <label>Kendaraan</label>
                                                            <select name="id_kendaraan" class="form-control" required>
                                                                <?php foreach ($kendaraan_list as $k): ?>
                                                                    <option value="<?= $k['id'] ?>" <?= $k['id'] == $row['id_kendaraan'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($k['nama_kendaraan']) ?> (<?= htmlspecialchars($k['nomor_polisi']) ?>)
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Driver -->
                                                        <div class="form-group col-md-6">
                                                            <label>Driver</label>
                                                            <select name="id_driver" class="form-control" required>
                                                                <?php foreach ($driver_list as $d): ?>
                                                                    <option value="<?= $d['id'] ?>" <?= $d['id'] == $row['id_driver'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($d['nama']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Pelanggan -->
                                                        <div class="form-group col-md-12">
                                                            <label>Pelanggan</label>
                                                            <select name="id_data_pelanggan" class="form-control" required>
                                                                <?php foreach ($pelanggan_list as $p): ?>
                                                                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $row['id_data_pelanggan'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($p['nama_penumpang']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Jenis Pemesanan -->
                                                        <div class="form-group col-md-12">
                                                            <label>Jenis Pemesanan</label>
                                                            <select name="jenis_pemesanan" class="form-control jenis-pemesanan-edit" required onchange="toggleJenisPemesananEdit(this, <?= $row['id'] ?>)">
                                                                <option value="Travel" <?= $row['jenis_pemesanan'] == 'Travel' ? 'selected' : '' ?>>Travel</option>
                                                                <option value="Sewa/Carter" <?= $row['jenis_pemesanan'] == 'Sewa/Carter' ? 'selected' : '' ?>>Sewa/Carter</option>
                                                                <option value="Paket Wisata" <?= $row['jenis_pemesanan'] == 'Paket Wisata' ? 'selected' : '' ?>>Paket Wisata</option>
                                                            </select>
                                                        </div>

                                                        <!-- Waktu -->
                                                        <div class="form-group col-md-6">
                                                            <label>Waktu Berangkat</label>
                                                            <input type="datetime-local" name="waktu_berangkat" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($row['waktu_berangkat'])) ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Waktu Pulang</label>
                                                            <input type="datetime-local" name="waktu_pulang" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($row['waktu_pulang'])) ?>" required>
                                                        </div>

                                                        <!-- Optional Fields -->
                                                        <div class="form-group col-md-6 field-edit-titik_jemput-<?= $row['id'] ?>">
                                                            <label>Titik Jemput</label>
                                                            <input type="text" name="titik_jemput" class="form-control" value="<?= htmlspecialchars($row['titik_jemput']) ?>">
                                                        </div>
                                                        <div class="form-group col-md-6 field-edit-jumlah_penumpang-<?= $row['id'] ?>">
                                                            <label>Jumlah Penumpang</label>
                                                            <input type="number" name="jumlah_penumpang" class="form-control" value="<?= $row['jumlah_penumpang'] ?>">
                                                        </div>
                                                        <div class="form-group col-md-6 field-edit-jumlah_barang-<?= $row['id'] ?>">
                                                            <label>Jumlah Barang</label>
                                                            <input type="number" name="jumlah_barang" class="form-control" value="<?= $row['jumlah_barang'] ?>">
                                                        </div>

                                                        <!-- Harga -->
                                                        <div class="form-group col-md-6">
                                                            <label>Harga</label>
                                                            <input type="number" step="0.01" name="harga" class="form-control" value="<?= $row['harga'] ?>" required>
                                                        </div>

                                                        <!-- Status Bayar -->
                                                        <div class="form-group col-md-12">
                                                            <label>Status Bayar</label>
                                                            <select name="status_bayar" class="form-control status-bayar-edit" required onchange="toggleBayarFieldEdit(this, <?= $row['id'] ?>)">
                                                                <option value="Lunas" <?= $row['status_bayar'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                                                <option value="DP" <?= $row['status_bayar'] == 'DP' ? 'selected' : '' ?>>DP</option>
                                                                <option value="Belum Bayar" <?= $row['status_bayar'] == 'Belum Bayar' ? 'selected' : '' ?>>Belum Bayar</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 field-edit-jumlah_dp-<?= $row['id'] ?>">
                                                            <label>Jumlah DP</label>
                                                            <input type="number" step="0.01" name="jumlah_dp" class="form-control" value="<?= $row['jumlah_dp'] ?>">
                                                        </div>
                                                        <div class="form-group col-md-6 field-edit-pelunasan-<?= $row['id'] ?>">
                                                            <label>Jumlah Pelunasan</label>
                                                            <input type="number" step="0.01" name="tambahan_dp" class="form-control" value="<?= $row['tambahan_dp'] ?>">
                                                        </div>

                                                        <!-- Catatan -->
                                                        <div class="form-group col-md-12">
                                                            <label>Catatan</label>
                                                            <textarea name="catatan" class="form-control"><?= htmlspecialchars($row['catatan']) ?></textarea>
                                                        </div>

                                                        <!-- Status Jemput -->
                                                        <div class="form-group col-md-6 field-edit-status_jemput-<?= $row['id'] ?>">
                                                            <label>Status Jemput</label>
                                                            <select name="status_jemput" class="form-control">
                                                                <option value="Menunggu Konfirmasi" <?= $row['status_jemput'] == 'Menunggu Konfirmasi' ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                                                                <option value="Sudah Dijemput" <?= $row['status_jemput'] == 'Sudah Dijemput' ? 'selected' : '' ?>>Sudah Dijemput</option>
                                                                <option value="Batal" <?= $row['status_jemput'] == 'Batal' ? 'selected' : '' ?>>Batal</option>
                                                            </select>
                                                        </div>
                                                    </div> <!-- /.row -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="proses/hapus_data_pesanan.php" method="GET">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus pesanan ini?</p>
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
                </div>

            </div>
        </div>
    </div>
</section>

<?php
$kendaraan = $koneksi->query("SELECT id, nama_kendaraan, nomor_polisi FROM data_kendaraan WHERE status = 'Aktif'");
$driver = $koneksi->query("SELECT id, nama FROM data_driver");
$pelanggan = $koneksi->query("SELECT id, nama_penumpang FROM data_pelanggan");
?>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="proses/tambah_data_pesanan.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Kendaraan</label>
                            <select name="id_kendaraan" class="form-control" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                <?php while ($k = $kendaraan->fetch_assoc()): ?>
                                    <option value="<?= $k['id'] ?>">
                                        <?= htmlspecialchars($k['nama_kendaraan']) ?> (<?= htmlspecialchars($k['nomor_polisi']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Driver</label>
                            <select name="id_driver" class="form-control" required>
                                <option value="">-- Pilih Driver --</option>
                                <?php while ($d = $driver->fetch_assoc()): ?>
                                    <option value="<?= $d['id'] ?>">
                                        <?= htmlspecialchars($d['nama']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Pelanggan</label>
                            <select name="id_data_pelanggan" class="form-control" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php while ($p = $pelanggan->fetch_assoc()): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['nama_penumpang']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>Jenis Pemesanan</label>
                            <select name="jenis_pemesanan" id="jenis_pemesanan" class="form-control" required onchange="toggleJenisPemesanan()">
                                <option value="" selected>-- Pilih Pemesanan --</option>
                                <option value="Travel">Travel</option>
                                <option value="Sewa/Carter">Sewa/Carter</option>
                                <option value="Paket Wisata">Paket Wisata</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Waktu Berangkat</label>
                            <input type="datetime-local" name="waktu_berangkat" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Waktu Pulang</label>
                            <input type="datetime-local" name="waktu_pulang" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6" id="field_titik_jemput">
                            <label>Titik Jemput</label>
                            <input type="text" name="titik_jemput" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6" id="field_jumlah_penumpang">
                            <label>Jumlah Penumpang</label>
                            <input type="number" name="jumlah_penumpang" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6" id="field_jumlah_barang">
                            <label>Jumlah Barang</label>
                            <input type="number" name="jumlah_barang" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Harga Jasa</label>
                            <input type="number" step="0.01" name="harga" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label>Status Bayar</label>
                            <select name="status_bayar" id="status_bayar" class="form-control" required onchange="toggleBayarFields()">
                                <option value="">-- Pilih Status --</option>
                                <option value="Lunas">Lunas</option>
                                <option value="DP">DP</option>
                                <option value="Belum Bayar">Belum Bayar</option>
                            </select>
                        </div>
                        <div class="form-group col-12" id="field_jumlah_dp" style="display: none;">
                            <label>Jumlah DP</label>
                            <input type="number" step="0.01" name="jumlah_dp" class="form-control">
                        </div>
                        <div class="form-group col-12" id="field_pelunasan" style="display: none;">
                            <label>Jumlah Pelunasan</label>
                            <input type="number" step="0.01" name="tambahan_dp" class="form-control">
                        </div>
                        <div class="form-group col-12">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-12" id="field_status_jemput">
                            <label>Status Jemput</label>
                            <select name="status_jemput" class="form-control" required>
                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                <option value="Sudah Dijemput">Sudah Dijemput</option>
                                <option value="Batal">Batal</option>
                            </select>
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
<?php
    $bodyJs = <<<'EOD'
    <script>
    $(function () {
        $("#basicTable").DataTable({
            scrollX: true, // Aktifkan scroll horizontal
            responsive: false, // Matikan responsive bawaan agar scrollX bekerja
            lengthChange: true,
            autoWidth: false,
            lengthMenu: [ [5, 10, 25, 50, 100], [5, 10, 25, 50, 100] ]
        });
    });
    </script>

    <script>
    function toggleBayarFields() {
        const statusBayar = document.getElementById('status_bayar').value;
        const dpField = document.getElementById('field_jumlah_dp');
        const pelunasanField = document.getElementById('field_pelunasan');

        dpField.style.display = 'none';
        pelunasanField.style.display = 'none';
        dpField.querySelector('input').required = false;
        pelunasanField.querySelector('input').required = false;

        if (statusBayar === 'DP') {
            dpField.style.display = 'block';
            dpField.querySelector('input').required = true;
        } else if (statusBayar === 'Lunas') {
            pelunasanField.style.display = 'block';
            pelunasanField.querySelector('input').required = true;
        }
    }

    function toggleJenisPemesanan() {
        const jenis = document.getElementById('jenis_pemesanan').value;

        const fieldTitikJemput = document.getElementById('field_titik_jemput');
        const fieldJumlahPenumpang = document.getElementById('field_jumlah_penumpang');
        const fieldJumlahBarang = document.getElementById('field_jumlah_barang');
        const fieldStatusJemput = document.getElementById('field_status_jemput');

        const inputs = [
            fieldTitikJemput.querySelector('input'),
            fieldJumlahPenumpang.querySelector('input'),
            fieldJumlahBarang.querySelector('input'),
            fieldStatusJemput.querySelector('select')
        ];

        if (jenis === 'Travel') {
            fieldTitikJemput.style.display = 'none';
            fieldJumlahPenumpang.style.display = 'none';
            fieldJumlahBarang.style.display = 'none';
            fieldStatusJemput.style.display = 'none';

            inputs.forEach(el => el.required = false);
        } else {
            fieldTitikJemput.style.display = 'block';
            fieldJumlahPenumpang.style.display = 'block';
            fieldJumlahBarang.style.display = 'block';
            fieldStatusJemput.style.display = 'block';

            inputs.forEach(el => el.required = true);
        }
    }
    </script>
    <script>
    function toggleBayarFieldEdit(select, id) {
        const val = select.value;
        document.querySelector('.field-edit-jumlah_dp-' + id).style.display = (val === 'DP') ? 'block' : 'none';
        document.querySelector('.field-edit-pelunasan-' + id).style.display = (val === 'Lunas') ? 'block' : 'none';
    }

    function toggleJenisPemesananEdit(select, id) {
        const val = select.value;
        const fields = ['titik_jemput', 'jumlah_penumpang', 'jumlah_barang', 'status_jemput'];
        fields.forEach(field => {
            const el = document.querySelector('.field-edit-' + field + '-' + id);
            if (el) el.style.display = (val === 'Travel') ? 'none' : 'block';
        });
    }

    // Optional: Auto apply after modal open
    $('.modal').on('shown.bs.modal', function () {
        const id = $(this).attr('id').replace('modalEdit', '');
        toggleBayarFieldEdit($(this).find('.status-bayar-edit')[0], id);
        toggleJenisPemesananEdit($(this).find('.jenis-pemesanan-edit')[0], id);
    });
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>