<?php
require '../../config/koneksi.php';

header('Content-Type: application/json');

$type = $_GET['type'] ?? '';
$date = $_GET['date'] ?? '';

$data = [];

if ($type === 'travel') {
    $query = mysqli_query($koneksi, "SELECT * FROM data_penumpang_travel WHERE tgl_berangkat = '$date'");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'Nama Penumpang'   => $row['nama_penumpang'],
            'No HP'            => $row['hp'],
            'Titik Jemput'     => $row['titik_jemput'],
            'Jumlah Penumpang' => $row['jumlah_penumpang'],
            'Harga'            => number_format($row['harga'], 0, ',', '.'),
            'Jumlah DP'        => number_format($row['jumlah_dp'], 0, ',', '.'),
            'Status Bayar'     => $row['status_bayar'],
            'Status Jemput'    => $row['status_jemput'],
        ];
    }

} elseif ($type === 'carter') {
    $query = mysqli_query($koneksi, "SELECT * FROM data_penumpang_carter WHERE tgl_sewa = '$date'");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'Nama Penyewa'   => $row['nama_penyewa'],
            'Tujuan'         => $row['tujuan'],
            'Durasi'         => $row['durasi'],
            'Harga'          => number_format($row['harga'], 0, ',', '.'),
            'Jumlah DP'      => number_format($row['jumlah_dp'], 0, ',', '.'),
            'Status Bayar'   => $row['status_bayar'],
        ];
    }

} elseif ($type === 'wisata') {
    $query = mysqli_query($koneksi, "SELECT * FROM data_peserta_wisata WHERE tgl_keberangkatan = '$date'");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'Nama Peserta'   => $row['nama_peserta'],
            'Jumlah Orang'   => $row['jumlah_orang'],
            'Harga'          => number_format($row['harga'], 0, ',', '.'),
            'Jumlah DP'      => number_format($row['jumlah_dp'], 0, ',', '.'),
            'Status Bayar'   => $row['status_bayar'],
            'Catatan'        => $row['catatan'],
        ];
    }

} else {
    $data = ['error' => 'Invalid type'];
}

echo json_encode($data);
