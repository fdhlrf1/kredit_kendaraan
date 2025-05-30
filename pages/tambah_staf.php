<?php
$pageTitle = 'Kredit Kendaraan - Tambah Staff';
session_start();
include '../config/config.php';
include '../includes/header.php';
$active_page = 'tambah_staff';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Tambah Staff</h1>
<p class="mb-4">Silahkan isi form berikut untuk membuat akun staff dan mengisi data staff.</p>

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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Staff</h6>
    </div>
    <div class="card-body">

        <form method="post" action="action/aksi_tambah_staf.php">
            <h4 class="mb-3 mt-4">
                <i class="fas fa-fw fa-id-card"></i> Data Diri Staf
            </h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Isikan nama staff" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" placeholder="Isikan jabatan staff"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_telepon">No Telepon</label>
                        <input type="number" class="form-control" name="no_telepon"
                            placeholder="Isikan no telepon staff" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Isikan email staff" required>
                    </div>
                </div>

            </div>

            <h4 class="mb-3 mt-5">
                <i class="fas fa-fw fa-user-lock"></i> Akun Login Staf
            </h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Isikan username staff"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" placeholder="Isikan password" name="password"
                            min="8" required>
                    </div>
                </div>


            </div>

            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        </form>


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