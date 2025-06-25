<?php
$title = 'CRUD ADMIN';

$customCss = '

';

$customJs = '

';
?>

<?php include '../includes/admin_header.php' ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>POS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">POS</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Daftar Produk</h4>
            <div>
                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalTambahProduk">
                    <i class="fa fa-plus mr-1"></i> Tambah Data
                </button>
                <button class="btn btn-secondary mr-2" data-toggle="modal" data-target="#modalExportExcel">
                    <i class="fa fa-print mr-1"></i> Export Data
                </button>
            </div>
        </div>
        <div class="row">
            <!-- Katalog Produk -->
            <div class="col-md-8">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select id="filterKategori" class="form-control">
                            <option value="">Semua Kategori</option>
                            <!-- Opsi kategori bisa hardcode atau dinamis -->
                            <option value="Elektronik">Elektronik</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Makanan">Makanan</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <select id="jumlahTampil" class="form-control">
                            <option value="6">6</option>
                            <option value="12">12</option>
                            <option value="24">24</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    <div class="col-md-10">
                        <input type="text" id="searchProduk" class="form-control" placeholder="Cari produk...">
                    </div>
                </div>

                <div class="row" id="produkContainer"></div>
                <div class="mt-3" id="pagination"></div>
            </div>

            <!-- Detail dan Checkout -->
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="card-title">Detail Produk</h5>
                    </div>
                    <div class="card-body d-flex flex-column" id="detailProduk">
                        <p class="text-muted">Klik produk untuk melihat detail atau tambahkan ke keranjang.</p>
                    </div>

                    <!-- Bungkus tabel dengan div scrollable -->
                    <div class="table-responsive p-2 d-none" id="checkoutWrapper">
                        <table class="table table-sm table-bordered mb-0" id="checkoutTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <!-- Ringkasan Checkout -->
                        <div class="w-100 p-2 border-top d-none" id="checkoutSummary">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Jumlah Barang:</strong>
                                <span id="totalQty">0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>Total Belanja:</strong>
                                <span id="totalBelanja">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <strong>PPN (11%):</strong>
                                <span id="ppnBelanja">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total Bayar:</strong>
                                <span id="grandTotal">Rp 0</span>
                            </div>
                            <div class="form-group mb-0">
                                <label for="kupon">Kode Kupon (opsional)</label>
                                <input type="text" id="kupon" name="kupon" class="form-control form-control-sm"
                                    placeholder="Masukkan kode kupon...">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <form action="checkout.php" method="POST" id="checkoutForm">
                        <input type="hidden" name="id_produk" id="inputProdukId">
                        <button type="submit" class="btn btn-primary btn-block" disabled
                            id="btnCheckout">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="proses/add-produk.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Export Excel -->
<div class="modal fade" id="modalExportExcel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-row justify-content-center align-items-center">
                    <a href="export-excel.php" class="btn btn-success mr-2"><i
                            class="fa fa-file-excel mr-1"></i>Download Excel</a>
                    <a href="export-pdf.php" class="btn btn-danger"><i class="fa fa-file-pdf mr-1"></i>Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export PDF -->
<div class="modal fade" id="modalExportPDF" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export ke PDF</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tekan tombol di bawah untuk mengunduh file PDF berisi data produk.</p>
                <a href="export-pdf.php" class="btn btn-danger">Download PDF</a>
            </div>
        </div>
    </div>
</div>

