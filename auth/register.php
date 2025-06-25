<?php
require_once '../config/koneksi.php';
require_once '../config/auth.php';

if (is_logged_in()) {
    header('Location: ../admin/dashboard.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $hp = sanitize($_POST['hp']);
    $alamat = sanitize($_POST['alamat']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        $errors[] = 'Konfirmasi password tidak cocok';
    }

    if (!is_email($email)) {
        $errors[] = 'Email tidak valid';
    }

    $stmt = $koneksi->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = 'Email sudah terdaftar';
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $koneksi->prepare('INSERT INTO users (nama, email, hp, password, alamat, level, status) VALUES (?, ?, ?, ?, ?, 1, 1)');
        $stmt->bind_param('sssss', $nama, $email, $hp, $hash, $alamat);
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Pendaftaran berhasil, silahkan login.';
            header('Location: login.php');
            exit;
        } else {
            $errors[] = 'Gagal mendaftarkan user';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Admin</b>LTE</a>
  </div>
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>
      <?php if ($errors): ?>
        <div class="alert alert-danger">
        <?php foreach ($errors as $e): ?>
          <div><?= $e ?></div>
        <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nama" name="nama" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="No HP" name="hp" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-phone"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-map"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="password2" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-8"></div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>
      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
  </div>
</div>
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/adminlte.min.js"></script>
</body>
</html>
