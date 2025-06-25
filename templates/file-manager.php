<?php
$title = 'CRUD ADMIN';

$customCss = '

';

$customJs = '

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
        <div class="row">
            <!-- Sidebar Folder -->
            <div class="col-md-2">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Folder</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav flex-column nav-pills" id="folderList">
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="fas fa-file-alt mr-2"></i> Dokumen
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-image mr-2"></i> Gambar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-video mr-2"></i> Video
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-music mr-2"></i> Audio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-ellipsis-h mr-2"></i> Lainnya
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>

            <!-- Tampilan File -->
            <div class="col-md-10">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar File</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select id="jumlahTampil" class="form-control">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="col-md-10">
                                <input type="text" id="searchFile" class="form-control" placeholder="Cari nama file...">
                            </div>
                        </div>
                        <div class="row" id="fileList"></div>
                        <div class="mt-3" id="filePagination"></div>

                    </div>
                </div>
            </div>
        </div>
</section>

<?php
$bodyJs = <<<'EOD'
<script>
let semuaFile = [
  { name: 'Laporan.pdf', type: 'pdf', size: '245 KB' },
  { name: 'Gambar1.jpg', type: 'image', size: '1.2 MB' },
  { name: 'Video.mp4', type: 'video', size: '22 MB' },
  { name: 'Musik.mp3', type: 'audio', size: '5 MB' },
  { name: 'Backup.zip', type: 'zip', size: '10 MB' },
  { name: 'Surat.docx', type: 'docx', size: '120 KB' },
  { name: 'Data.xlsx', type: 'excel', size: '512 KB' },
  { name: 'OtherFile.xyz', type: 'other', size: '300 KB' },
  { name: 'Laporan.pdf', type: 'pdf', size: '245 KB' },
  { name: 'Gambar1.jpg', type: 'image', size: '1.2 MB' },
  { name: 'Video.mp4', type: 'video', size: '22 MB' },
  { name: 'Musik.mp3', type: 'audio', size: '5 MB' },
  { name: 'Backup.zip', type: 'zip', size: '10 MB' },
  { name: 'Surat.docx', type: 'docx', size: '120 KB' },
  { name: 'Data.xlsx', type: 'excel', size: '512 KB' },
  { name: 'OtherFile.xyz', type: 'other', size: '300 KB' },
];

let halaman = 1;
let jumlahTampil = 5;

function getIcon(type) {
  switch(type) {
    case 'pdf': return 'fa-file-pdf text-danger';
    case 'image': return 'fa-file-image text-primary';
    case 'video': return 'fa-file-video text-warning';
    case 'audio': return 'fa-file-audio text-success';
    case 'zip': return 'fa-file-archive text-secondary';
    case 'docx': return 'fa-file-word text-info';
    case 'excel': return 'fa-file-excel text-success';
    default: return 'fa-file text-muted';
  }
}

function renderFileList() {
  const keyword = $('#searchFile').val().toLowerCase();
  const filtered = semuaFile.filter(f => f.name.toLowerCase().includes(keyword));

  const start = (halaman - 1) * jumlahTampil;
  const sliced = filtered.slice(start, start + jumlahTampil);

  $('#fileList').html('');
  sliced.forEach(file => {
    $('#fileList').append(`
      <div class="col-sm-6 col-md-3 mb-3">
        <div class="border rounded p-3 h-100">
          <div class="text-center mb-2">
            <i class="fas ${getIcon(file.type)} fa-3x"></i>
          </div>
          <h6 class="text-center mb-1">${file.name}</h6>
          <p class="text-muted text-center small mb-0">${file.size}</p>
        </div>
      </div>
    `);
  });

  renderPagination(filtered.length);
}

function renderPagination(filteredLength) {
  const totalPage = Math.ceil(filteredLength / jumlahTampil);
  let html = `<nav><ul class="pagination justify-content-center">`;

  // Prev
  html += `<li class="page-item ${halaman === 1 ? 'disabled' : ''}">
             <a class="page-link page-btn" href="#" data-page="${halaman - 1}">&laquo;</a>
           </li>`;

  // Page numbers
  for (let i = 1; i <= totalPage; i++) {
    html += `<li class="page-item ${i === halaman ? 'active' : ''}">
               <a class="page-link page-btn" href="#" data-page="${i}">${i}</a>
             </li>`;
  }

  // Next
  html += `<li class="page-item ${halaman === totalPage ? 'disabled' : ''}">
             <a class="page-link page-btn" href="#" data-page="${halaman + 1}">&raquo;</a>
           </li>`;

  html += `</ul></nav>`;
  $('#filePagination').html(html);
}


$('#searchFile').on('keyup', function () {
  halaman = 1;
  renderFileList();
});

$('#jumlahTampil').on('change', function () {
  jumlahTampil = parseInt($(this).val());
  halaman = 1;
  renderFileList();
});

$(document).ready(function () {
  renderFileList();
});

$(document).on('click', '.page-btn', function (e) {
  e.preventDefault();
  const targetPage = parseInt($(this).data('page'));
  if (!isNaN(targetPage)) {
    halaman = targetPage;
    renderFileList();
  }
});
</script>

EOD;

?>
<?php include '../includes/admin_footer.php' ?>