<?php
    $bodyJs = <<<'EOD'
    <script>
        let semuaProduk = [];
        let halaman = 1;
        let jumlahTampil = 6;
        let keranjang = [];

        function renderProduk(data) {
        $('#produkContainer').html('');
        if (data.length === 0) {
            $('#produkContainer').html(`<div class="col-12"><div class="card card-outline card-primary p-3 text-center font-weight-bold">Produk tidak ditemukan</div></div>`);
            $('#pagination').html('');
            return;
        }

        const start = (halaman - 1) * jumlahTampil;
        const paginated = data.slice(start, start + jumlahTampil);

        paginated.forEach(p => {
        $('#produkContainer').append(`
            <div class="col-md-4 mb-3">
            <div class="card card-outline card-primary produk-card position-relative"
                data-id="${p.id}" 
                data-nama="${p.nama_produk}" 
                data-harga="${p.harga}" 
                data-kategori="${p.kategori}"
                data-stok="${p.stok}" 
                data-thumbnail="${p.thumbnail}" 
                data-deskripsi="${p.deskripsi}">
                
                <!-- Tombol Keranjang (pojok kanan atas) -->
                <button class="btn btn-sm btn-primary position-absolute btn-keranjang"
                        style="top: 10px; right: 10px; z-index: 10;">
                <i class="fa fa-cart-plus"></i>
                </button>
                
                <img src="../${p.thumbnail}" class="card-img-top rounded-top" style="height:160px; object-fit:cover;">

                <div class="card-body p-2 rounded">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title mb-1 font-weight-bold">${p.nama_produk}</h5>
                    <p class="mb-1 text-muted">Rp ${parseInt(p.harga).toLocaleString('id-ID')}</p>
                </div>
                <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                    <span class="badge badge-primary">${p.kategori}</span>
                    <span class="badge badge-info">Stok: ${p.stok}</span>
                </div>
                <!-- Tombol Pesan -->
                <button class="btn btn-success btn-sm btn-block btn-pesan">
                    <i class="fa fa-shopping-cart mr-1"></i> Pesan
                </button>
                </div>
            </div>
            </div>
        `);
        });

        renderPagination(data.length);
        }

        function renderPagination(total) {
            const totalHalaman = Math.ceil(total / jumlahTampil);
            const maxTampil = 5; // maks halaman yang ditampilkan di navigasi
            let html = `<nav><ul class="pagination justify-content-center">`;

            // Previous button
            html += `<li class="page-item ${halaman === 1 ? 'disabled' : ''}">
                <a class="page-link page-btn" href="#" data-page="${halaman - 1}">&laquo;</a>
            </li>`;

            let start = Math.max(1, halaman - Math.floor(maxTampil / 2));
            let end = Math.min(totalHalaman, start + maxTampil - 1);

            if (end - start < maxTampil - 1) {
                start = Math.max(1, end - maxTampil + 1);
            }

            if (start > 1) {
                html += `<li class="page-item"><a class="page-link page-btn" href="#" data-page="1">1</a></li>`;
                if (start > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }

            for (let i = start; i <= end; i++) {
                html += `<li class="page-item ${i === halaman ? 'active' : ''}">
                <a class="page-link page-btn" href="#" data-page="${i}">${i}</a>
                </li>`;
            }

            if (end < totalHalaman) {
                if (end < totalHalaman - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                html += `<li class="page-item"><a class="page-link page-btn" href="#" data-page="${totalHalaman}">${totalHalaman}</a></li>`;
            }

            // Next button
            html += `<li class="page-item ${halaman === totalHalaman ? 'disabled' : ''}">
                <a class="page-link page-btn" href="#" data-page="${halaman + 1}">&raquo;</a>
            </li>`;

            html += `</ul></nav>`;
            $('#pagination').html(html);
        }

        function filterProduk() {
        const keyword = $('#searchProduk').val().toLowerCase();
        const kategori = $('#filterKategori').val().toLowerCase();
        const hasil = semuaProduk.filter(p => {
            const cocokKategori = kategori === '' || p.kategori.toLowerCase().includes(kategori);
            const cocokCari = p.nama_produk.toLowerCase().includes(keyword) || p.deskripsi.toLowerCase().includes(keyword);
            return cocokKategori && cocokCari;
        });

        renderProduk(hasil);
        }

        $(document).ready(function () {
        $.getJSON('proses/get-produk.php', function (res) {
            semuaProduk = res;
            filterProduk();
        });

        $('#searchProduk, #filterKategori').on('input', function () {
            halaman = 1;
            filterProduk();
        });

        $('#jumlahTampil').on('change', function () {
            jumlahTampil = parseInt($(this).val());
            halaman = 1;
            filterProduk();
        });

        $(document).on('click', '.page-btn', function (e) {
            e.preventDefault();
            halaman = parseInt($(this).data('page'));
            filterProduk();
        });

        // Tombol PESAN (hanya 1 produk)
        $(document).on('click', '.btn-pesan', function (e) {
        e.stopPropagation();

        const card = $(this).closest('.produk-card');
        const nama = card.data('nama');
        const harga = parseInt(card.data('harga')).toLocaleString('id-ID');
        const stok = card.data('stok');
        const kategori = card.data('kategori');
        const deskripsi = card.data('deskripsi');
        const thumb = card.data('thumbnail');
        const id = card.data('id');

        // Ganti isi detailProduk dengan 1 produk saja
        $('#detailProduk').html(`
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img src="../${thumb}" class="img-fluid rounded mb-2" style="max-height:180px;object-fit:cover;">
                <h5>${nama}</h5>
                <p class="text-muted mb-1">Rp ${harga}</p>
            </div>
            <div class="d-flex flex-column justify-content-start align-items-start">
                <p class="mb-0"><strong>Kategori:</strong> ${kategori}</p>
                <p class="mb-0"><strong>Stok:</strong> ${stok}</p>
                <p class="mb-0">${deskripsi}</p>
            </div>
        `);

        // Reset keranjang UI jika sebelumnya tampil
        $('#checkoutTable tbody').empty();
        $('#checkoutWrapper').addClass('d-none');

        // Set ID ke input hidden
        $('#inputProdukId').val(id);
        $('#btnCheckout').prop('disabled', false);
        });

        // Tombol KERANJANG (tabel multi produk)
        $(document).on('click', '.btn-keranjang', function (e) {
        e.stopPropagation();

        const card = $(this).closest('.produk-card');
        const id = card.data('id');
        const nama = card.data('nama');
        const kategori = card.data('kategori');
        const harga = parseInt(card.data('harga'));

        const existing = keranjang.find(item => item.id === id);

        if (existing) {
            existing.qty += 1;
            existing.subtotal = existing.qty * existing.harga;
        } else {
            keranjang.push({ id, nama, kategori, harga, qty: 1, subtotal: harga });
        }

        // Generate tabel checkout
        let html = '';
        keranjang.forEach((item, index) => {
            html += `
            <tr>
                <td>${index + 1}</td>
                <td>
                    <div style='width:120px;'>
                        ${item.nama.length > 8 ? item.nama.substring(0, 8) + '...' : item.nama}
                    </div>
                </td>
                <td>
                    <div style='width:120px;'>
                        Rp ${item.harga.toLocaleString('id-ID')}
                    </div>
                </td>
                <td>${item.qty}</td>
                <td>
                    <div style='width:120px;'>
                        Rp ${item.subtotal.toLocaleString('id-ID')}
                    </div>
                </td>
            </tr>
            `;
        });

        let totalQty = 0;
        let totalHarga = 0;

        keranjang.forEach(item => {
            totalQty += item.qty;
            totalHarga += item.subtotal;
        });

        const ppn = Math.round(totalHarga * 0.11);
        const grandTotal = totalHarga + ppn;

        $('#totalQty').text(totalQty);
        $('#totalBelanja').text(`Rp ${totalHarga.toLocaleString('id-ID')}`);
        $('#ppnBelanja').text(`Rp ${ppn.toLocaleString('id-ID')}`);
        $('#grandTotal').text(`Rp ${grandTotal.toLocaleString('id-ID')}`);
        $('#checkoutSummary').removeClass('d-none');

        // Tambahkan header <th> baru kalau belum ada
        $('#checkoutTable thead').html(`
            <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
            </tr>
        `);

        $('#checkoutTable tbody').html(html);
        $('#checkoutWrapper').removeClass('d-none');

        // Kosongkan tampilan detail jika sebelumnya dalam mode "Pesan"
        $('#detailProduk').contents().filter(function () {
            return this.nodeType === 3 || this.tagName !== "TABLE";
        }).remove();
        });

        });
    </script>
    EOD;
?>
<?php include '../includes/admin_footer.php' ?>