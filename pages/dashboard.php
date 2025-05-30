<?php
$pageTitle = 'Kredit Kendaraan - Dashboard';
session_start();
include '../config/config.php';
include '../includes/header.php';
$active_page = 'dashboard';
include '../includes/sidebar.php';
include '../includes/topbar.php';

//total pelanggan
$query_total_pelanggan = "SELECT COUNT(*) AS total_pelanggan FROM tpelanggan";
$result_total_pelanggan = mysqli_query($conn, $query_total_pelanggan);
$data_total_pelanggan = mysqli_fetch_assoc($result_total_pelanggan);
$total_pelanggan = $data_total_pelanggan['total_pelanggan'];

//total kendaraan
$query_total_kendaraan = "SELECT COUNT(*) AS total_kendaraan FROM tkendaraan";
$result_total_kendaraan = mysqli_query($conn, $query_total_kendaraan);
$data_total_kendaraan = mysqli_fetch_assoc($result_total_kendaraan);
$total_kendaraan = $data_total_kendaraan['total_kendaraan'];

//total pembayaran bulan ini
$tahun_ini = date('Y');
$bulan_ini = date('m');
// var_dump($bulan_ini);
$query_total_pmb_bulan_ini = "SELECT SUM(jumlah_bayar) AS total_pmb_bulan_ini FROM tpembayaran WHERE YEAR(tanggal_pembayaran) = '$tahun_ini' AND MONTH(tanggal_pembayaran) = '$bulan_ini';";
$result_total_pmb_bulan_ini = mysqli_query($conn, $query_total_pmb_bulan_ini);
$data_total_pmb_bulan_ini = mysqli_fetch_assoc($result_total_pmb_bulan_ini);
$total_pmb_bulan_ini = $data_total_pmb_bulan_ini['total_pmb_bulan_ini'];

//total kredit menunggu persetujuan
$query_total_kredit_menunggu = "SELECT COUNT(*) AS total_kredit_menunggu FROM tkredit WHERE status = 'menunggu'";
$result_total_kredit_menunggu = mysqli_query($conn, $query_total_kredit_menunggu);
$data_total_kredit_menunggu = mysqli_fetch_assoc($result_total_kredit_menunggu);
$total_kredit_menunggu = $data_total_kredit_menunggu['total_kredit_menunggu'];

?>

<style>
/* .btn-primary {
        background-color: #044a70 !important;
        border-color: #044a70 !important;
    }

    .btn-primary:hover {
        background-color: #07689f !important;
        border-color: #07689f !important;
    } */
</style>

<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-900">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a> -->
</div>

<?php
if (isset($_SESSION['alert_welcome']) && isset($_SESSION['alert_welcome_message'])) {
    $alert_welcome = $_SESSION['alert_welcome'];
    $alert_welcome_message = $_SESSION['alert_welcome_message'];
?>
<div class="alert alert-<?= $alert_welcome ?> alert-dismissible fade show" role="alert">
    <?= $alert_welcome_message ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
    unset($_SESSION['alert_welcome']);
    unset($_SESSION['alert_welcome_message']);
}
?>

