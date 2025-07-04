<?php
$title = 'ADMIN TRAVEL';

$customCss = '

';

$customJs = '
    <!-- ChartJS -->
    <script src="../assets/plugins/chart.js/Chart.min.js"></script>
';
?>

<?php include '../includes/admin_header.php' ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
<?php
$tanggal_hari_ini = date('Y-m-d');
$awal_minggu = date('Y-m-d', strtotime('monday this week'));

// Travel Hari Ini
$travel_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total 
    FROM data_pesanan 
    WHERE DATE(waktu_berangkat) = '$tanggal_hari_ini'
    AND jenis_pemesanan = 'Travel'
");
$jumlah_travel = mysqli_fetch_assoc($travel_query)['total'];

// Carter Aktif (status_bayar bukan 'Belum Bayar')
$carter_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total 
    FROM data_pesanan 
    WHERE jenis_pemesanan = 'Sewa/Carter' 
    AND status_bayar != 'Belum Bayar'
");
$jumlah_carter = mysqli_fetch_assoc($carter_query)['total'];

// Wisata Minggu Ini (dari Senin sampai hari ini)
$wisata_query = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total 
    FROM data_pesanan 
    WHERE jenis_pemesanan = 'Paket Wisata'
    AND DATE(waktu_berangkat) >= '$awal_minggu'
");
$jumlah_wisata = mysqli_fetch_assoc($wisata_query)['total'];

// Total Pemasukan Hari Ini
$pemasukan = 0;
$pemasukan_query = mysqli_query($koneksi, "
    SELECT harga, jumlah_dp, tambahan_dp, status_bayar 
    FROM data_pesanan 
    WHERE DATE(waktu_berangkat) = '$tanggal_hari_ini'
    AND status_bayar != 'Belum Bayar'
");

while ($row = mysqli_fetch_assoc($pemasukan_query)) {
    if ($row['status_bayar'] === 'DP') {
        $pemasukan += $row['jumlah_dp'] + $row['tambahan_dp'];
    } else {
        $pemasukan += $row['harga'];
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Travel Hari Ini -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $jumlah_travel ?></h3>
                    <p>Jadwal Travel Hari Ini</p>
                </div>
                <div class="icon"><i class="fas fa-bus"></i></div>
            </div>
        </div>

        <!-- Carter Aktif -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $jumlah_carter ?></h3>
                    <p>Jadwal Carter Aktif</p>
                </div>
                <div class="icon"><i class="fas fa-car"></i></div>
            </div>
        </div>

        <!-- Wisata Minggu Ini -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?= $jumlah_wisata ?></h3>
                    <p>Booking Wisata Minggu Ini</p>
                </div>
                <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            </div>
        </div>

        <!-- Pemasukan Hari Ini -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Rp <?= number_format($pemasukan, 0, ',', '.') ?></h3>
                    <p>Pemasukan Hari Ini</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
            </div>
        </div>
    </div>
</div>
</section>
<!-- /.content -->
<?php
$bodyJs = <<<EOD
<script>
  $(function () {
    // BAR CHART
    const barChartCanvas = $('#barChart').get(0).getContext('2d');

    const barChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Digital Goods',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          data: [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label: 'Electronics',
          backgroundColor: 'rgba(210,214,222,1)',
          borderColor: 'rgba(210,214,222,1)',
          data: [65, 59, 80, 81, 56, 55, 40]
        }
      ]
    };

    const barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{ gridLines: { display: false }, barPercentage: 0.5 }],
        yAxes: [{ gridLines: { display: false } }]
      },
      legend: { display: true }
    };

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });
  });
</script>

EOD;

?>
<?php include '../includes/admin_footer.php' ?>