<?php
$pageTitle = 'Kredit Kendaraan - Edit Kendaraan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'edit_kendaraan';
include '../includes/sidebar.php';
include '../includes/topbar.php';


if (!isset($_GET['id_kendaraan'])) {
    // kalau tid_blokak ada id_blok_parkir di query string
    // header('Location: form_pkeluar.php');
    error_reporting();
}

//ambil id_blok_parkir dari query string
$id_kendaraan = $_GET['id_kendaraan'];

// buat query untuk ambil data dari database
$sql = "SELECT * FROM tkendaraan WHERE id_kendaraan='$id_kendaraan'";
$query = mysqli_query($conn, $sql);
$kendaraan = mysqli_fetch_assoc($query);
?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Edit Kendaraan</h1>
<p class="mb-4">Silahkan edit form berikut untuk mengisi data kendaraan.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Kendaraan</h6>
    </div>
    <div class="card-body">

        <form method="post" action="action/aksi_edit_kendaraan.php">
            <input type="hidden" name="id_kendaraan" value="<?php echo $kendaraan['id_kendaraan'] ?>">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control" name="merk" value="<?php echo $kendaraan['merk'] ?>"
                            placeholder="Isikan merk kendaraan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="model">Model</label>
                        <input type="text" class="form-control" name="model" value="<?php echo $kendaraan['model'] ?>"
                            placeholder="Isikan model kendaraan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipe">Tipe Kendaraan</label>
                        <select class="form-control select2" id="tipe" name="tipe" required>
                            <option value="">-- Pilih Tipe Kendaraan --</option>
                            <option value="mobil" <?= ($kendaraan['tipe'] == 'mobil') ? 'selected' : '' ?>>Mobil
                            </option>
                            <option value="motor" <?= ($kendaraan['tipe'] == 'motor') ? 'selected' : '' ?>>Motor
                            </option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" min="1" class="form-control" name="tahun"
                            value="<?php echo $kendaraan['tahun'] ?>" placeholder="Isikan tahun kendaraan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" min="1" class="form-control" name="harga"
                            value="<?php echo $kendaraan['harga'] ?>" placeholder="Isikan harga kendaraan" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" min="1" class="form-control" name="stok"
                            value="<?php echo $kendaraan['stok'] ?>" placeholder="Isikan stok kendaraan" required>
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