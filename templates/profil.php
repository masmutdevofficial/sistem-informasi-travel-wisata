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
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Judul Halaman</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Judul Halaman</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Konten Profil -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <?php
          // Simulasi data user
          $user = [
            'nama' => 'Imam Nur Muttaqin',
            'email' => 'imam@example.com',
            'hp' => '081234567890',
            'level' => 'Admin',
            'status' => 'Aktif',
            'alamat' => 'Jl. Raya No. 123, Jakarta',
            'profil' => '../assets/img/avatar.png'
          ];
          ?>

                <div class="text-center mb-3">
                    <img class="profile-user-img img-fluid img-circle" src="<?= $user['profil'] ?>"
                        alt="User profile picture" style="object-fit:cover; height:100px; width:100px;">
                </div>

                <h3 class="profile-username text-center"><?= $user['nama'] ?></h3>
                <p class="text-muted text-center"><?= $user['level'] ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right"><?= $user['email'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <b>No HP</b> <span class="float-right"><?= $user['hp'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> <span class="float-right badge badge-success"><?= $user['status'] ?></span>
                    </li>
                    <li class="list-group-item">
                        <b>Alamat</b> <span class="float-right text-muted"><?= $user['alamat'] ?></span>
                    </li>
                </ul>

                <a href="edit-profil.php" class="btn btn-primary btn-block"><b>Edit Profil</b></a>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/admin_footer.php' ?>