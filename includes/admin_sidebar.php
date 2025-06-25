  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link d-flex justify-content-center align-items-center">
          <span class="brand-text font-weight-light font-weight-bold">ADMIN</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <!-- Menu Utama -->
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?= isActive('dashboard.php') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="nav-header">MASTER DATA</li>

                <li class="nav-item">
                    <a href="kelola-admin.php" class="nav-link <?= isActive('kelola-admin.php') ?> ml-3">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <p>Kelola Admin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola-driver.php" class="nav-link <?= isActive('kelola-driver.php') ?> ml-3">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Kelola Driver</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola-kendaraan.php" class="nav-link <?= isActive('kelola-kendaraan.php') ?> ml-3">
                        <i class="fas fa-shuttle-van nav-icon"></i>
                        <p>Kelola Kendaraan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola-paket-wisata.php" class="nav-link <?= isActive('kelola-paket-wisata.php') ?> ml-3">
                        <i class="fas fa-map-marked-alt nav-icon"></i>
                        <p>Kelola Paket Wisata</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola-rute.php" class="nav-link <?= isActive('kelola-rute.php') ?> ml-3">
                        <i class="fas fa-street-view nav-icon"></i>
                        <p>Kelola Rute</p>
                    </a>
                </li>

                <!-- Input Data -->
                <li class="nav-header">INPUT DATA</li>
                

                <li class="nav-item">
                    <a href="data-penumpang-travel.php" class="nav-link <?= isActive('data-penumpang-travel.php') ?> ml-3">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Data Penumpang Travel</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data-carter.php" class="nav-link <?= isActive('data-carter.php') ?> ml-3">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Data Carter/Sewa</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="data-peserta-wisata.php" class="nav-link <?= isActive('data-peserta-wisata.php') ?> ml-3">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Data Peserta Wisata</p>
                    </a>
                </li>

                <!-- Manajemen Jadwal -->
                <li class="nav-header">JADWAL</li>

                <li class="nav-item">
                    <a href="manajemen-jadwal.php" class="nav-link <?= isActive('manajemen-jadwal.php') ?> ml-3">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Manajemen Jadwal</p>
                    </a>
                </li>

                <!-- Laporan -->
                <li class="nav-header">LAPORAN</li>

                <li class="nav-item">
                    <a href="laporan-transaksi.php" class="nav-link <?= isActive('laporan-transaksi.php') ?> ml-3">
                        <i class="fas fa-receipt nav-icon"></i>
                        <p>Laporan Transaksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="laporan-keuangan.php" class="nav-link <?= isActive('laporan-keuangan.php') ?> ml-3">
                        <i class="fas fa-wallet nav-icon"></i>
                        <p>Laporan Keuangan</p>
                    </a>
                </li>


              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">