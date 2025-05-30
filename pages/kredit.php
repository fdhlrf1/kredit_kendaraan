<?php
$pageTitle = 'Kredit Kendaraan - Daftar Kredit';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'daftar-kredit';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="../assets/vendor/select2/select2.min.css" rel="stylesheet">


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Daftar Kredit</h1>
<!-- <p class="mb-4">Silahkan isi form berikut untuk mengajukan kredit kendaraan baru.</p> -->


<!-- <div class="d-flex justify-content-end mb-3">
    <a href="tambah_kredit.php" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pengajuan Kredit
    </a>
</div> -->


<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_k']) && isset($_SESSION['alertmessage_sukses_k'])) {
    $alertype_sukses_k = $_SESSION['alertype_sukses_k'];
    $alertmessage_sukses_k = $_SESSION['alertmessage_sukses_k'];
?>
    <div class="alert alert-<?= $alertype_sukses_k ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_sukses_k ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_sukses_k']);
    unset($_SESSION['alertmessage_sukses_k']);
}
?>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_k']) && isset($_SESSION['alertmessage_gagal_k'])) {
    $alertype_gagal_k = $_SESSION['alertype_gagal_k'];
    $alertmessage_gagal_k = $_SESSION['alertmessage_gagal_k'];
?>
    <div class="alert alert-<?= $alertype_gagal_k ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_gagal_k ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_gagal_k']);
    unset($_SESSION['alertmessage_gagal_k']);
}
?>

<!-- Daftar Kredit -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kredit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Kredit" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Kredit</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Harga Kendaraan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Bunga</th>
                        <th>Total Bunga</th>
                        <th>Total Keseluruhan</th>
                        <th>Cicilan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data yang akan ditampilkan
                    $sql = "SELECT k.*, p.nama as nama_pelanggan, kd.merk, kd.model, kd.harga, kd.tipe 
                            FROM tkredit k 
                            JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan 
                            JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan 
                            ORDER BY k.tanggal_pengajuan DESC";
                    $query = mysqli_query($conn, $sql);

                    while ($kredit = mysqli_fetch_array($query)) {
                        // Status kredit
                        $status = "";
                        switch ($kredit['status']) {
                            case 'menunggu':
                                $status = "<span class='badge badge-warning'>Menunggu</span>";
                                break;
                            case 'sedang_berjalan':
                                $status = "<span class='badge badge-primary'>Sedang Berjalan</span>
                                            <br>
                                            <a href='action/aksi_ubah-status-to-menunggu.php?id_kredit=" . $kredit['id_kredit'] . "' 
                                            class='btn btn-warning btn-sm me-1 mb-1' 
                                            style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>Ubah Status ke Menunggu</a>";
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
                        echo "<td>" . $kredit['id_kredit'] . "</td>";
                        echo "<td>" . $kredit['nama_pelanggan'] . "</td>";
                        echo "<td>" . $kredit['merk'] . " " . $kredit['model'] . "</td>";
                        echo "<td>Rp " . number_format($kredit['harga']) . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($kredit['tanggal_pengajuan'])) . "</td>";
                        echo "<td>" . $kredit['bunga_persen'] . " %</td>";
                        echo "<td>Rp " . number_format($kredit['total_bunga'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($kredit['total_harga'], 0, ',', '.') . "</td>";
                        // echo "<td>Rp " . number_format($kredit['harga_kendaraan'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($kredit['jumlah_cicilan'], 0, ',', '.') . " - Per " . $kredit['jangka_waktu'] . " (Bulan)</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>";
                        echo "<a href='detail_daftar-kredit.php?id_kredit=" . $kredit['id_kredit'] . "' 
                        class='btn btn-info btn-sm me-1 mb-1' 
                        style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>
                        <i class='fas fa-eye'></i> Detail
                        </a>";

                        if ($kredit['status'] == 'menunggu') {
                            echo "<a href='edit_kredit.php?id_kredit=" . $kredit['id_kredit'] . "' 
                            class='btn btn-warning btn-sm me-1 mb-1' 
                            style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>
                            <i class='fas fa-edit'></i> Edit
                            </a>";
                        }

                        echo "<a href='action/aksi_hapus_kredit.php?id_kredit=" . $kredit['id_kredit'] . "' 
                        class='btn btn-danger btn-sm mb-1' 
                        style='font-size: 0.75rem; padding: 0.25rem 0.5rem;' 
                        onclick=\"return confirm('Yakin ingin menghapus data ini?')\">
                        <i class='fas fa-trash'></i> Hapus
                        </a>";

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
?>

<?php
include '../includes/modals.php';
?>

<?php
include '../includes/scripts.php';
?>
<!-- Page level plugins -->
<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../assets/vendor/select2/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-kredit.js"></script>