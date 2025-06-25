<?php
$title = 'CRUD ADMIN';

$customCss = '

';

$customJs = '

';
?>

<?php include '../includes/admin_header.php' ?>

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">

    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="error-page text-center">
        <h2 class="headline text-warning">404</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning mr-2"></i> Oops! Halaman tidak ditemukan.</h3>
            <p>
                Kami tidak dapat menemukan halaman yang Anda cari.<br>
                Anda bisa <a href="dashboard.php">kembali ke dashboard</a> atau menggunakan navigasi lainnya.
            </p>
        </div>
    </div>
</section>

<?php include '../layouts/admin_footer.php' ?>