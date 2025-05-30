<?php
$pageTitle = 'Kredit Kendaraan - Edit Proses Kredit';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'edit_proses-kredit';
include '../includes/sidebar.php';
include '../includes/topbar.php';

// Ambil ID dari URL
if (!isset($_GET['id_kredit'])) {
    // kalau tid_blokak ada id_blok_parkir di query string
    // header('Location: form_pkeluar.php');
    error_reporting();
}

$id_kredit = $_GET['id_kredit'];

// Ambil data kredit berdasarkan ID
$sql = "SELECT k.*, p.nama AS nama_pelanggan, p.alamat, kd.merk, kd.model, kd.harga, kd.tipe, pk.* 
        FROM tkredit k 
        JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan 
        JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan 
        JOIN tproseskredit pk ON pk.id_kredit = k.id_kredit
        WHERE k.id_kredit = $id_kredit";

$query = mysqli_query($conn, $sql);
$kredit = mysqli_fetch_assoc($query);
// var_dump($kredit);
// die;


if (!$kredit) {
    echo "<div class='alert alert-danger'>Data kredit tidak ditemukan.</div>";
    include '../includes/footer.php';
    exit;
}
?>

<link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet">


<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_pk']) && isset($_SESSION['alertmessage_gagal_pk'])) {
    $alertype_gagal_pk = $_SESSION['alertype_gagal_pk'];
    $alertmessage_gagal_pk = $_SESSION['alertmessage_gagal_pk'];
?>
    <div class="alert alert-<?= $alertype_gagal_pk ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_gagal_pk ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_gagal_pk']);
    unset($_SESSION['alertmessage_gagal_pk']);
}
?>


<!-- Informasi Kredit -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Kredit</h6>
        <a href="proses-kredit.php" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Pelanggan:</strong> <?= $kredit['nama_pelanggan'] ?></p>
                <p><strong>Alamat:</strong> <?= $kredit['alamat'] ?></p>
                <p><strong>Tanggal Pengajuan:</strong> <?= date('d-m-Y', strtotime($kredit['tanggal_pengajuan'])) ?></p>
                <p><strong>Kendaraan:</strong> <?= $kredit['merk'] ?> <?= $kredit['model'] ?></p>
                <p><strong>Harga Kendaraan:</strong> Rp <?= number_format($kredit['harga'], 0, ',', '.') ?></p>
                <p><strong>Tipe Kendaraan:</strong> <?= ucfirst($kredit['tipe']) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Bunga:</strong> <?= $kredit['bunga_persen'] ?>%</p>
                <p><strong>Total Bunga:</strong> Rp <?= number_format($kredit['total_bunga'], 0, ',', '.') ?></p>
                <p><strong>Total Harga (Kredit):</strong> Rp <?= number_format($kredit['total_harga'], 0, ',', '.') ?>
                </p>
                <p><strong>Cicilan:</strong> Rp <?= number_format($kredit['jumlah_cicilan'], 0, ',', '.') ?> /
                    <?= $kredit['jangka_waktu'] ?> bulan</p>
            </div>
        </div>
    </div>
</div>


<!-- Form Proses Kredit -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Proses Kredit</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="action/aksi_edit_proses-kredit.php">
            <input type="hidden" name="id_kredit" value="<?= $kredit['id_kredit'] ?>">
            <div class="form-group">
                <label for="hasil">Status Pengajuan</label>
                <select name="hasil" class="form-control select2" required>
                    <option value="">-- Pilih Hasil --</option>
                    <option value="disetujui" <?php echo ($kredit['hasil'] == 'disetujui') ? 'selected' : '' ?>>
                        Disetujui</option>
                    <option value="ditolak" <?php echo ($kredit['hasil'] == 'ditolak') ? 'selected' : '' ?>>Ditolak
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                    placeholder="Masukkan keterangan jika diperlukan..."><?php echo $kredit['keterangan'] ?></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Simpan
                Proses</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<?php
include '../includes/modals.php';
?>
<?php include '../includes/scripts.php'; ?>

<script src="../assets/vendor/select2/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        console.log('Document ready');

        //inisialisasi Select2
        $('.select2').select2({
            placeholder: "Pilih data",
            allowClear: true
        });

    });
</script>