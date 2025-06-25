<?php
$title = 'CRUD ADMIN';

$customCss = '

';

$customJs = '

';
?>

<?php include '../includes/admin_header.php' ?>

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Judul Halaman</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Judul Halaman</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <!-- Filter, Search, Jumlah Tampil -->
        <div class="row mb-3">
            <div class="col-md-1">
                <select id="jumlahTampil" class="form-control">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="filterKategori" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="Politik">Politik</option>
                    <option value="Teknologi">Teknologi</option>
                    <option value="Ekonomi">Ekonomi</option>
                    <option value="Olahraga">Olahraga</option>
                </select>
            </div>
            <div class="col-md-2">
                <select id="urutkan" class="form-control">
                    <option value="az">A - Z</option>
                    <option value="terbaru">Terbaru</option>
                    <option value="terlama">Terlama</option>
                </select>
            </div>
            <div class="col-md-7">
                <input type="text" id="searchBerita" class="form-control" placeholder="Cari berita...">
            </div>
        </div>

        <!-- Grid Berita -->
        <div class="row" id="beritaList"></div>

        <!-- Pagination -->
        <div class="mt-3" id="beritaPagination"></div>

        <!-- Berita Terkait -->
        <div class="mt-5">
            <h4>Berita Terkait</h4>
            <div class="row" id="beritaTerkait">
                <!-- Isi dinamis -->
            </div>
        </div>
    </div>
</section>

<?php
    $bodyJs = <<<'EOD'
    <script>
    let semuaBerita = [
    { judul: "Politik Hari Ini", kategori: "Politik", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-28" },
    { judul: "Teknologi AI Terbaru", kategori: "Teknologi", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-27" },
    { judul: "Perekonomian Bangkit", kategori: "Ekonomi", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-20" },
    { judul: "Timnas Menang!", kategori: "Olahraga", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-26" },
    { judul: "Kebijakan Baru Pemerintah", kategori: "Politik", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-15" },
    { judul: "Tren Startup 2024", kategori: "Teknologi", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-22" },
    { judul: "Harga Minyak Naik", kategori: "Ekonomi", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-24" },
    { judul: "Final Piala Dunia", kategori: "Olahraga", gambar: "1745442368_btrexo_logo.png", tanggal: "2024-04-19" },
    ];


    let halaman = 1;
    let jumlahTampil = 5;

    function renderBerita() {
        const keyword = $('#searchBerita').val().toLowerCase();
        const kategori = $('#filterKategori').val().toLowerCase();
        const urutkan = $('#urutkan').val();

        let filtered = semuaBerita.filter(b =>
            b.judul.toLowerCase().includes(keyword) &&
            (kategori === '' || b.kategori.toLowerCase() === kategori)
        );

        // Sorting
        if (urutkan === 'az') {
            filtered.sort((a, b) => a.judul.localeCompare(b.judul));
        } else if (urutkan === 'terbaru') {
            filtered.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
        } else if (urutkan === 'terlama') {
            filtered.sort((a, b) => new Date(a.tanggal) - new Date(b.tanggal));
        }

        const start = (halaman - 1) * jumlahTampil;
        const sliced = filtered.slice(start, start + jumlahTampil);

        $('#beritaList').html('');
        sliced.forEach(berita => {
            $('#beritaList').append(`
            <div class="col-md-3 mb-3">
                <div class="card h-100 position-relative overflow-hidden">
                <div style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                    <span class="badge badge-info">${berita.kategori}</span>
                </div>
                <img src="assets/uploads/produk/${berita.gambar}" class="card-img-top" style="height:160px; object-fit:cover;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-1 text-center">${berita.judul}</h6>
                    <small class="text-muted mb-2 text-center">${new Date(berita.tanggal).toLocaleDateString('id-ID')}</small>
                    <p class="small text-muted mb-2">
                    ${truncateText("Lorem ipsum dolor sit amet, consectetur adipiscing elit.", 50)}
                    </p>
                    <a href="#" class="btn btn-primary btn-sm">Lihat</a>
                </div>
                </div>
            </div>
            `);
        });

        renderBeritaPagination(filtered.length);
        renderBeritaTerkait(filtered);
    }


    function renderBeritaPagination(total) {
        const totalHalaman = Math.ceil(total / jumlahTampil);
        let html = `<nav><ul class="pagination justify-content-center">`;

        html += `<li class="page-item ${halaman === 1 ? 'disabled' : ''}">
                <a class="page-link page-btn" href="#" data-page="${halaman - 1}">&laquo;</a>
            </li>`;

        for (let i = 1; i <= totalHalaman; i++) {
            html += `<li class="page-item ${i === halaman ? 'active' : ''}">
                <a class="page-link page-btn" href="#" data-page="${i}">${i}</a>
                </li>`;
        }

        html += `<li class="page-item ${halaman === totalHalaman ? 'disabled' : ''}">
                <a class="page-link page-btn" href="#" data-page="${halaman + 1}">&raquo;</a>
            </li>`;

        html += `</ul></nav>`;
        $('#beritaPagination').html(html);
    }

    function renderBeritaTerkait(filtered) {
        const terkait = filtered.slice(0, 4); // Ambil 4 berita pertama sebagai "terkait"
        $('#beritaTerkait').html('');
        terkait.forEach(berita => {
            $('#beritaTerkait').append(`
            <div class="col-md-3 mb-3">
                <div class="card h-100 position-relative overflow-hidden">
                <div style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                    <span class="badge badge-info">${berita.kategori}</span>
                </div>
                <img src="assets/uploads/produk/${berita.gambar}" class="card-img-top" style="height:160px; object-fit:cover;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-1 text-center">${berita.judul}</h6>
                    <small class="text-muted mb-2 text-center">${new Date(berita.tanggal).toLocaleDateString('id-ID')}</small>
                    <p class="small text-muted mb-2">
                    ${truncateText("Lorem ipsum dolor sit amet, consectetur adipiscing elit.", 50)}
                    </p>
                    <a href="#" class="btn btn-primary btn-sm">Lihat</a>
                </div>
                </div>
            </div>
        `);
        });
    }
    
    function truncateText(text, maxLength) {
        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    }

    $(document).ready(function () {
    renderBerita();

    $('#searchBerita, #filterKategori').on('input', function () {
        halaman = 1;
        renderBerita();
    });

    $('#jumlahTampil').on('change', function () {
        jumlahTampil = parseInt($(this).val());
        halaman = 1;
        renderBerita();
    });

    $('#urutkan').on('change', function () {
        halaman = 1;
        renderBerita();
    });

    $(document).on('click', '.page-btn', function (e) {
        e.preventDefault();
        const target = parseInt($(this).data('page'));
        if (!isNaN(target)) {
        halaman = target;
        renderBerita();
        }
    });
    });
    </script>

EOD;

?>

<?php include '../includes/admin_footer.php' ?>