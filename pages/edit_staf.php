<?php
$pageTitle = 'Kredit Kendaraan - Edit Staff';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'edit_staff';
include '../includes/sidebar.php';
include '../includes/topbar.php';


if (!isset($_GET['id_staf'])) {
    // kalau tid_blokak ada id_staf di query string
    // header('Location: form_pkeluar.php');
    error_reporting();
}

//ambil id_staf dari query string
$id_staf = $_GET['id_staf'];

// buat query untuk ambil data dari database
$sql =  "SELECT s.*, u.username, u.id_user
        FROM tstaf s
        JOIN tusers u ON u.id_user = s.id_user WHERE id_staf='$id_staf'";

$query = mysqli_query($conn, $sql);
$staf = mysqli_fetch_assoc($query);

?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Edit Staff</h1>
<p class="mb-4">Silahkan edit form berikut untuk membuat akun staff dan mengisi data staff.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Staff</h6>
    </div>
    <div class="card-body">

        <form method="post" action="action/aksi_edit_staf.php">
            <input type="hidden" name="id_staf" value="<?php echo $staf['id_staf'] ?>">
            <input type="hidden" name="id_user" value="<?php echo $staf['id_user'] ?>">

            <h4 class="mb-3 mt-4">
                <i class="fas fa-fw fa-id-card"></i> Data Diri Staf
            </h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?php echo $staf['nama'] ?>"
                            placeholder="Isikan nama staff" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="<?php echo $staf['jabatan'] ?>"
                            placeholder="Isikan jabatan staff" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_telepon">No Telepon</label>
                        <input type="number" class="form-control" name="no_telepon"
                            value="<?php echo $staf['no_telepon'] ?>" placeholder="Isikan no telepon staff" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $staf['email'] ?>"
                            placeholder="Isikan email staff" required>
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
                        <input type="text" class="form-control" name="username" value="<?php echo $staf['username'] ?>"
                            placeholder="Isikan username staff" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Ganti password atau kosongkan</label>
                        <input type="password" class="form-control" placeholder="Isikan password atau kosongkan"
                            name="password" min="8">
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