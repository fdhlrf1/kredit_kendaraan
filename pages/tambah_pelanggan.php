<?php
$pageTitle = 'Kredit Kendaraan - Tambah Pelanggan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'tambah_pelanggan';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Tambah Pelanggan</h1>
<p class="mb-4">Silahkan isi form berikut untuk dan mengisi data pelanggan.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pelanggan</h6>
    </div>
    <div class="card-body">

        <form method="post" action="action/aksi_tambah_pelanggan.php">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Isikan nama pelanggan"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" placeholder="Isikan alamat pelanggan"
                            required></textarea>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="no_telepon">No Telepon</label>
                        <input type="number" min="1" class="form-control" name="no_telepon"
                            placeholder="Isikan no telepon pelanggan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Isikan email pelanggan"
                            required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" required>
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