<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $nama     = $_POST['nama'];
        $email    = $_POST['email'];
        $hp       = $_POST['hp'];
        $password = $_POST['password'];
        $status   = $_POST['status'];

        // Validasi email dan hp unik
        $cek = $koneksi->prepare("SELECT id FROM admin WHERE email = ? OR hp = ?");
        $cek->bind_param("ss", $email, $hp);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $_SESSION['error'] = "Email atau No HP sudah digunakan.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $koneksi->prepare("INSERT INTO admin (username, nama, email, hp, password, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $username, $nama, $email, $hp, $hashed_password, $status);
            $stmt->execute();

            $_SESSION['success'] = "Data berhasil ditambahkan.";
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
}

header("Location: ../data-admin.php");
