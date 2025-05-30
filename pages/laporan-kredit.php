<?php
$pageTitle = 'Kredit Kendaraan - Laporan Kredit';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'laporan-kredit';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Laporan Kredit</h1>
<p class="mb-4">Laporan data kredit kendaraan yang sedang berjalan.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            value="<?= isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                            value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="status">Status Kredit</label>
                        <select class="form-control select2" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="menunggu"
                                <?= (isset($_GET['status']) && $_GET['status'] == 'menunggu') ? 'selected' : '' ?>>
                                Menunggu</option>
                            <option value="sedang_berjalan"
                                <?= (isset($_GET['status']) && $_GET['status'] == 'sedang_berjalan') ? 'selected' : '' ?>>
                                Sedang Berjalan</option>
                            <option value="selesai"
                                <?= (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : '' ?>>
                                Selesai</option>
                            <option value="gagal"
                                <?= (isset($_GET['status']) && $_GET['status'] == 'gagal') ? 'selected' : '' ?>>Gagal
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="laporan-kredit.php" class="btn btn-secondary btn-sm">
        <i class="fas fa-sync"></i> Reset Filter
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Kredit Kendaraan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Kredit-Laporan" width="100%" cellspacing="0">
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
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_laporan_kredit = "SELECT k.*, p.nama as nama_pelanggan, kd.merk, kd.model, kd.harga, kd.tipe 
                            FROM tkredit k 
                            JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan 
                            JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan";

                    //tambahkan filter jika ada
                    $where = [];
                    if (isset($_GET['tanggal_mulai']) && $_GET['tanggal_mulai'] != '') {
                        $where[] = "k.tanggal_pengajuan >= '" . $_GET['tanggal_mulai'] . "'";
                    }
                    if (isset($_GET['tanggal_akhir']) && $_GET['tanggal_akhir'] != '') {
                        $where[] = "k.tanggal_pengajuan <= '" . $_GET['tanggal_akhir'] . "'";
                    }
                    if (isset($_GET['status']) && $_GET['status'] != '') {
                        $where[] = "k.status = '" . $_GET['status'] . "'";
                    }

                    //gabungkan kondisi WHERE jika ada
                    if (count($where) > 0) {
                        $query_laporan_kredit .= " WHERE " . implode(' AND ', $where);
                    }

                    $query_laporan_kredit .= " ORDER BY k.tanggal_pengajuan DESC";
                    $result_laporan_kredit = mysqli_query($conn, $query_laporan_kredit);

                    if (mysqli_num_rows($result_laporan_kredit) > 0) {
                        while ($kredit = mysqli_fetch_array($result_laporan_kredit)) {
                            $status = '';
                            switch ($kredit['status']) {
                                case 'menunggu':
                                    $status = '<span class="badge badge-warning">Menunggu</span>';
                                    break;
                                case 'sedang_berjalan':
                                    $status = '<span class="badge badge-primary">Sedang Berjalan</span>';
                                    break;
                                case 'selesai':
                                    $status = '<span class="badge badge-success">Selesai</span>';
                                    break;
                                case 'gagal':
                                    $status = '<span class="badge badge-danger">Gagal</span>';
                                    break;
                                default:
                                    $status = '<span class="badge badge-secondary">Tidak Diketahui</span>';
                            }

                            echo "<tr>";
                            echo "<td>" . $kredit['id_kredit'] . "</td>";
                            echo "<td>" . $kredit['nama_pelanggan'] . "</td>";
                            echo "<td>" . $kredit['merk'] . " " . $kredit['model'] . "</td>";
                            echo "<td>Rp " . number_format($kredit['harga'], 0, ',', '.') . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($kredit['tanggal_pengajuan'])) . "</td>";
                            echo "<td>" . $kredit['bunga_persen'] . " %</td>";
                            echo "<td>Rp " . number_format($kredit['total_bunga'], 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($kredit['total_harga'], 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($kredit['jumlah_cicilan'], 0, ',', '.') . " - Per " . $kredit['jangka_waktu'] . " (Bulan)</td>";
                            echo "<td>" . $status . "</td>";
                            echo "<td>
                                <a href='detail_daftar-kredit.php?id_kredit=" . $kredit['id_kredit'] . "' class='btn btn-info btn-sm'>
                                    <i class='fas fa-eye'></i> Detail
                                </a>
                              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan.</td></tr>";
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
<script src="../assets/vendor/select2/dist/js/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-kredit-laporan.js"></script>

<script>
    $(document).ready(function() {
        //inisialisasi Select2
        $('.select2').select2({
            placeholder: "Pilih Semua",
            allowClear: true
        });
    });
</script>