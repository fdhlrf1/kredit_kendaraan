<?php
$pageTitle = 'Kredit Kendaraan - Laporan Kendaraan';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'laporan-kendaraan';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Laporan Kendaraan</h1>
<p class="mb-4">Laporan data kendaraan yang tersedia.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="merk">Merk Kendaraan</label>
                        <input type="text" class="form-control" id="merk" name="merk"
                            value="<?= isset($_GET['merk']) ? $_GET['merk'] : '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="model">Model Kendaraan</label>
                        <input type="text" class="form-control" id="model" name="model"
                            value="<?= isset($_GET['model']) ? $_GET['model'] : '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipe">Tipe Kendaraan</label>
                        <select class="form-control" id="tipe" name="tipe">
                            <option value="">Semua Tipe</option>
                            <option value="motor"
                                <?= (isset($_GET['tipe']) && $_GET['tipe'] == 'motor') ? 'selected' : '' ?>>
                                Motor</option>
                            <option value="mobil"
                                <?= (isset($_GET['tipe']) && $_GET['tipe'] == 'mobil') ? 'selected' : '' ?>>
                                Mobil</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="laporan-kendaraan.php" class="btn btn-secondary btn-sm">
        <i class="fas fa-sync"></i> Reset Filter
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Kendaraan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Kendaraan-Laporan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_laporan_kendaraan = "SELECT * FROM tkendaraan";

                    $where = [];
                    if (isset($_GET['merk']) && $_GET['merk'] != '') {
                        $where[] = "merk LIKE '%" . $_GET['merk'] . "%'";
                    }
                    if (isset($_GET['model']) && $_GET['model'] != '') {
                        $where[] = "model LIKE '%" . $_GET['model'] . "%'";
                    }
                    if (isset($_GET['tipe']) && $_GET['tipe'] != '') {
                        $where[] = "tipe = '" . $_GET['tipe'] . "'";
                    }

                    if (count($where) > 0) {
                        $query_laporan_kendaraan .= " WHERE " . implode(' AND ', $where);
                    }

                    $query_laporan_kendaraan .= " ORDER BY merk, model";
                    $result_query_laporan_kendaraan = mysqli_query($conn, $query_laporan_kendaraan);

                    $no = 1;
                    if (mysqli_num_rows($result_query_laporan_kendaraan) > 0) {
                        while ($kendaraan = mysqli_fetch_array($result_query_laporan_kendaraan)) {
                            $tipe = '';
                            switch ($kendaraan['tipe']) {
                                case 'motor':
                                    $tipe = '<span class="badge badge-warning">Motor</span>';
                                    break;
                                case 'mobil':
                                    $tipe = '<span class="badge badge-primary">Mobil</span>';
                                    break;
                                default:
                                    $tipe = '<span class="badge badge-secondary">Tidak Diketahui</span>';
                            }

                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $kendaraan['merk'] . "</td>";
                            echo "<td>" . $kendaraan['model'] . "</td>";
                            echo "<td>" . $kendaraan['tahun'] . "</td>";
                            echo "<td>" . $kendaraan['stok'] . "</td>";
                            echo "<td>" . number_format($kendaraan['harga'], 0, ',', '.')  . "</td>";
                            echo "<td>" . $tipe . "</td>";
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


<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-kendaraan-laporan.js"></script>