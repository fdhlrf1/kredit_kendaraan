<?php
$pageTitle = 'Kredit Kendaraan - Tambah Kendaraan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'tambah_kendaraan';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Tambah Kendaraan</h1>
<p class="mb-4">Silahkan isi form berikut untuk dan mengisi data kendaraan.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kendaraan</h6>
    </div>
    <div class="card-body">

        <form method="post" action="action/aksi_tambah_kendaraan.php">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" placeholder="Isikan merk kendaraan"
                            required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" name="model" placeholder="Isikan model kendaraan"
                            required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipe">Tipe Kendaraan</label>
                        <select class="form-control select2" id="tipe" name="tipe" required>
                            <option value="">-- Pilih Tipe Kendaraan --</option>
                            <option value="mobil">Mobil</option>
                            <option value="motor">Motor</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" min="1" class="form-control" name="tahun"
                            placeholder="Isikan tahun kendaraan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" min="1" class="form-control" name="harga"
                            placeholder="Isikan harga kendaraan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" min="1" class="form-control" name="stok"
                            placeholder="Isikan stok kendaraan" required>
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