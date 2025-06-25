<?php
$title = 'CRUD ADMIN';

$customCss = '
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
';

$customJs = '
    <!-- Forms -->
    <script src="../assets/plugins/select2/js/select2.min.js"></script>
';
?>

<?php include '../includes/admin_header.php' ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tables</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tables</li>
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
                            <h3 class="card-title">Forms</h3>
                            <button type="button" class="btn btn-danger" onclick="location.reload();">
                                <i class="fa fa-history mr-2"></i>Reset Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="proses.php" method="POST" enctype="multipart/form-data" novalidate>
                            <div class="form-group">
                                <label for="referral" title="Kode referral unik untuk user">Kode Referral</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="referral" name="referral" placeholder="Kode referral otomatis" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" onclick="generateReferral()">Generate</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama" title="Isi nama lengkap pengguna">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                                <div class="invalid-feedback">Nama wajib diisi</div>
                            </div>
                            <div class="form-group">
                                <label for="email" title="Masukkan email aktif">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com" required>
                                <div class="invalid-feedback">Email wajib diisi</div>
                            </div>
                            <div class="form-group">
                                <label for="password" title="Gunakan minimal 6 karakter">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="********" required minlength="6">
                                <div class="invalid-feedback">Password minimal 6 karakter</div>
                            </div>
                            <div class="form-group">
                                <label for="telepon" title="Isi nomor telepon aktif">No. Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="form-group">
                                <label for="alamat" title="Alamat lengkap">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Contoh: Jl. Mawar No. 123"></textarea>
                            </div>
                            <div class="form-group">
                                <label title="Pilih jenis kelamin">Jenis Kelamin</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="laki" value="Laki-laki" required>
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="perempuan" value="Perempuan">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                                <div class="invalid-feedback d-block">Pilih salah satu</div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir" title="Tanggal lahir sesuai KTP">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                            </div>
                            <div class="form-group">
                                <label for="waktu_mulai" title="Jam mulai aktivitas">Waktu Mulai</label>
                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai">
                            </div>
                            <div class="form-group">
                                <label for="jadwal" title="Tanggal dan waktu kegiatan">Tanggal & Waktu Jadwal</label>
                                <input type="datetime-local" class="form-control" id="jadwal" name="jadwal">
                            </div>
                            <div class="form-group">
                                <label for="status" title="Pilih status aktif atau tidak">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img id="preview" src="#" alt="Preview" class="img-thumbnail mb-2" style="max-width: 250px; display: none;">
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewGambar(event)">
                                    <label class="custom-file-label" for="foto" title="Upload foto profil">Upload Foto</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kategori" title="Pilih salah satu kategori">Kategori</label>
                                <select class="form-control select2" id="kategori" name="kategori" style="width: 100%;" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="A">Kategori A</option>
                                    <option value="B">Kategori B</option>
                                    <option value="C">Kategori C</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tags" title="Pilih satu atau lebih tag">Tags</label>
                                <select class="form-control select2" id="tags" name="tags[]" multiple="multiple" style="width: 100%;">
                                    <option value="php">PHP</option>
                                    <option value="javascript">JavaScript</option>
                                    <option value="html">HTML</option>
                                    <option value="css">CSS</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label title="Geser untuk mengaktifkan">Status Toggle</label><br>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="toggleAktif" name="toggleAktif">
                                    <label class="custom-control-label" for="toggleAktif" id="toggleLabel">Tidak Aktif</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
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
        function previewGambar(event) {
            const reader = new FileReader();
            const fileInput = document.getElementById('foto');
            const label = document.querySelector('.custom-file-label');
            reader.onload = function() {
                const img = document.getElementById('preview');
                img.src = reader.result;
                img.style.display = 'block';
            };
            label.textContent = fileInput.files[0].name;
            reader.readAsDataURL(fileInput.files[0]);
        }

        document.getElementById('toggleAktif').addEventListener('change', function() {
            document.getElementById('toggleLabel').textContent = this.checked ? 'Aktif' : 'Tidak Aktif';
        });

        function generateReferral() {
            const kode = 'REF' + Math.random().toString(36).substring(2, 8).toUpperCase();
            document.getElementById('referral').value = kode;
        }

        // Generate saat page pertama kali load
        window.addEventListener('DOMContentLoaded', generateReferral);

        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
                placeholder: '-- Pilih --',
                language: {
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // Set placeholder khusus di input pencarian
            $('.select2').on('select2:open', function (e) {
                const isMultiple = $(this).prop('multiple');
                if (!isMultiple) {
                    setTimeout(() => {
                        document.querySelector('.select2-container--open .select2-search__field').placeholder = 'Cari...';
                    }, 0);
                }
            });
        });

        // Validasi Bootstrap 4
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                const forms = document.getElementsByTagName('form');
                Array.prototype.forEach.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>