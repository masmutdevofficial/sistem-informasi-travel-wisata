<?php
session_start();
require '../../config/koneksi.php';

try {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $hp       = trim($_POST['hp']);
    $password = $_POST['password'];
    $status   = $_POST['status'];

    // Validasi wajib isi
    if (empty($username) || empty($nama) || empty($email) || empty($hp) || empty($password)) {
        throw new Exception("Semua field wajib diisi.");
    }

    // Cek username/email/hp duplikat
    $stmt = $koneksi->prepare("SELECT * FROM admin WHERE username = ? OR email = ? OR hp = ?");
    $stmt->bind_param("sss", $username, $email, $hp);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        throw new Exception("Username, Email, atau No HP sudah digunakan.");
    }

    // Simpan data
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO admin (username, nama, email, hp, password, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssssi", $username, $nama, $email, $hp, $hashed, $status);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menyimpan data: " . $stmt->error);
    }

    $_SESSION['success'] = "Data admin berhasil ditambahkan.";
    header("Location: ../kelola-admin.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-admin.php");
}
