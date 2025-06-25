<?php
$title = 'CRUD ADMIN';

$customCss = '

';

$customJs = '
    <!-- Fullcalender -->
    <script src="../assets/plugins/fullcalendar/main.min.js"></script>

';
?>

<?php include '../includes/admin_header.php' ?>

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
    selectable: true,
    editable: true, // wajib biar event bisa diubah
    select: function(info) {
      // Reset modal untuk tambah event
      $('#modalEventTitle').text('Tambah Event Baru');
      $('#formEvent')[0].reset();
      $('#eventId').val('');
      $('#eventStart').val(info.startStr);
      $('#eventEnd').val(info.endStr);
      $('#btnDeleteEvent').hide();
      $('#modalEvent').modal('show');
    },
    eventClick: function(info) {
      // Isi modal untuk edit event
      $('#modalEventTitle').text('Edit Event');
      $('#eventTitle').val(info.event.title);
      $('#eventStart').val(info.event.startStr);
      $('#eventEnd').val(info.event.endStr);
      $('#eventId').val(info.event.id);
      $('#btnDeleteEvent').show().data('event', info.event);
      $('#modalEvent').modal('show');
    },
    events: [
      {
        id: '1',
        title: 'Meeting Tim',
        start: '2024-05-05'
      },
      {
        id: '2',
        title: 'Deadline Proyek',
        start: '2024-05-10',
        end: '2024-05-12'
      }
    ]
  });

  calendar.render();

  // Simpan event (baru / edit)
  $('#formEvent').on('submit', function(e) {
    e.preventDefault();
    var title = $('#eventTitle').val();
    var start = $('#eventStart').val();
    var end = $('#eventEnd').val();
    var id = $('#eventId').val();

    if (id) {
      // Edit event existing
      var event = calendar.getEventById(id);
      event.setProp('title', title);
    } else {
      // Tambah event baru
      calendar.addEvent({
        id: String(Date.now()), // generate id unik
        title: title,
        start: start,
        end: end,
        allDay: true
      });
    }

    $('#modalEvent').modal('hide');
  });

  // Hapus event
  $('#btnDeleteEvent').on('click', function() {
    var event = $(this).data('event');
    if (event) {
      event.remove();
    }
    $('#modalEvent').modal('hide');
  });
});
</script>

EOD;

?>
<?php include '../includes/admin_footer.php' ?>