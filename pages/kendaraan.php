<?php
$pageTitle = 'Kredit Kendaraan - Data Kendaraan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'kendaraan';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Data Kendaraan</h1>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
        DataTables documentation</a>.</p> -->

<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
    <div class="d-flex justify-content-end mb-3">
        <a href="tambah_kendaraan.php" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Kendaraan
        </a>
    </div>
<?php endif; ?>

<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_kd']) && isset($_SESSION['alertmessage_sukses_kd'])) {
    $alertype_sukses_kd = $_SESSION['alertype_sukses_kd'];
    $alertmessage_sukses_kd = $_SESSION['alertmessage_sukses_kd'];
?>
    <div class="alert alert-<?= $alertype_sukses_kd ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_sukses_kd ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_sukses_kd']);
    unset($_SESSION['alertmessage_sukses_kd']);
}
?>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_kd']) && isset($_SESSION['alertmessage_gagal_kd'])) {
    $alertype_gagal_kd = $_SESSION['alertype_gagal_kd'];
    $alertmessage_gagal_kd = $_SESSION['alertmessage_gagal_kd'];
?>
    <div class="alert alert-<?= $alertype_gagal_kd ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_gagal_kd ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_gagal_kd']);
    unset($_SESSION['alertmessage_gagal_kd']);
}
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Kendaraan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Kendaraan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data yang akan ditampilkan
                    $sql = "SELECT * FROM tkendaraan";
                    $query = mysqli_query($conn, $sql);

                    $no = 1;
                    while ($kendaraan = mysqli_fetch_array($query)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $kendaraan['merk'] . "</td>";
                        echo "<td>" . $kendaraan['model'] . "</td>";
                        echo "<td>" . ucfirst($kendaraan['tipe']) . "</td>";
                        echo "<td>" . $kendaraan['tahun'] . "</td>";
                        echo "<td>Rp " . number_format($kendaraan['harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . $kendaraan['stok'] . "</td>";
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo "<td>
                                <a href='edit_kendaraan.php?id_kendaraan=" . $kendaraan['id_kendaraan'] . "' class='btn btn-warning btn-sm'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <a href='action/aksi_hapus_kendaraan.php?id_kendaraan=" . $kendaraan['id_kendaraan'] . "' 
                                    class='btn btn-danger btn-sm' 
                                    onclick=\"return confirm('Yakin ingin menghapus?')\">
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

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-kendaraan.js"></script>