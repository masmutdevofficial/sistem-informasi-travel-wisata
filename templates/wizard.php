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
                            <h3 class="card-title">Forms Wizard</h3>
                            <button type="button" class="btn btn-danger" onclick="location.reload();">
                                <i class="fa fa-history mr-2"></i>Reset Data
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Wizard Navigation -->
                        <div class="step-wizard">
                            <div class="step" id="step-1" onclick="goToStep(1)">
                                <div class="circle done"><i class="fa fa-check"></i></div>
                                <div class="label">Overview</div>
                            </div>
                            <div class="line"></div>
                            <div class="step" id="step-2" onclick="goToStep(2)">
                                <div class="circle active"><i class="fa fa-pen"></i></div>
                                <div class="label">Pricing</div>
                            </div>
                            <div class="line"></div>
                            <div class="step" id="step-3" onclick="goToStep(3)">
                                <div class="circle">3</div>
                                <div class="label">Gallery</div>
                            </div>
                        </div>

                        <!-- Wizard Form (seperti sebelumnya, tapi sedikit ubah nama fungsi) -->
                        <form id="wizardForm" novalidate>
                            <div class="wizard-step" id="step1">
                                <div class="text-center mb-4">
                                    <h5 class="font-weight-bold">Step 1: Data Pribadi</h5>
                                    <small class="text-muted d-block">Isi informasi pribadi kamu dengan benar</small>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama" required>
                                    <div class="invalid-feedback">Nama wajib diisi</div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="contoh@email.com" required>
                                    <div class="invalid-feedback">Email wajib diisi</div>
                                </div>
                                <button type="button" class="btn btn-primary float-right" onclick="goToStep(2)">Lanjut</button>
                            </div>

                            <div class="wizard-step d-none" id="step2">
                                <div class="text-center mb-4">
                                    <h5 class="font-weight-bold">Step 2: Info Tambahan</h5>
                                    <small class="text-muted d-block">Isi informasi pribadi kamu dengan benar</small>
                                </div>
                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" class="form-control" name="telepon" placeholder="08xxxxxxxxxx" required>
                                    <div class="invalid-feedback">No. HP wajib diisi</div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" placeholder="Masukkan alamat" required></textarea>
                                    <div class="invalid-feedback">Alamat wajib diisi</div>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="goToStep(1)">Kembali</button>
                                <button type="button" class="btn btn-primary float-right" onclick="goToStep(3)">Lanjut</button>
                            </div>

                            <div class="wizard-step d-none" id="step3">
                                <div class="text-center mb-4">
                                    <h5 class="font-weight-bold">Step 3: Konfirmasi</h5>
                                    <small class="text-muted d-block">Isi informasi pribadi kamu dengan benar</small>
                                </div>
                                <p>Pastikan data sudah benar lalu submit form.</p>
                                <button type="button" class="btn btn-secondary" onclick="goToStep(2)">Kembali</button>
                                <button type="submit" class="btn btn-success float-right">Submit</button>
                            </div>
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
        function updateWizardUI(currentStep) {
            const steps = [1, 2, 3];
            steps.forEach(step => {
                const el = document.querySelector('#step-' + step + ' .circle');
                el.classList.remove('done', 'active');
                if (step < currentStep) {
                    el.classList.add('done');
                    el.innerHTML = '<i class="fa fa-check"></i>';
                } else if (step === currentStep) {
                    el.classList.add('active');
                    el.innerHTML = '<i class="fa fa-pen"></i>';
                } else {
                    el.textContent = step;
                }
            });
        }

        // Panggil ini setiap kali ganti step
        function goToStep(step) {
            updateWizardUI(step);
            document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('d-none'));
            document.getElementById('step' + step).classList.remove('d-none');
        }

        function validateStep(stepElement) {
            const inputs = stepElement.querySelectorAll('input, textarea');
            let valid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            return valid;
        }

        // Final validation saat submit
        document.getElementById('wizardForm').addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                validateStep(this.querySelector('.wizard-step:not(.d-none)'));
            }
            this.classList.add('was-validated');
        });
    </script>
    EOD;
    ?>

<?php include '../includes/admin_footer.php' ?>