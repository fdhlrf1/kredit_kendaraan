<?php
$pageTitle = 'Kredit Kendaraan - Tunggakan Kredit';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'tunggakan';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<h1 class="h3 mb-4 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Tunggakan Kredit</h1>


<!-- Alert Sukses -->
<?php
if (isset($_SESSION['alertype_sukses_tg']) && isset($_SESSION['alertmessage_sukses_tg'])) {
    $alertype_sukses_tg = $_SESSION['alertype_sukses_tg'];
    $alertmessage_sukses_tg = $_SESSION['alertmessage_sukses_tg'];
?>
    <div class="alert alert-<?= $alertype_sukses_tg ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_sukses_tg ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_sukses_tg']);
    unset($_SESSION['alertmessage_sukses_tg']);
}
?>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_tg']) && isset($_SESSION['alertmessage_gagal_tg'])) {
    $alertype_gagal_tg = $_SESSION['alertype_gagal_tg'];
    $alertmessage_gagal_tg = $_SESSION['alertmessage_gagal_tg'];
?>
    <div class="alert alert-<?= $alertype_gagal_tg ?> alert-dismissible fade show" role="alert">
        <?= $alertmessage_gagal_tg ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
    unset($_SESSION['alertype_gagal_tg']);
    unset($_SESSION['alertmessage_gagal_tg']);
}
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kredit yang Menunggak atau Belum Dibayar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable-Tunggakan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>ID Kredit</th>
                        <th>Tanggal Kredit</th>
                        <!-- <th>Jangka Waktu</th> -->
                        <th>Total Kredit</th>
                        <th>Sudah Bayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT k.*, p.nama, pk.tanggal_proses, pn.jumlah_bayar,
                                (SELECT COUNT(*) FROM tpembayaran WHERE id_kredit = k.id_kredit) as angsuran_terbayar
                                FROM tkredit k
                                LEFT JOIN tpelanggan p ON p.id_pelanggan = k.id_pelanggan
                                LEFT JOIN tpembayaran pn ON pn.id_kredit = k.id_kredit
                                LEFT JOIN tproseskredit pk ON pk.id_kredit = k.id_kredit
                                WHERE k.status IN ('sedang_berjalan', 'gagal')";
                    $result = mysqli_query($conn, $sql);
                    $no = 1;
                    //TANGGAL SEKARANG
                    $today = new DateTime();

                    while ($row = mysqli_fetch_array($result)) {
                        //TANGGAL KREDIT
                        $tgl_proses = new DateTime($row['tanggal_proses']);

                        //mengambil selisih antara tgl kredit dan tgl sekarang
                        $selisih = $tgl_proses->diff($today);

                        //mengubah total waktu yang sudah berjalan menjadi bulan
                        $jumlah_bulan_berjalan = ($selisih->y * 12) + $selisih->m + 1;
                        $jumlah_bulan_berjalan_cek = $jumlah_bulan_berjalan;

                        //mengambil nilai minimal antara jumlah bulan berjalan dengan jangka waktu kredit
                        //mengapa min? agar tidak melebihi jangka waktu
                        $jumlah_bulan_berjalan = min($jumlah_bulan_berjalan, $row['jangka_waktu']);

                        //mengambil sisa bulan dari jangka waktu kredit dikurang dengan jumlah bulan berjalan
                        //mengapa  max? agar tidak minus
                        $sisa_bulan = max(0, $row['jangka_waktu'] - $jumlah_bulan_berjalan);
                        // var_dump($sisa_bulan);

                        //agregasi perhitungan sudah berapa angsuran yang terbayar di tpembayaran
                        $angsuran_terbayar = $row['angsuran_terbayar'];

                        //menghitung ada berapa tunggakan, dari jumlah bulan berjalan dikurang angsuran terbayar
                        $tunggakan = $jumlah_bulan_berjalan - $angsuran_terbayar;

                        //menghitung sisa, dari total harga dikurang jumlah bayar
                        $sisa = $row['total_harga'] - $row['jumlah_bayar'];

                        // Menyusun keterangan status kredit
                        $info_status_kredit = "
                            <div class='small text-start'>
                                <strong>Informasi Kredit:</strong><br>
                                - Jangka Waktu: <strong>{$row['jangka_waktu']}</strong> bulan<br>
                                - Sudah Berjalan: <strong>{$jumlah_bulan_berjalan}</strong> bulan<br>
                                - Sudah Bayar: <strong>{$angsuran_terbayar}</strong> angsuran<br>
                                - Tunggakan: <strong>{$tunggakan}</strong> bulan<br>
                                - Sisa Waktu Kredit: <strong>{$sisa_bulan}</strong> bulan
                            </div>
                        ";

                        if ($row['status'] == 'gagal') {
                            $status = "<div class='border rounded p-2 bg-light mb-2'><span class='badge badge-danger'>Sudah Diproses menjadi Gagal</span><br>$info_status_kredit</div>";
                        } else if ($jumlah_bulan_berjalan_cek > $row['jangka_waktu']) {
                            $status = "
                            <div class='border rounded p-2 bg-light mb-2'>";
                            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                                $status .= "
                                <a href='action/aksi_proses_tunggakan.php?id_kredit={$row['id_kredit']}' 
                                    class='btn btn-danger btn-sm mb-2'
                                    style='font-size: 0.75rem; padding: 0.25rem 0.5rem;'
                                    onclick=\"return confirm('Nonaktifkan dan ubah status proses kredit jadi ditolak?')\">
                                    <i class='fas fa-exclamation-triangle'></i> Proses
                                </a>";
                            }

                            $status .= "
                                <div class='mb-1'>
                                    <span class='badge bg-danger text-white'>⚠ Kredit melebihi jangka waktu</span>
                                </div>

                                <div class='text-muted' style='font-size: 0.75rem;'>
                                    Kredit ini telah melebihi jangka waktu dan belum <strong>Lunas/Selesai</strong>.
                                </div>
                                
                                <div class='text-warning' style='font-size: 0.75rem;'>
                                    Total ada <strong>{$tunggakan}</strong> tunggakan dari <strong>{$row['jangka_waktu']}</strong> angsuran.
                                </div>
                                $info_status_kredit
                            </div>";
                        } else {
                            $status = "<div class='border rounded p-2 bg-light mb-2'><span class='badge badge-danger'>Menunggak {$tunggakan}x</span><br>$info_status_kredit</div>";
                        }


                        if ($tunggakan > 0) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['id_kredit'] . "</td>";
                            echo "<td>" . $row['tanggal_proses'] . "</td>";
                            // echo "<td>" . $row['jangka_waktu'] . " (Bulan) - sisa {$sisa_bulan} bulan</td>";
                            echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($row['jumlah_bayar'], 0, ',', '.') . "</td>";
                            echo "<td>Rp " . number_format($sisa, 0, ',', '.') . "</td>";
                            echo "<td>$status</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
include '../includes/modals.php';
include '../includes/scripts.php';
?>
<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-tunggakan.js"></script>