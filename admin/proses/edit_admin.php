<?php
session_start();
require '../../config/koneksi.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id       = $_POST['id'];
        $username = $_POST['username'];
        $nama     = $_POST['nama'];
        $email    = $_POST['email'];
        $hp       = $_POST['hp'];
        $status   = $_POST['status'];
        $password = $_POST['password'];

        // Ambil password lama dari DB
        $stmt = $koneksi->prepare("SELECT password FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($password_lama);
        $stmt->fetch();
        $stmt->close();

        // Cek apakah field password dikosongkan atau diisi
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $hashed_password = $password_lama; // gunakan password sebelumnya
        }

        // Update data admin
        $stmt = $koneksi->prepare("UPDATE admin SET username = ?, nama = ?, email = ?, hp = ?, password = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $username, $nama, $email, $hp, $hashed_password, $status, $id);
        $stmt->execute();

        $_SESSION['success'] = "Data berhasil diupdate.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Gagal mengupdate data: " . $e->getMessage();
}

header("Location: ../data-admin.php");
