<?php
$pageTitle = 'Kredit Kendaraan - Detail Kredit Kendaraan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'detail_daftar-kredit';
include '../includes/sidebar.php';
include '../includes/topbar.php';

if (!isset($_GET['id_kredit'])) {
    // kalau tid_blokak ada id_blok_parkir di query string
    // header('Location: form_pkeluar.php');
    error_reporting();
}

$id_kredit = $_GET['id_kredit'];

$query_kredit = "SELECT k.*, p.*,kd.*
                 FROM tkredit k
                 LEFT JOIN tpelanggan p ON p.id_pelanggan = k.id_pelanggan
                 LEFT JOIN tkendaraan kd ON kd.id_kendaraan = k.id_kendaraan
                 WHERE k.id_kredit = '$id_kredit'
                ";
$result_kredit = mysqli_query($conn, $query_kredit);
$kredit = mysqli_fetch_assoc($result_kredit);

$query_proses_kredit = "SELECT pk.*, s.nama AS nama_staf
                        FROM tproseskredit pk 
                        LEFT JOIN tstaf s ON s.id_staf = pk.id_staf
                        WHERE pk.id_kredit = '$id_kredit'
";
$result_proses_kredit = mysqli_query($conn, $query_proses_kredit);
$proses_kredit = mysqli_fetch_assoc($result_proses_kredit);
// var_dump($proses_kredit);
// die;

$query_pembayaran = "SELECT * FROM tpembayaran WHERE id_kredit = '$id_kredit' ORDER BY tanggal_pembayaran ASC";
$result_pembayaran = mysqli_query($conn, $query_pembayaran);
$pembayaran = mysqli_fetch_assoc($result_pembayaran);
?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-primary border-bottom pb-2">Detail Kredit #<?= $kredit['id_kredit'] ?></h1>

<!-- Detail Kredit Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold">Informasi Detail Kredit</h6>
    </div>
    <div class="card-body">
        <dl class="row mb-4">
            <dt class="col-sm-3">ID Kredit</dt>
            <dd class="col-sm-9"><?= $kredit['id_kredit'] ?></dd>

            <dt class="col-sm-3">Tanggal Pengajuan</dt>
            <dd class="col-sm-9"><?= date('d-m-Y', strtotime($kredit['tanggal_pengajuan'])) ?></dd>

            <dt class="col-sm-3">Angsuran</dt>
            <dd class="col-sm-9"><?= $kredit['jangka_waktu'] ?> Bulan</dd>

            <dt class="col-sm-3">Bunga</dt>
            <dd class="col-sm-9"><?= $kredit['bunga_persen'] ?>%</dd>

            <dt class="col-sm-3">Total Bunga</dt>
            <dd class="col-sm-9">Rp <?= number_format($kredit['total_bunga'] ?? 0, 0, ',', '.') ?></dd>

            <dt class="col-sm-3">Total Keseluruhan</dt>
            <dd class="col-sm-9">Rp <?= number_format($kredit['total_harga'] ?? 0, 0, ',', '.') ?></dd>

            <dt class="col-sm-3">Jumlah Cicilan</dt>
            <dd class="col-sm-9">Rp <?= number_format($kredit['jumlah_cicilan'] ?? 0, 0, ',', '.') ?> - Per (Bulan)</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <?php
                $badge = "";
                $status = "";
                switch ($kredit['status']) {
                    case 'menunggu':
                        $status = "Menunggu";
                        $badge = "warning";
                        break;
                    case 'sedang_berjalan':
                        $status = "Sedang Berjalan";
                        $badge = "primary";
                        break;
                    case 'selesai':
                        $status = "Selesai";
                        $badge = "secondary";
                        break;
                    case 'gagal':
                        $status = "Gagal";
                        $badge = "danger";
                        break;
                    default:
                        $badge = "secondary";
                        $status = "Tidak Diketahui";
                }

                ?>
                <span class="badge badge-<?= $badge ?> p-2"><?= ($status) ?></span>
            </dd>
        </dl>

        <h4 class="text-dark border-bottom pb-2 mb-3">Informasi Pelanggan</h4>
        <dl class="row mb-4">
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9"><?= $kredit['nama'] ?></dd>

            <dt class="col-sm-3">Alamat</dt>
            <dd class="col-sm-9"><?= $kredit['alamat'] ?></dd>

            <dt class="col-sm-3">No Telepon</dt>
            <dd class="col-sm-9"><?= $kredit['no_telepon'] ?></dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><?= $kredit['email'] ?></dd>

            <dt class="col-sm-3">Tanggal Lahir</dt>
            <dd class="col-sm-9"><?= date('d-m-Y', strtotime($kredit['tanggal_lahir'])) ?></dd>
        </dl>

        <h4 class="text-dark border-bottom pb-2 mb-3">Informasi Kendaraan</h4>
        <dl class="row">
            <dt class="col-sm-3">Merk</dt>
            <dd class="col-sm-9"><?= $kredit['merk'] ?></dd>

            <dt class="col-sm-3">Model</dt>
            <dd class="col-sm-9"><?= $kredit['model'] ?></dd>

            <dt class="col-sm-3">Tahun</dt>
            <dd class="col-sm-9"><?= $kredit['tahun'] ?></dd>

            <dt class="col-sm-3">Tipe</dt>
            <dd class="col-sm-9"><?= ucfirst($kredit['tipe']) ?></dd>

            <dt class="col-sm-3">Harga Kendaraan</dt>
            <dd class="col-sm-9">Rp <?= number_format($kredit['harga'], 0, ',', '.') ?></dd>
        </dl>
    </div>
</div>

<!-- Proses Kredit Card -->
<div class="card shadow mb-4">
    <div class="card-header bg-info text-white py-3">
        <h6 class="m-0 font-weight-bold">Proses Kredit</h6>
    </div>
    <div class="card-body">
        <?php if ($proses_kredit) : ?>
            <dl class="row">
                <dt class="col-sm-3">Tanggal Proses</dt>
                <dd class="col-sm-9"><?= date('d-m-Y', strtotime($proses_kredit['tanggal_proses'])) ?></dd>

                <dt class="col-sm-3">Staf Penanggung Jawab</dt>
                <dd class="col-sm-9"><?= $proses_kredit['nama_staf'] ?></dd>

                <dt class="col-sm-3">Keterangan</dt>
                <dd class="col-sm-9"><?= $proses_kredit['keterangan'] ?: '-' ?></dd>

                <dt class="col-sm-3">Hasil</dt>
                <dd class="col-sm-9">
                    <?php
                    $badge = "";
                    $hasil = "";
                    switch ($proses_kredit['hasil']) {
                        case 'disetujui':
                            $hasil = "Disetujui";
                            $badge = "success";
                            break;
                        case 'ditolak':
                            $hasil = "Ditolak";
                            $badge = "danger";
                            break;
                        default:
                            $badge = "secondary";
                            $hasil = "Tidak Diketahui";
                    }

                    ?>
                    <span class="badge badge-<?= $badge ?> p-2"> <?= $hasil ?></span>
                </dd>
            </dl>
        <?php else : ?>
            <div class="alert alert-warning mb-0">
                Belum ada data proses kredit.
            </div>
        <?php endif; ?>
    </div>
</div>



<a href="kredit.php" class="btn btn-secondary mb-4">
    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kredit
</a>


<?php
include '../includes/footer.php';
?>

<?php
include '../includes/modals.php';
?>

<?php
include '../includes/scripts.php';
?>