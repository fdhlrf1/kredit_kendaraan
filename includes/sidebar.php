<link rel="stylesheet" href="../assets/css/style.css">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-car"></i> -->
            <!-- <i class="fas fa-credit-card"></i> -->
            <i class="fas fa-money-check-alt"></i>

        </div>
        <div class="sidebar-brand-text mx-3">Kredit Kendaraan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($active_page == 'dashboard') ? 'active' : '' ?>">
        <a href="dashboard.php" class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Heading -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <!-- Nav Item - Kendaraan -->
    <li
        class="nav-item <?= in_array($active_page, ['kendaraan', 'tambah_kendaraan', 'edit_kendaraan']) ? 'active' : '' ?>">
        <a href="kendaraan.php" class="nav-link" href="kendaraan.php">
            <i class="fas fa-fw fa-car"></i>
            <span>Data Kendaraan</span>
        </a>
    </li>

    <!-- Nav Item - Pelanggan -->
    <li
        class="nav-item <?= in_array($active_page, ['pelanggan', 'tambah_pelanggan', 'edit_pelanggan']) ? 'active' : '' ?>">
        <a href="pelanggan.php" class="nav-link" href="pelanggan.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pelanggan</span>
        </a>
    </li>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
    <!-- Nav Item - Staff -->
    <li class="nav-item <?= in_array($active_page, ['staff', 'tambah_staff', 'edit_staff']) ? 'active' : '' ?>">
        <a href="staff.php" class="nav-link" href="staff.php">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Data Staff</span>
        </a>
    </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    <!-- Nav Item - Kredit -->
    <li
        class="nav-item <?= in_array($active_page, ['tambah-kredit', 'daftar-kredit', 'edit-kredit', 'detail_daftar-kredit']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKredit" aria-expanded="true"
            aria-controls="collapseKredit">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Kredit</span>
        </a>
        <div id="collapseKredit" class="collapse" aria-labelledby="headingKredit" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu Kredit:</h6>
                <a class="collapse-item" href="tambah_kredit.php">Pengajuan Kredit</a>
                <a class="collapse-item" href="kredit.php">Daftar Kredit</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Proses Kredit -->
    <li
        class="nav-item <?= in_array($active_page, ['proses-kredit', 'tambah_proses-kredit', 'edit_proses-kredit']) ? 'active' : '' ?>">
        <a class="nav-link" href="proses-kredit.php">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Proses Kredit</span>
        </a>
    </li>

    <!-- Nav Item - Pembayaran -->
    <li
        class="nav-item <?= in_array($active_page, ['tambah-pembayaran', 'daftar-pembayaran', 'edit_pembayaran', 'detail_riwayat-pembayaran', 'tunggakan']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePembayaran"
            aria-expanded="true" aria-controls="collapsePembayaran">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Pembayaran</span>
        </a>
        <div id="collapsePembayaran" class="collapse" aria-labelledby="headingPembayaran"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu Pembayaran:</h6>
                <a class="collapse-item" href="tambah_pembayaran.php">Input Pembayaran</a>
                <a class="collapse-item" href="pembayaran.php">Daftar Pembayaran</a>
                <a class="collapse-item" href="tunggakan.php">Tunggakan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>

    <!-- Nav Item - Laporan -->
    <li
        class="nav-item <?= in_array($active_page, ['laporan-kredit', 'laporan-pembayaran', 'laporan-tunggakan', 'laporan-kendaraan']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
            aria-expanded="true" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jenis Laporan:</h6>
                <a class="collapse-item" href="laporan-kredit.php">Laporan Kredit</a>
                <a class="collapse-item" href="laporan-pembayaran.php">Laporan Pembayaran</a>
                <a class="collapse-item" href="laporan-kendaraan.php">Laporan Kendaraan</a>
            </div>
        </div>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->