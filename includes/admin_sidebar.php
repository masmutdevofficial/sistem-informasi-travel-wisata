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

                <!-- Menu -->
                <li class="nav-header">Menu</li>

                <li class="nav-item">
                    <a href="data-admin.php" class="nav-link <?= isActive('data-admin.php') ?> ml-3">
                        <i class="fas fa-user-shield nav-icon"></i>
                        <p>Data Admin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="data-driver.php" class="nav-link <?= isActive('data-driver.php') ?> ml-3">
                        <i class="fas fa-user-tie nav-icon"></i>
                        <p>Data Driver</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="data-kendaraan.php" class="nav-link <?= isActive('data-kendaraan.php') ?> ml-3">
                        <i class="fas fa-shuttle-van nav-icon"></i>
                        <p>Data Kendaraan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="data-pelanggan.php" class="nav-link <?= isActive('data-pelanggan.php') ?> ml-3">
                        <i class="fas fa-users-between-lines nav-icon"></i>
                        <p>Data Pelanggan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="data-pemesanan.php" class="nav-link <?= isActive('data-pemesanan.php') ?> ml-3">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Data Pemesanan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="manajemen-jadwal.php" class="nav-link <?= isActive('manajemen-jadwal.php') ?> ml-3">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Manajemen Jadwal</p>
                    </a>
                </li>

                <!-- Laporan -->
                <li class="nav-header">LAPORAN</li>

                <li class="nav-item">
                    <a href="laporan.php" class="nav-link <?= isActive('laporan.php') ?> ml-3">
                        <i class="fas fa-receipt nav-icon"></i>
                        <p>Laporan</p>
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