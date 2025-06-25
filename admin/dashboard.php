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
    <div class="container-fluid">

        <?php
        $tanggal_hari_ini = date('Y-m-d');
        $awal_minggu = date('Y-m-d', strtotime('monday this week'));

        // Travel Hari Ini
        $travel_hari_ini = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_penumpang_travel WHERE tgl_berangkat = '$tanggal_hari_ini'");
        $jumlah_travel = mysqli_fetch_assoc($travel_hari_ini)['total'];

        // Carter Aktif (dengan status_bayar bukan 'Belum Bayar')
        $carter_aktif = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_penumpang_carter WHERE status_bayar != 'Belum Bayar'");
        $jumlah_carter = mysqli_fetch_assoc($carter_aktif)['total'];

        // Wisata Minggu Ini
        $wisata_mingguan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_peserta_wisata WHERE tgl_keberangkatan >= '$awal_minggu'");
        $jumlah_wisata = mysqli_fetch_assoc($wisata_mingguan)['total'];

        // Total Pemasukan Hari Ini
        $pemasukan = 0;
        $data_pemasukan = [];

        // Travel hari ini
        $travel = mysqli_query($koneksi, "SELECT harga, status_bayar FROM data_penumpang_travel WHERE tgl_berangkat = '$tanggal_hari_ini' AND status_bayar != 'Belum Bayar'");
        while ($row = mysqli_fetch_assoc($travel)) {
            $pemasukan += $row['status_bayar'] == 'DP' ? ($row['harga'] / 2) : $row['harga'];
        }

        // Carter hari ini
        $carter = mysqli_query($koneksi, "SELECT harga, status_bayar FROM data_penumpang_carter WHERE tgl_sewa = '$tanggal_hari_ini' AND status_bayar != 'Belum Bayar'");
        while ($row = mysqli_fetch_assoc($carter)) {
            $pemasukan += $row['status_bayar'] == 'DP' ? ($row['harga'] / 2) : $row['harga'];
        }

        // Wisata hari ini
        $wisata = mysqli_query($koneksi, "SELECT harga, status_bayar FROM data_peserta_wisata WHERE tgl_keberangkatan = '$tanggal_hari_ini' AND status_bayar != 'Belum Bayar'");
        while ($row = mysqli_fetch_assoc($wisata)) {
            $pemasukan += $row['status_bayar'] == 'DP' ? ($row['harga'] / 2) : $row['harga'];
        }
        ?>

        <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $jumlah_travel ?></h3>
                <p>Jadwal Travel Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-bus"></i></div>
            
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $jumlah_carter ?></h3>
                <p>Jadwal Charter Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-car"></i></div>
            
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $jumlah_wisata ?></h3>
                <p>Booking Wisata Minggu Ini</p>
            </div>
            <div class="icon"><i class="fas fa-map-marked-alt"></i></div>
            
            </div>
        </div>

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

        <!-- /.row -->

    </div><!-- /.container-fluid -->
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