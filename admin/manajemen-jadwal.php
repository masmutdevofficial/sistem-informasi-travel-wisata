<?php
$title = 'CRUD ADMIN';

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

// Booking Travel (biru)
$q1 = mysqli_query($koneksi, "SELECT tgl_berangkat FROM data_penumpang_travel");
while ($row = mysqli_fetch_assoc($q1)) {
    $events[] = [
        'title' => 'Booking Travel',
        'start' => $row['tgl_berangkat'],
        'color' => '#007bff' // biru
    ];
}

// Booking Carter (hijau)
$q2 = mysqli_query($koneksi, "SELECT tgl_sewa FROM data_penumpang_carter");
while ($row = mysqli_fetch_assoc($q2)) {
    $events[] = [
        'title' => 'Booking Carter',
        'start' => $row['tgl_sewa'],
        'color' => '#28a745' // hijau
    ];
}

// Booking Wisata (ungu)
$q3 = mysqli_query($koneksi, "SELECT tgl_keberangkatan FROM data_peserta_wisata");
while ($row = mysqli_fetch_assoc($q3)) {
    $events[] = [
        'title' => 'Booking Wisata',
        'start' => $row['tgl_keberangkatan'],
        'color' => '#6f42c1' // ungu
    ];
}

// Ubah ke format JSON
$eventsJson = json_encode($events);
?>

<!-- Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>File Manager</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">File Manager</li>
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
        <h3 class="card-title">Kalender Kegiatan</h3>
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
      const eventType = getEventType(info.event.title);
      const eventDate = info.event.startStr;

      fetch(`ajax/get-event-detail.php?type=${eventType}&date=${eventDate}`)
        .then(res => res.json())
        .then(data => {
          let html = '';

          if (data.length > 0) {
            data.forEach((item, index) => {
              html += `<div><b>Data ${index + 1}</b><br>`;
              for (let key in item) {
                html += `<b>${key}:</b> ${item[key]}<br>`;
              }
              html += `</div><hr>`;
            });
          } else {
            html = 'Tidak ada data untuk tanggal ini.';
          }

          Swal.fire({
            title: info.event.title,
            html: html,
            width: 600,
            confirmButtonText: 'Tutup'
          });
        })
        .catch(err => {
          Swal.fire('Error', 'Gagal mengambil data detail.', 'error');
        });
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