<?php
$pageTitle = 'Kredit Kendaraan - Daftar Pembayaran';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'daftar-pembayaran';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


<h1 class="h3 mb-4 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Daftar Pembayaran</h1>

<!-- <div class="d-flex justify-content-end mb-3">
    <a href="tambah_pembayaran.php" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pembayaran Kredit
    </a>
</div> -->

<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_pn']) && isset($_SESSION['alertmessage_sukses_pn'])) {
    $alertype_sukses_pn = $_SESSION['alertype_sukses_pn'];
    $alertmessage_sukses_pn = $_SESSION['alertmessage_sukses_pn'];
?>
    <div class="alert alert-<?= $alertype_sukses_pn ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_sukses_pn ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_sukses_pn']);
    unset($_SESSION['alertmessage_sukses_pn']);
}
?>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_pn']) && isset($_SESSION['alertmessage_gagal_pn'])) {
    $alertype_gagal_pn = $_SESSION['alertype_gagal_pn'];
    $alertmessage_gagal_pn = $_SESSION['alertmessage_gagal_pn'];
?>
    <div class="alert alert-<?= $alertype_gagal_pn ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_gagal_pn ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_gagal_pn']);
    unset($_SESSION['alertmessage_gagal_pn']);
}
?>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran Kredit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Kredit-Pembayaran" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>ID Kredit</th>
                        <th>Total Kredit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT k.id_kredit, k.status, k.total_harga, p.nama 
                            FROM tkredit k
                            JOIN tpelanggan p ON p.id_pelanggan = k.id_pelanggan
                            ORDER BY k.id_kredit DESC";
                    $query = mysqli_query($conn, $sql);
                    $no = 1;
                    while ($row = mysqli_fetch_array($query)) {
                        $status = "";
                        switch ($row['status']) {
                            case 'menunggu':
                                $status = "<span class='badge badge-warning'>Menunggu</span>";
                                break;
                            case 'sedang_berjalan':
                                $status = "<span class='badge badge-primary'>Sedang Berjalan</span>";
                                break;
                            case 'selesai':
                                $status = "<span class='badge badge-secondary'>Selesai</span>";
                                break;
                            case 'gagal':
                                $status = "<span class='badge badge-danger'>Gagal</span>";
                                break;
                            default:
                                $status = "<span class='badge badge-secondary'>Tidak Diketahui</span>";
                        }


                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['id_kredit'] . "</td>";
                        echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>
                                <a href='detail_riwayat-pembayaran.php?id_kredit=" . $row['id_kredit'] . "' class='btn btn-info btn-sm mb-1'
                                style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>
                                    <i class='fas fa-eye'></i> Lihat Riwayat
                                </a>
                             
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
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

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-kredit-pembayaran.js"></script>