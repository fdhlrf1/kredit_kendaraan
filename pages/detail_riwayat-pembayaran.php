<?php
$pageTitle = 'Kredit Kendaraan - Detail Riwayat Pembayaran';
session_start();
include '../config/config.php';
include '../includes/header.php';
$active_page = 'detail_riwayat-pembayaran';
include '../includes/sidebar.php';
include '../includes/topbar.php';

$id_kredit = $_GET['id_kredit'] ?? '';

// Ambil data kredit untuk mengecek apakah ada atau tidak
$query_kredit = "SELECT k.*, p.nama AS nama_pelanggan, kd.*
              FROM tkredit k
              JOIN tpelanggan p ON p.id_pelanggan = k.id_pelanggan
              JOIN tkendaraan kd ON kd.id_kendaraan = k.id_kendaraan
              WHERE k.id_kredit = '$id_kredit'";
$result_kredit = mysqli_query($conn, $query_kredit);
$kredit = mysqli_fetch_assoc($result_kredit);

//jika tidak maka tampilkan ini
if (!$kredit) {
    echo "<div class='alert alert-danger'>Detail Riwayat pembayaran belum ada!</div>";
    echo "<a href='riwayat-pembayaran.php' class='btn btn-secondary btn-sm mb-3'><i class='fas fa-arrow-left'></i>
    Kembali</a>";
    exit;
}


?>


<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<h1 class="h3 mb-4 text-gray-900">Detail Riwayat Pembayaran</h1>

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


<a href="pembayaran.php" class="btn btn-secondary btn-sm mb-3"><i class="fas fa-arrow-left"></i>
    Kembali</a>


<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Riwayat-Pembayaran" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa Cicilan</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT pn.*, k.status
                            FROM tpembayaran pn
                            JOIN tkredit k ON k.id_kredit = pn.id_kredit
                            WHERE pn.id_kredit = '$id_kredit' ORDER BY pn.tanggal_pembayaran ASC";
                    $query = mysqli_query($conn, $sql);
                    $no = 1;
                    while ($row = mysqli_fetch_array($query)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['tanggal_pembayaran'] . "</td>";
                        echo "<td>" . ucfirst($row['metode_pembayaran']) . "</td>";
                        echo "<td>Rp " . number_format($row['jumlah_bayar'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($row['sisa_cicilan'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['keterangan'] . "</td>";
                        if ($row['status'] == 'sedang_berjalan' || $row['status'] == 'selesai') {
                            echo "<td>
                                <a href='edit_pembayaran.php?id_pembayaran=" . $row['id_pembayaran'] . "' 
                                class='btn btn-warning btn-sm me-1 mb-1' style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <a href='action/aksi_hapus_pembayaran.php?id_pembayaran=" . $row['id_pembayaran'] . "' 
                                class='btn btn-danger btn-sm mb-1' 
                                style='font-size: 0.75rem; padding: 0.25rem 0.5rem;' 
                                onclick=\"return confirm('Yakin ingin menghapus data ini?')\">
                                    <i class='fas fa-trash'></i> Hapus
                                </a>
                            </td>";
                        } else {
                            echo "<td>-</td>";
                        }
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
<script src="../assets/js/datatable-config/datatables-riwayat-pembayaran.js"></script>