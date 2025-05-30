<?php
$pageTitle = 'Kendaraan Kredit - Edit Pembayaran';
session_start();
include '../config/config.php';
include '../includes/header.php';
$active_page = 'edit-pembayaran';
include '../includes/sidebar.php';
include '../includes/topbar.php';

// Ambil id_pembayaran
$id_pembayaran = $_GET['id_pembayaran'] ?? 0;

$query_pembayaran = "SELECT * FROM tpembayaran WHERE id_pembayaran = '$id_pembayaran'";
$result_pembayaran = mysqli_query($conn, $query_pembayaran);
$pembayaran = mysqli_fetch_assoc($result_pembayaran);
if (!$pembayaran) {
    echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";
    exit;
}

$query_terakhir = "SELECT sisa_cicilan FROM tpembayaran 
                   WHERE id_kredit = '{$pembayaran['id_kredit']}'
                   ORDER BY tanggal_pembayaran DESC, id_pembayaran DESC
                   LIMIT 1";
$result_terakhir = mysqli_query($conn, $query_terakhir);
$row_terakhir = mysqli_fetch_assoc($result_terakhir);

if ($row_terakhir) {
    $sisa_terakhir = $row_terakhir['sisa_cicilan'];
} else {
    $sisa_terakhir = 0;
}



// Ambil data kredit 
$query_kredit = "SELECT k.*, p.nama 
                 FROM tkredit k 
                 JOIN tpelanggan p  
                 ON p.id_pelanggan = k.id_pelanggan 
                 WHERE k.id_kredit = '{$pembayaran['id_kredit']}'";
$result_kredit = mysqli_query($conn, $query_kredit);
$kredit = mysqli_fetch_assoc($result_kredit);
// var_dump($kredit);

// Hitung total bayar sebelumnya untuk mengetahui sisa cicilan nya berapa lagi
$query_total_bayar_sebelumnya = "SELECT SUM(jumlah_bayar) as total_bayar 
                                  FROM tpembayaran 
                                WHERE id_kredit = '{$pembayaran['id_kredit']}' 
                                AND id_pembayaran != '$id_pembayaran'";
$result_total_bayar_sebelumnya = mysqli_query($conn, $query_total_bayar_sebelumnya);
$total_bayar_sebelumnya = mysqli_fetch_assoc($result_total_bayar_sebelumnya);
// var_dump($total_bayar_sebelumnya);
$sisa_cicilan = $kredit['total_harga'] - ($total_bayar_sebelumnya['total_bayar'] ?? 0);
// var_dump($total_bayar_sebelumnya['total_bayar']);
$jumlah_cicilan = $kredit['jumlah_cicilan'];
$total_harga = $kredit['total_harga'];
// $max_kelipatan = floor($sisa_cicilan / $jumlah_cicilan);
// $kelipatan_terpakai = round($pembayaran['jumlah_bayar'] / $jumlah_cicilan);
?>

<link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Edit Pembayaran Cicilan</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Pembayaran Kredit</h6>
    </div>
    <div class="card-body">
        <form action="action/aksi_edit_pembayaran.php" method="POST">
            <input type="hidden" name="id_pembayaran" value="<?= $id_pembayaran ?>">
            <input type="hidden" name="id_kredit" value="<?= $kredit['id_kredit'] ?>">

            <div class="form-group">
                <label>Kredit</label>
                <input type="text" class="form-control"
                    value="#<?= $kredit['id_kredit'] ?> - <?= $kredit['nama'] ?> - Total: Rp <?= number_format($kredit['total_harga'], 0, ',', '.') ?>"
                    readonly>
            </div>

            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" class="form-control" value="Rp<?= number_format($total_harga,  0, ',', '.') ?>"
                    readonly>
            </div>

            <div class="form-group">
                <label>Jumlah Cicilan per (Bulan)</label>
                <input type="text" class="form-control" value="Rp<?= number_format($jumlah_cicilan, 0, ',', '.') ?>"
                    readonly>
            </div>

            <div class="form-group">
                <label>Sisa Cicilan Saat Ini</label>
                <input type="text" id="sisa_cicilan_display" class="form-control"
                    value="Rp <?= number_format($sisa_terakhir, 0, ',', '.') ?>" readonly>
            </div>

            <div class="form-group">
                <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_pembayaran" class="form-control"
                    value="<?= $pembayaran['tanggal_pembayaran'] ?>" required>
            </div>

            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" name="metode_pembayaran" class="form-control">
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="cash" <?= ($pembayaran['metode_pembayaran'] == 'cash') ? 'selected' : '' ?>>Cash
                    </option>
                    <option value="bank" <?= ($pembayaran['metode_pembayaran'] == 'bank') ? 'selected' : '' ?>>Bank
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah_bayar">Jumlah Bayar</label>
                <input type="text" id="jumlah_bayar" class="form-control"
                    value="Rp<?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>">
                <input type="hidden" name="jumlah_bayar_hidden" id="jumlah_bayar_hidden"
                    value="<?= $pembayaran['jumlah_bayar'] ?>">
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"><?= $pembayaran['keterangan'] ?></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Pembayaran
            </button>
        </form>
    </div>
</div>

<?php
include '../includes/footer.php';
include '../includes/modals.php';
include '../includes/scripts.php';
?>

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

<script>
const jumlah_cicilan_global = <?= $jumlah_cicilan ?>;
const sisa_cicilan_global = <?= $sisa_cicilan ?>;
const total_harga_global = <?= $total_harga ?>;


function formatRupiah(angka) {
    return 'Rp ' + parseFloat(angka).toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
}

//update validasi
document.addEventListener("DOMContentLoaded", function() {
    const field_bayar = document.getElementById("jumlah_bayar");
    if (field_bayar && field_bayar.value !== '') {
        validateBayar(field_bayar.value);
    }

    field_bayar.addEventListener("input", function() {
        validateBayar(field_bayar.value);
    });
});

function validateBayar(value) {
    console.log(value);
    //bersihkan format rupiah
    let numeric_value = value.replace(/[Rp\s.]/g, '').replace(',', '.');
    numeric_value = parseFloat(numeric_value);
    console.log('numeric vl', numeric_value);

    if (isNaN(numeric_value)) {
        document.getElementById("jumlah_bayar_hidden").value = '';
        return;
    }

    let error = '';

    if (numeric_value > sisa_cicilan_global) {
        error = 'Jumlah bayar tidak boleh melebihi sisa cicilan.';
    } else if (numeric_value > total_harga_global) {
        error = 'Jumlah bayar tidak boleh melebihi total harga.';
    } else if (numeric_value > jumlah_cicilan_global) {
        error = 'Jumlah bayar tidak boleh melebihi jumlah cicilan per bulan.';
    }

    if (error !== '') {
        alert(error);
        document.getElementById("jumlah_bayar").value = '';
        document.getElementById("jumlah_bayar_hidden").value = '';
    } else {
        document.getElementById("jumlah_bayar").value = formatRupiah(numeric_value);
        document.getElementById("jumlah_bayar_hidden").value = numeric_value;
    }
}


// function updateEditJumlahBayar() {
//     const kelipatan = parseInt(document.getElementById("kelipatan").value) || 1;
//     const total = jumlah_cicilan * kelipatan;

//     document.getElementById("jumlah_bayar").value = formatRupiah(total);
//     document.getElementById("jumlah_bayar_hidden").value = total;
// }
</script>