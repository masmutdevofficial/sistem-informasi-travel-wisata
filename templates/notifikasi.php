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
                <h1>Notifikasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Notifikasi</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Kontrol Notifikasi -->
<section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-2">
                <select id="jumlahNotifTampil" class="form-control">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-10">
                <input type="text" id="searchNotif" class="form-control" placeholder="Cari notifikasi...">
            </div>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Daftar Notifikasi</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush" id="notifList">
                    <!-- Notifikasi akan dimasukkan disini -->
                </ul>
            </div>
            <div class="card-footer" id="notifPagination">
                <!-- Pagination akan masuk disini -->
            </div>
        </div>
    </div>
</section>

<?php
$bodyJs = <<<'EOD'
<script>
    let semuaNotifikasi = [
    { icon: 'fa-check-circle', judul: 'Transaksi Berhasil', pesan: 'Pembayaran #1234 telah berhasil.', waktu: '2 menit lalu' },
    { icon: 'fa-user-plus', judul: 'Pengguna Baru', pesan: 'Akun baru telah terdaftar.', waktu: '10 menit lalu' },
    { icon: 'fa-exclamation-triangle', judul: 'Gagal Login', pesan: 'Seseorang gagal login ke akun Anda.', waktu: '1 jam lalu' },
    { icon: 'fa-info-circle', judul: 'Update Sistem', pesan: 'Sistem diperbarui ke versi 1.2.', waktu: '3 jam lalu' },
    { icon: 'fa-bell', judul: 'Pengingat', pesan: 'Jangan lupa verifikasi akun Anda.', waktu: '1 hari lalu' },
    { icon: 'fa-envelope', judul: 'Pesan Baru', pesan: 'Anda menerima pesan dari Admin.', waktu: '2 hari lalu' },
    { icon: 'fa-exclamation-circle', judul: 'Peringatan', pesan: 'Percobaan login mencurigakan.', waktu: '5 hari lalu' }
    ];

    let halaman = 1;
    let jumlahTampil = 5;
    function renderNotifList() {
    const keyword = $('#searchNotif').val().toLowerCase();
    const filtered = semuaNotifikasi.filter(n => 
        n.judul.toLowerCase().includes(keyword) || n.pesan.toLowerCase().includes(keyword)
    );

    const start = (halaman - 1) * jumlahTampil;
    const sliced = filtered.slice(start, start + jumlahTampil);

    $('#notifList').html('');
    sliced.forEach(n => {
        $('#notifList').append(`
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center">
            <i class="fas ${n.icon} text-primary mr-3"></i>
            <div>
                <strong>${n.judul}</strong><br>
                <small class="text-muted">${n.pesan}</small>
            </div>
            </div>
            <span class="text-muted small">${n.waktu}</span>
        </li>
        `);
    });

    renderPagination(filtered.length);
    }

    function renderPagination(totalData) {
    const totalPage = Math.ceil(totalData / jumlahTampil);
    let html = `<nav><ul class="pagination justify-content-center mb-0">`;

    html += `<li class="page-item ${halaman === 1 ? 'disabled' : ''}">
                <a class="page-link page-btn" href="#" data-page="${halaman - 1}">&laquo;</a>
            </li>`;

    for (let i = 1; i <= totalPage; i++) {
        html += `<li class="page-item ${i === halaman ? 'active' : ''}">
                <a class="page-link page-btn" href="#" data-page="${i}">${i}</a>
                </li>`;
    }

    html += `<li class="page-item ${halaman === totalPage ? 'disabled' : ''}">
                <a class="page-link page-btn" href="#" data-page="${halaman + 1}">&raquo;</a>
            </li>`;

    html += `</ul></nav>`;
    $('#notifPagination').html(html);
    }

    $(document).ready(function () {
    renderNotifList();

    $('#searchNotif').on('keyup', function () {
        halaman = 1;
        renderNotifList();
    });

    $('#jumlahNotifTampil').on('change', function () {
        jumlahTampil = parseInt($(this).val());
        halaman = 1;
        renderNotifList();
    });

    $(document).on('click', '.page-btn', function (e) {
        e.preventDefault();
        const targetPage = parseInt($(this).data('page'));
        if (!isNaN(targetPage)) {
        halaman = targetPage;
        renderNotifList();
        }
    });
    });
</script>
EOD;

?>

<?php include '../includes/admin_footer.php' ?>