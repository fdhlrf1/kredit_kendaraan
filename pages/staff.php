<?php
$pageTitle = 'Kredit Kendaraan - Data Staff';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'staff';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Data Staff</h1>
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
        DataTables documentation</a>.</p> -->

<div class="d-flex justify-content-end mb-3">
    <a href="tambah_staf.php" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Staf
    </a>
</div>

<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_s']) && isset($_SESSION['alertmessage_sukses_s'])) {
    $alertype_sukses_s = $_SESSION['alertype_sukses_s'];
    $alertmessage_sukses_s = $_SESSION['alertmessage_sukses_s'];
?>
<div class="alert alert-<?= $alertype_sukses_s ?> alert-dismissible fade show" role="alert">
    <?= $alertmessage_sukses_s ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
    unset($_SESSION['alertype_sukses_s']);
    unset($_SESSION['alertmessage_sukses_s']);
}
?>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_s']) && isset($_SESSION['alertmessage_gagal_s'])) {
    $alertype_gagal_s = $_SESSION['alertype_gagal_s'];
    $alertmessage_gagal_s = $_SESSION['alertmessage_gagal_s'];
?>
<div class="alert alert-<?= $alertype_gagal_s ?> alert-dismissible fade show" role="alert">
    <?= $alertmessage_gagal_s ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
    unset($_SESSION['alertype_gagal_s']);
    unset($_SESSION['alertmessage_gagal_s']);
}
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Staff</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Staff" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data yang akan ditampilkan
                    $sql = "SELECT s.*, u.username
                            FROM tstaf s
                            JOIN tusers u ON u.id_user = s.id_user";
                    $query = mysqli_query($conn, $sql);

                    $no = 1;
                    while ($staf = mysqli_fetch_array($query)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $staf['nama'] . "</td>";
                        echo "<td>" . $staf['jabatan'] . "</td>";
                        echo "<td>" . $staf['no_telepon'] . "</td>";
                        echo "<td>" . $staf['email'] . "</td>";
                        echo "<td>" . $staf['username'] . "</td>";
                        echo "<td>
                                            <a href='edit_staf.php?id_staf=" . $staf['id_staf'] . "' class='btn btn-warning btn-sm'>
                                                <i class='fas fa-edit'></i> Edit
                                            </a>
                                            <a href='action/aksi_hapus_staf.php?id_staf=" . $staf['id_staf'] . "' 
                                               class='btn btn-danger btn-sm' 
                                               onclick=\"return confirm('Yakin ingin menghapus?')\">
                                                <i class='fas fa-trash'></i> Hapus
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
<script src="../assets/js/datatable-config/datatables-staff.js"></script>