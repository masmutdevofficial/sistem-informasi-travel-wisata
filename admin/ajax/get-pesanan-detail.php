<?php
require '../../config/koneksi.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "
SELECT dp.*, 
       pl.nama_penumpang      AS pelanggan,
       CONCAT(k.nama_kendaraan,' (',k.nomor_polisi,')') AS kendaraan
FROM data_pesanan dp
JOIN data_pelanggan pl ON pl.id = dp.id_data_pelanggan
JOIN data_kendaraan k ON k.id = dp.id_kendaraan
WHERE dp.id = ?
";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
echo json_encode($res->fetch_assoc());