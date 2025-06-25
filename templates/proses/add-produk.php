<?php
include '../../config/koneksi.php';

$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$deskripsi = $_POST['deskripsi'];
$kategori = 'Umum'; // default, karena nggak ada input kategori
$slug = strtolower(str_replace(' ', '-', $nama_produk));

// upload thumbnail
$thumbnail = '';
if (!empty($_FILES['thumbnail']['name'])) {
    $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $path = '../../assets/uploads/' . $filename;
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $path);
    $thumbnail = $filename;
}

$query = "INSERT INTO produk (thumbnail, nama_produk, slug, kategori, deskripsi, stok, harga)
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('sssssid', $thumbnail, $nama_produk, $slug, $kategori, $deskripsi, $stok, $harga);
$stmt->execute();

header('Location: ../produk.php');
exit;
