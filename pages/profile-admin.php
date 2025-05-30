<?php
$pageTitle = 'Kredit Kendaraan - Kelola Profil';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = '';
include '../includes/sidebar.php';
include '../includes/topbar.php';

$query = "SELECT * FROM tusers WHERE role='admin'";
$execute = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($execute);
?>


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Kelola Profil</h1>
<p class="mb-4">Silahkan kelola profil anda sebagai Admin.</p>

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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Kelola Profil</h6>
    </div>
    <div class="card-body">

        <form method="post" action="action/aksi_profil-admin.php">
            <input type="hidden" value="<?php echo $admin['id_user'] ?>" name="id_user">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Kelola nama"
                            value="<?php echo $admin['nama'] ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" placeholder="Kelola alamat"
                            required><?php echo $admin['alamat'] ?></textarea>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Kelola username"
                            value="<?php echo $admin['username'] ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Ganti password atau kosongkan</label>
                        <input type="password" class="form-control" placeholder="Isikan password atau kosongkan"
                            name="password">
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