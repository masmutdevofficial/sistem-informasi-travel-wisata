<?php
include '../../config/koneksi.php';

header('Content-Type: application/json');

$query = "SELECT id, thumbnail, nama_produk, slug, kategori, deskripsi, stok, harga, created_at, updated_at FROM produk ORDER BY created_at DESC";
$result = $koneksi->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