<!-- Content Row -->
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pelanggan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pelanggan ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Kendaraan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kendaraan ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-car fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pembayaran Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= number_format($total_pmb_bulan_ini, 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Kredit Menunggu Persetujuan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kredit_menunggu ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- pengajuan kredit terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengajuan Kredit Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Kredit</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Total</th>
                                <th>Cicilan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Data yang akan ditampilkan
                            $sql_kredit_terbaru = "SELECT k.*, p.nama as nama_pelanggan, kd.merk, kd.model, kd.harga, kd.tipe 
                            FROM tkredit k 
                            JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan 
                            JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan 
                            ORDER BY k.tanggal_pengajuan DESC LIMIT 5";
                            $query_kredit = mysqli_query($conn, $sql_kredit_terbaru);

                            while ($kredit = mysqli_fetch_array($query_kredit)) {
                                // Status kredit
                                $status = "";
                                switch ($kredit['status']) {
                                    case 'menunggu':
                                        $status = "<span class='badge badge-warning'>Menunggu</span>";
                                        break;
                                    case 'sedang_berjalan':
                                        $status = "<span class='badge badge-primary'>Sedang Berjalan</span>";
                                        break;
                                    case 'selesai':
                                        $status = "<span class='badge badge-secondary'>Selesai</span>";
                                        break;
                                    default:
                                        $status = "<span class='badge badge-secondary'>Tidak Diketahui</span>";
                                }

                                echo "<tr>";
                                echo "<td>" . $kredit['id_kredit'] . "</td>";
                                echo "<td>" . $kredit['nama_pelanggan'] . "</td>";
                                echo "<td>" . $kredit['merk'] . " " . $kredit['model'] . "</td>";
                                echo "<td>" . date('d-m-Y', strtotime($kredit['tanggal_pengajuan'])) . "</td>";
                                echo "<td>Rp " . number_format($kredit['total_harga'], 0, ',', '.') . "</td>";
                                // echo "<td>Rp " . number_format($kredit['harga_kendaraan'], 0, ',', '.') . "</td>";
                                echo "<td>Rp " . number_format($kredit['jumlah_cicilan'], 0, ',', '.') . " - Per " . $kredit['jangka_waktu'] . " (Bulan)</td>";
                                echo "<td>" . $status . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="kredit.php" class="btn btn-primary btn-sm mt-3">Lihat Semua Kredit</a>
            </div>
        </div>
    </div>

    <!-- Pembayaran Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pembayaran Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Metode Pembayaran</th>
                                <th>Total</th>
                                <th>Jumlah Bayar</th>
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_pembayaran_terbaru = "SELECT pn.*, p.nama AS nama_pelanggan, k.total_harga, k.id_kredit 
                            FROM tpembayaran pn 
                            JOIN tkredit k ON k.id_kredit = pn.id_kredit
                            JOIN tpelanggan p ON p.id_pelanggan = k.id_pelanggan 
                            ORDER BY pn.tanggal_pembayaran DESC 
                            LIMIT 5";
                            $query_pembayaran = mysqli_query($conn, $sql_pembayaran_terbaru);

                            while ($pembayaran = mysqli_fetch_array($query_pembayaran)) {
                                echo "<tr>";
                                echo "<td>" . $pembayaran['id_pembayaran'] . "</td>";
                                echo "<td>" . $pembayaran['nama_pelanggan'] . "</td>";
                                echo "<td>" . date('d-m-Y', strtotime($pembayaran['tanggal_pembayaran'])) . "</td>";
                                echo "<td>" . ucfirst($pembayaran['metode_pembayaran']) . "</td>";
                                echo "<td>Rp " . number_format($pembayaran['total_harga'], 0, ',', '.') . "</td>";
                                echo "<td>Rp " . number_format($pembayaran['jumlah_bayar'], 0, ',', '.') . "</td>";
                                echo "<td>Rp " . number_format($pembayaran['sisa_cicilan'], 0, ',', '.') . "</td>";
                                // echo "<td>" . $status . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="pembayaran.php" class="btn btn-primary btn-sm mt-3">Lihat Semua Pembayaran</a>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- stok kendaraan -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Stok Kendaraan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable-Kendaraan-Dashboard" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Merk</th>
                                <th>Model</th>
                                <th>Tipe</th>
                                <th>Tahun</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_stok_kendaraan = "SELECT * FROM tkendaraan";
                            $query_kendaraan = mysqli_query($conn, $sql_stok_kendaraan);

                            $no = 1;
                            while ($kendaraan = mysqli_fetch_array($query_kendaraan)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $kendaraan['merk'] . "</td>";
                                echo "<td>" . $kendaraan['model'] . "</td>";
                                echo "<td>" . ucfirst($kendaraan['tipe']) . "</td>";
                                echo "<td>" . $kendaraan['tahun'] . "</td>";
                                echo "<td>Rp " . number_format($kendaraan['harga'], 0, ',', '.') . "</td>";
                                echo "<td>" . $kendaraan['stok'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <a href="kendaraan.php" class="btn btn-primary btn-sm mt-3">Kelola Kendaraan</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
include '../includes/modals.php';
include '../includes/scripts.php';
?>

<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script src="../assets/js/datatable-config/datatables-kendaraan-dashboard.js"></script>