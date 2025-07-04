<?php
$title = 'ADMIN TRAVEL';

$customCss = '

';

$customJs = '
    <!-- Fullcalender -->
    <script src="../assets/plugins/fullcalendar/main.min.js"></script>
    <script src="../assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
';
?>

<?php include '../includes/admin_header.php' ?>

<?php
$events = [];
$q = $koneksi->query("
    SELECT id, waktu_berangkat, jenis_pemesanan
    FROM data_pesanan
    WHERE waktu_berangkat IS NOT NULL
");

$colorMap = [
    'Travel'       => '#007bff', // biru
    'Sewa/Carter'  => '#28a745', // hijau
    'Paket Wisata' => '#6f42c1'  // ungu
];

while ($row = $q->fetch_assoc()) {
    $events[] = [
        'id'    => $row['id'],                       // kirim id pesanan
        'title' => 'Booking ' . $row['jenis_pemesanan'],
        'start' => $row['waktu_berangkat'],
        'color' => $colorMap[$row['jenis_pemesanan']]
    ];
}
$eventsJson = json_encode($events);
?>

<!-- Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manajemen Jadwal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manajemen Jadwal</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Konten -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">Manajemen Jadwal</h3>
      </div>
      <div class="card-body">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Tambah/Edit Event -->
<div class="modal fade" id="modalEvent" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="formEvent">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEventTitle">Tambah Event Baru</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="eventTitle">Keterangan Event</label>
            <input type="text" id="eventTitle" class="form-control" placeholder="Contoh: Meeting Project" required>
          </div>
          <input type="hidden" id="eventStart">
          <input type="hidden" id="eventEnd">
          <input type="hidden" id="eventId">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-danger" id="btnDeleteEvent" style="display:none;">Hapus</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  var kalenderEvents = <?= $eventsJson ?>;
</script>

<?php
$bodyJs = <<<'EOD'
<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 650,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,listWeek'
    },
    events: kalenderEvents, // diisi dari PHP luar heredoc

    eventClick: function(info) {
    const idPesanan = info.event.id;

    fetch(`ajax/get-pesanan-detail.php?id=${idPesanan}`)
        .then(res => res.json())
        .then(data => {
        if (!data) {
            Swal.fire('Oops', 'Data tidak ditemukan.', 'warning');
            return;
        }

        // Susun HTML detail sederhana
        const html = `
            <b>Jenis:</b> ${data.jenis_pemesanan}<br>
            <b>Pelanggan:</b> ${data.pelanggan}<br>
            <b>Kendaraan:</b> ${data.kendaraan}<br>
            <b>Berangkat:</b> ${data.waktu_berangkat}<br>
            <b>Harga:</b> Rp${data.harga}<br>
            <b>Status Bayar:</b> ${data.status_bayar}<br>
        `;

        Swal.fire({
            title: 'Detail Pesanan #'+idPesanan,
            html: html,
            width: 600
        });
        })
        .catch(_=> Swal.fire('Error', 'Gagal mengambil data.', 'error'));
    }
  });

  calendar.render();
});

// Fungsi bantu: tentukan jenis data dari judul event
function getEventType(title) {
  title = title.toLowerCase();
  if (title.includes('travel')) return 'travel';
  if (title.includes('carter')) return 'carter';
  if (title.includes('wisata')) return 'wisata';
  return '';
}
</script>
EOD;


?>
<?php include '../includes/admin_footer.php' ?>