<?php
$pageTitle = 'Kredit Kendaraan - Laporan Pembayaran';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'laporan-pembayaran';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Laporan Pembayaran</h1>
<p class="mb-4">Laporan data pembayaran kredit kendaraan.</p>

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
                        <label for="id_kredit">ID. Kredit</label>
                        <select class="form-control select2" id="id_kredit" name="id_kredit">
                            <option value="">Semua Kredit</option>
                            <?php
                            $query_kredit = "SELECT k.id_kredit, p.nama, kd.merk, kd.model 
                                          FROM tkredit k
                                          JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan
                                          JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan
                                          ORDER BY k.id_kredit DESC";
                            $result_query_kredit = mysqli_query($conn, $query_kredit);
                            while ($kredit = mysqli_fetch_array($result_query_kredit)) {
                                $selected = (isset($_GET['id_kredit']) && $_GET['id_kredit'] == $kredit['id_kredit']) ? 'selected' : '';
                                echo "<option value='" . $kredit['id_kredit'] . "' " . $selected . ">" . $kredit['id_kredit'] . " - " . $kredit['nama'] . " (" . $kredit['merk'] . " " . $kredit['model'] . ")</option>";
                            }
                            ?>
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
    <a href="laporan-pembayaran.php" class="btn btn-secondary btn-sm">
        <i class="fas fa-sync"></i> Reset Filter
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran Kredit</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Pembayaran-Laporan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID. Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>ID. Kredit</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa Cicilan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_laporan_pembayaran = "SELECT pn.*, k.id_kredit, p.nama as nama_pelanggan, kd.merk, kd.model 
                            FROM tpembayaran pn
                            JOIN tkredit k ON pn.id_kredit = k.id_kredit
                            JOIN tpelanggan p ON k.id_pelanggan = p.id_pelanggan
                            JOIN tkendaraan kd ON k.id_kendaraan = kd.id_kendaraan";

                    //add filter daterange dan id kredit jika ada
                    $where = [];
                    if (isset($_GET['tanggal_mulai']) && $_GET['tanggal_mulai'] != '') {
                        $where[] = "pn.tanggal_pembayaran >= '" . $_GET['tanggal_mulai'] . "'";
                    }
                    if (isset($_GET['tanggal_akhir']) && $_GET['tanggal_akhir'] != '') {
                        $where[] = "pn.tanggal_pembayaran <= '" . $_GET['tanggal_akhir'] . "'";
                    }
                    if (isset($_GET['id_kredit']) && $_GET['id_kredit'] != '') {
                        $where[] = "pn.id_kredit = " . $_GET['id_kredit'];
                    }

                    //gabungkan kondisi WHERE jika ada
                    if (count($where) > 0) {
                        $query_laporan_pembayaran .= " WHERE " . implode(' AND ', $where);
                    }

                    $query_laporan_pembayaran .= " ORDER BY pn.tanggal_pembayaran DESC";
                    $result_laporan_pembayaran = mysqli_query($conn, $query_laporan_pembayaran);

                    $no = 1;
                    while ($pembayaran = mysqli_fetch_array($result_laporan_pembayaran)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $pembayaran['id_pembayaran'] . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($pembayaran['tanggal_pembayaran'])) . "</td>";
                        echo "<td>" . ucfirst($pembayaran['metode_pembayaran']) . "</td>";
                        echo "<td>" . $pembayaran['id_kredit'] . "</td>";
                        echo "<td>" . $pembayaran['nama_pelanggan'] . "</td>";
                        echo "<td>" . $pembayaran['merk'] . " " . $pembayaran['model'] . "</td>";
                        echo "<td>Rp " . number_format($pembayaran['jumlah_bayar'], 0, ',', '.') . "</td>";
                        echo "<td>Rp " . number_format($pembayaran['sisa_cicilan'], 0, ',', '.') . "</td>";
                        echo "<td>" . $pembayaran['keterangan'] . "</td>";
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
<script src="../assets/vendor/select2/dist/js/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-pembayaran-laporan.js"></script>

<script>
$(document).ready(function() {
    //inisialisasi Select2
    $('.select2').select2({
        placeholder: "Pilih Semua",
        allowClear: true
    });
});
</script>