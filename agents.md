# Blueprint Halaman Admin Panel + Database Dummy

> Semua halaman admin berada di dalam folder `admin/`  
> Semua proses CRUD berada di dalam folder `admin/proses/`  
> Semua daftar data menggunakan **DataTables** dengan template dari `templates/datatables.php`

---

## 📂 Database Dummy

- File SQL: `database/dummy_db.sql`
- Digunakan untuk data awal sistem (fake data)
- Struktur tabel:
  - `users`
  - `produk`
  - `kategori`
  - `pembayaran`
  - `settings`
- Semua tabel sudah berisi minimal 2 data dummy

---

## 📄 Halaman Admin

### 1. Dashboard

- File: `admin/dashboard.php`
- URL: `/admin/dashboard.php`
- Tampilkan statistik:
  - Total Users
  - Total Produk
  - Total Pembayaran
- Tampilan ambil dari: `templates/dashboard.php`

---

### 2. Daftar Users

- File: `admin/users.php`
- URL: `/admin/users.php`
- Menggunakan DataTables dari `templates/datatables.php`
- Kolom:
  - ID, Nama, Email, Role, Status, Aksi (Edit/Hapus)
- CRUD:
  - Tambah: `admin/proses/add-user.php`
  - Edit: `admin/proses/edit-user.php`
  - Hapus: `admin/proses/delete-user.php`

---

### 3. Daftar Produk

- File: `admin/produk.php`
- URL: `/admin/produk.php`
- Template layout: `templates/datatables.php`
- Kolom:
  - ID, Nama Produk, Kategori, Harga, Stok, Gambar, Aksi
- CRUD:
  - Tambah: `admin/proses/add-produk.php`
  - Edit: `admin/proses/edit-produk.php`
  - Hapus: `admin/proses/delete-produk.php`
- Gambar: Upload ke `assets/uploads/produk/`

---

### 4. Daftar Pembayaran

- File: `admin/pembayaran.php`
- URL: `/admin/pembayaran.php`
- Menggunakan DataTables layout
- Kolom:
  - ID, Nama User, Produk, Total, Status, Tanggal, Aksi
- CRUD:
  - Tambah: `admin/proses/add-pembayaran.php`
  - Edit: `admin/proses/edit-pembayaran.php`
  - Hapus: `admin/proses/delete-pembayaran.php`

---

### 5. Kategori Produk

- File: `admin/kategori.php`
- URL: `/admin/kategori.php`
- Tabel pakai DataTables
- Kolom:
  - ID, Nama Kategori, Deskripsi, Aksi
- CRUD:
  - Tambah: `admin/proses/add-kategori.php`
  - Edit: `admin/proses/edit-kategori.php`
  - Hapus: `admin/proses/delete-kategori.php`

---

### 6. Pengaturan Website

- File: `admin/settings.php`
- URL: `/admin/settings.php`
- Form input untuk:
  - Nama Situs
  - Deskripsi
  - Logo Website (upload ke `assets/uploads/`)
- Simpan ke database/table `settings`
- Proses simpan: `admin/proses/save-settings.php`

---

## ⚙️ Layout & Komponen

- Semua halaman gunakan:
  - `includes/admin_header.php`
  - `includes/admin_navbar.php`
  - `includes/admin_sidebar.php`
  - `includes/admin_footer.php`
- Semua halaman cek login: `include '../config/session.php';`
- Untuk DataTables:
  - Gunakan struktur dari `templates/datatables.php`
  - Sertakan:
    ```php
    <script src="assets/js/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatables/dataTables.bootstrap4.min.js"></script>
    ```

---

## 🧪 Catatan Developer

- Semua proses CRUD pakai metode POST
- Untuk edit/hapus, gunakan form modal atau tombol aksi di tabel
- Form bisa diletakkan di halaman yang sama atau dibuat modal
- Semua kolom yang pakai ENUM (seperti `status`, `role`) tampilkan sebagai dropdown di form
