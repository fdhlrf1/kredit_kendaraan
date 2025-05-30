<?php
$pageTitle = 'Kredit Kendaraan - Data Pelanggan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'pelanggan';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Data Pelanggan</h1>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
        DataTables documentation</a>.</p> -->

<div class="d-flex justify-content-end mb-3">
    <a href="tambah_pelanggan.php" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pelanggan
    </a>
</div>

<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_p']) && isset($_SESSION['alertmessage_sukses_p'])) {
    $alertype_sukses_p = $_SESSION['alertype_sukses_p'];
    $alertmessage_sukses_p = $_SESSION['alertmessage_sukses_p'];
?>
    <div class="alert alert-<?= $alertype_sukses_p ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_sukses_p ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_sukses_p']);
    unset($_SESSION['alertmessage_sukses_p']);
}
?>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_p']) && isset($_SESSION['alertmessage_gagal_p'])) {
    $alertype_gagal_p = $_SESSION['alertype_gagal_p'];
    $alertmessage_gagal_p = $_SESSION['alertmessage_gagal_p'];
?>
    <div class="alert alert-<?= $alertype_gagal_p ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_gagal_p ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_gagal_p']);
    unset($_SESSION['alertmessage_gagal_p']);
}
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Pelanggan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th>Tanggal Lahir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data yang akan ditampilkan
                    $sql = "SELECT * FROM tpelanggan";
                    $query = mysqli_query($conn, $sql);

                    $no = 1;
                    while ($pelanggan = mysqli_fetch_array($query)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $pelanggan['nama'] . "</td>";
                        echo "<td>" . $pelanggan['alamat'] . "</td>";
                        echo "<td>" . $pelanggan['no_telepon'] . "</td>";
                        echo "<td>" . $pelanggan['email'] . "</td>";
                        echo "<td>" . $pelanggan['tanggal_lahir'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_pelanggan.php?id_pelanggan=" . $pelanggan['id_pelanggan'] . "' class='btn btn-warning btn-sm mr-1'>
                             <i class='fas fa-edit'></i> Edit
                            </a>";
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            echo "<a href='action/aksi_hapus_pelanggan.php?id_pelanggan=" . $pelanggan['id_pelanggan'] . "' 
                            class='btn btn-danger btn-sm' 
                            onclick=\"return confirm('Yakin ingin menghapus?')\">
                            <i class='fas fa-trash'></i> Hapus
                            </a>";
                        }
                        echo "</td>";
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
<script src="../assets/js/datatable-config/datatables-pelanggan.js"></script>