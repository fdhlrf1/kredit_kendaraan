<?php
$pageTitle = 'Kredit Kendaraan - Proses Kredit';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'proses-kredit';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="../assets/vendor/select2/select2.min.css" rel="stylesheet">


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Proses Kredit</h1>
<!-- <p class="mb-4">Silahkan isi form berikut untuk mengajukan kredit kendaraan baru.</p> -->


<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_pk']) && isset($_SESSION['alertmessage_sukses_pk'])) {
    $alertype_sukses_pk = $_SESSION['alertype_sukses_pk'];
    $alertmessage_sukses_pk = $_SESSION['alertmessage_sukses_pk'];
?>
<div class="alert alert-<?= $alertype_sukses_pk ?> alert-dismissible fade show" role="alert">
    <?= $alertmessage_sukses_pk ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
    unset($_SESSION['alertype_sukses_pk']);
    unset($_SESSION['alertmessage_sukses_pk']);
}
?>

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


<!-- Daftar Pengajuan Kredit -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Kredit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Pengajuan-Kredit" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Kredit</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Harga Kendaraan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Bunga</th>
                        <th>Total Bunga</th>
                        <th>Total Keseluruhan</th>
                        <th>Cicilan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data yang akan ditampilkan
                    $sql = "SELECT k.*, p.nama as nama_pelanggan, kd.merk, kd.model, kd.harga, kd.tipe 
                            FROM tkredit k 
                            JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan 
                            JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan 
                            WHERE k.status = 'menunggu'
                            ORDER BY k.tanggal_pengajuan DESC";
                    $query = mysqli_query($conn, $sql);

                    while ($kredit = mysqli_fetch_array($query)) {
                        // Status kredit
                        $status = "";
                        switch ($kredit['status']) {
                            case 'menunggu':
                                $status = "<span class='badge badge-warning'>Menunggu</span>";
                                break;
                            case 'sedang_berjalan':
                                $status = "<span class='badge badge-primary'>Sedang Berjalan</span>";
                                break;
                            case 'selesai':
                                $status = "<span class='badge badge-secondary'>Selesai</span>";
                                break;
                            case 'gagal':
                                $status = "<span class='badge badge-danger'>Gagal</span>";
                                break;
                            default:
                                $status = "<span class='badge badge-secondary'>Tidak Diketahui</span>";
                        }

                        echo "<tr>";
                        echo "<td>" . $kredit['id_kredit'] . "</td>";
                        echo "<td>" . $kredit['nama_pelanggan'] . "</td>";
                        echo "<td>" . $kredit['merk'] . " " . $kredit['model'] . "</td>";
                        echo "<td>Rp " . number_format($kredit['harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($kredit['tanggal_pengajuan'])) . "</td>";
                        echo "<td>" . $kredit['bunga_persen'] . " %</td>";
                        echo "<td>Rp " . number_format($kredit['total_bunga'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($kredit['total_harga'], 0, ',', '.') . "</td>";
                        // echo "<td>Rp " . number_format($kredit['harga_kendaraan'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($kredit['jumlah_cicilan'], 0, ',', '.') . " - Per " . $kredit['jangka_waktu'] . " (Bulan)</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>
                            <a href='tambah_proses-kredit.php?id_kredit=" . $kredit['id_kredit'] . "' 
                            class='btn btn-warning btn-sm mb-1' style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>
                                <i class='fas fa-cogs'></i> Proses
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

<!-- Daftar Proses Kredit -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Proses Kredit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Proses-Kredit" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Proses</th>
                        <th>ID Kredit</th>
                        <th>Nama Staf</th>
                        <th>Tanggal Proses</th>
                        <th>Hasil</th>
                        <th>Status Kredit</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Data yang akan ditampilkan
                    $sql = "SELECT pk.*, k.*, s.nama as nama_staf
                            FROM tproseskredit pk 
                            JOIN tkredit k ON k.id_kredit = pk.id_kredit 
                            LEFT JOIN tstaf s ON s.id_staf = pk.id_staf 
                            ORDER BY pk.tanggal_proses DESC";
                    $query = mysqli_query($conn, $sql);

                    while ($proses_kredit = mysqli_fetch_array($query)) {
                        $hasil = "";
                        switch ($proses_kredit['hasil']) {
                            case 'disetujui':
                                $hasil = "<span class='badge badge-success'>Disetujui</span>";
                                break;
                            case 'ditolak':
                                $hasil = "<span class='badge badge-danger'>Ditolak</span>";
                                break;
                            default:
                                $hasil = "<span class='badge badge-secondary'>Tidak Diketahui</span>";
                        }

                        $status_kredit = "";
                        switch ($proses_kredit['status']) {
                            case 'menunggu':
                                $status_kredit = "<span class='badge badge-warning'>Menunggu</span>";
                                break;
                            case 'sedang_berjalan':
                                $status_kredit = "<span class='badge badge-primary'>Sedang Berjalan</span>";
                                break;
                            case 'selesai':
                                $status_kredit = "<span class='badge badge-secondary'>Selesai</span>";
                                break;
                            case 'gagal':
                                $status_kredit = "<span class='badge badge-danger'>Gagal</span>";
                                break;
                            default:
                                $status_kredit = "<span class='badge badge-secondary'>Tidak Diketahui</span>";
                        }

                        if (empty($proses_kredit['nama_staf'])) {
                            $nama_staf = 'Administrator';
                        } else {
                            $nama_staf = $proses_kredit['nama_staf'];
                        }

                        echo "<tr>";
                        echo "<td>" . $proses_kredit['id_proses'] . "</td>";
                        echo "<td>" . $proses_kredit['id_kredit'] . "</td>";
                        echo "<td>" . $nama_staf . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($proses_kredit['tanggal_proses'])) . "</td>";
                        echo "<td>" . $hasil . "</td>";
                        echo "<td>" . $status_kredit . "</td>";
                        echo "<td>" . $proses_kredit['keterangan'] . "</td>";
                        echo "<td>
                               <a href='edit_proses-kredit.php?id_kredit=" . $proses_kredit['id_kredit'] . "' 
                            class='btn btn-warning btn-sm me-1 mb-1' style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'>
                                <i class='fas fa-edit'></i> Edit
                            </a>
                            <a href='action/aksi_hapus_proses-kredit.php?id_kredit=" . $proses_kredit['id_kredit'] . "' 
                            class='btn btn-danger btn-sm mb-1' 
                            style='font-size: 0.75rem; padding: 0.25rem 0.5rem;' 
                            onclick=\"return confirm('Yakin ingin menghapus data ini?')\">
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
<script src="../assets/vendor/select2/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-pengajuan-kredit.js"></script>
<script src="../assets/js/datatable-config/datatables-proses-kredit.js"></script>