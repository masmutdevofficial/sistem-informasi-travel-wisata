<?php
session_start();
require '../../config/koneksi.php';

try {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $hp = $_POST['hp'];
    $status = $_POST['status'];
    $password = $_POST['password'];

    // Validasi wajib isi
    if (empty($id) || empty($nama) || empty($email) || empty($hp)) {
        throw new Exception("Semua field wajib diisi.");
    }

    // Update dengan atau tanpa password
    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE admin SET nama=?, email=?, hp=?, status=?, password=? WHERE id=?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sssisi", $nama, $email, $hp, $status, $hashed, $id);
    } else {
        $query = "UPDATE admin SET nama=?, email=?, hp=?, status=? WHERE id=?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sssii", $nama, $email, $hp, $status, $id);
    }

    if (!$stmt->execute()) {
        throw new Exception("Gagal mengupdate data: " . $stmt->error);
    }

    $_SESSION['success'] = "Data admin berhasil diperbarui.";
    header("Location: ../kelola-admin.php");
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../kelola-admin.php");
}
