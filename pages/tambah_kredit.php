<?php
$pageTitle = 'Kredit Kendaraan - Tambah Kredit';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'tambah-kredit';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<!-- Custom styles for this page -->
<link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-900">Pengajuan Kredit Kendaraan</h1>
<p class="mb-4">Silahkan isi form berikut untuk mengajukan kredit kendaraan baru.</p>

<!-- Alert Gagal -->
<?php
if (isset($_SESSION['alertype_gagal_k']) && isset($_SESSION['alertmessage_gagal_k'])) {
    $alertype_gagal_k = $_SESSION['alertype_gagal_k'];
    $alertmessage_gagal_k = $_SESSION['alertmessage_gagal_k'];
?>
<div class="alert alert-<?= $alertype_gagal_k ?> alert-dismissible fade show" role="alert">
    <?= $alertmessage_gagal_k ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
    unset($_SESSION['alertype_gagal_k']);
    unset($_SESSION['alertmessage_gagal_k']);
}
?>


<!-- Form Pengajuan Kredit -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Kredit</h6>
    </div>
    <div class="card-body">
        <form action="action/aksi_tambah_kredit.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_pelanggan">Pelanggan</label>
                        <select class="form-control select2" id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php
                            $sql = "SELECT * FROM tpelanggan";
                            $query = mysqli_query($conn, $sql);
                            while ($pelanggan = mysqli_fetch_array($query)) {
                                echo "<option value='{$pelanggan['id_pelanggan']}'>{$pelanggan['nama']} - {$pelanggan['no_telepon']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <a href="tambah_pelanggan.php" class="btn btn-sm btn-info">
                            <i class="fas fa-plus"></i> Tambah Pelanggan Baru
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_kendaraan">Kendaraan</label>
                        <select class="form-control select2" id="id_kendaraan" name="id_kendaraan" required
                            onchange="updateHarga()">
                            <option value="">-- Pilih Kendaraan --</option>
                            <?php
                            $sql = "SELECT * FROM tkendaraan WHERE stok > 0";
                            $query = mysqli_query($conn, $sql);
                            while ($kendaraan = mysqli_fetch_array($query)) {
                                echo "<option value='{$kendaraan['id_kendaraan']}' data-harga=\"{$kendaraan['harga']}\">{$kendaraan['merk']} {$kendaraan['model']} ({$kendaraan['tahun']}) - Rp " . number_format($kendaraan['harga'], 0, ',', '.') . " - " . ucfirst($kendaraan['tipe']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="harga_kendaraan">Harga Kendaraan (Rp)</label>
                        <input type="text" class="form-control" id="harga_kendaraan" readonly>
                        <input type="hidden" id="harga_kendaraan_hidden" name="harga_kendaraan">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jangka_waktu">Jangka Waktu per (bulan)</label>
                        <select class="form-control select2" id="jangka_waktu" name="jangka_waktu" required
                            onchange="hitungCicilan()">
                            <option value="">-- Pilih Jangka Waktu --</option>
                            <option value="6">6 Bulan</option>
                            <option value="12">12 Bulan (1 Tahun)</option>
                            <option value="24">24 Bulan (2 Tahun)</option>
                            <option value="36">36 Bulan (3 Tahun)</option>
                            <option value="48">48 Bulan (4 Tahun)</option>
                            <option value="60">60 Bulan (5 Tahun)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bunga_persen">Bunga (%)</label>
                        <input type="number" class="form-control" id="bunga_persen" name="bunga_persen" step="0.01"
                            min="0" max="100" required oninput="hitungCicilan()">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total_bunga">Total Bunga (Rp)</label>
                        <input type="text" class="form-control" id="total_bunga" readonly>
                        <input type="hidden" id="total_bunga_hidden" name="total_bunga">
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- <div class="form-group">
                        <label for="id_staf">Staff yang Menangani</label>
                        <select class="form-control select2" id="id_staf" name="id_staf" required>
                            <option value="">-- Pilih Staff --</option>
                            <?php
                            // $sql = "SELECT * FROM tstaf ORDER BY nama ASC";
                            // $query = mysqli_query($conn, $sql);
                            // while ($staf = mysqli_fetch_array($query)) {
                            //     echo "<option value='" . $staf['id_staf'] . "'>" . $staf['nama'] . " - " . $staf['jabatan'] . "</option>";
                            // }
                            ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="total_harga">Total Harga (Rp)</label>
                        <input type="text" class="form-control" id="total_harga" readonly>
                        <input type="hidden" id="total_harga_hidden" name="total_harga">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cicilan_per_bulan">Cicilan per Bulan (Rp)</label>
                        <input type="text" class="form-control" id="cicilan_per_bulan" readonly>
                        <input type="hidden" id="cicilan_per_bulan_hidden" name="cicilan_per_bulan">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Pengajuan
                </button>
                <a href="kredit.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
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
<!-- Page level plugins -->
<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="../assets/vendor/select2/dist/js/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/js/datatable-config/datatables-kredit-terbaru.js"></script>

<script>
$(document).ready(function() {
    //inisialisasi Select2
    $('.select2').select2({
        placeholder: "Pilih data",
        allowClear: true
    });

    // inisialisasi DataTable
    $('#dataTable').DataTable();
});

//fungsi untuk memformat angka sebagai mata uang
function formatRupiah(angka) {
    return 'Rp ' + parseFloat(angka).toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
}

//fungsi untuk update harga berdasarkan kendaraan yang dipilih
function updateHarga() {
    //mengambil kendaraan
    var select = document.getElementById('id_kendaraan');
    //mengambil index dari option
    var option = select.options[select.selectedIndex];

    if (option && option.value !== '') {
        var harga = option.getAttribute('data-harga');
        document.getElementById('harga_kendaraan').value = formatRupiah(harga);
        document.getElementById('harga_kendaraan_hidden').value = harga;
        hitungCicilan();
    } else {
        document.getElementById('harga_kendaraan').value = '';
        document.getElementById('harga_kendaraan_hidden').value = '';
        document.getElementById('cicilan_per_bulan').value = '';
    }
}

// Fungsi untuk menghitung cicilan per bulan
function hitungCicilan() {
    var harga_kendaraan = document.getElementById('harga_kendaraan_hidden').value;
    console.log('harga_kendaraan', harga_kendaraan);
    var jangka_waktu = document.getElementById('jangka_waktu').value;
    console.log('jangka_waktu', jangka_waktu);
    var bunga_persen = document.getElementById('bunga_persen').value;
    console.log('bunga_persen', bunga_persen);

    //validasi jika bunga persen minus
    if (bunga_persen < 0) {
        alert('Bunga persen tidak boleh minus');
        document.getElementById('bunga_persen').value = '';
        document.getElementById('total_bunga').value = '';
        document.getElementById('total_harga').value = '';
        document.getElementById('cicilan_per_bulan').value = '';
        return;
    }

    if (harga_kendaraan && jangka_waktu && bunga_persen) {
        // Konversi ke angka
        harga_kendaraan = parseFloat(harga_kendaraan);
        jangka_waktu = parseInt(jangka_waktu);
        bunga_persen = parseFloat(bunga_persen);

        // Hitung 
        // var total_bunga = harga_kendaraan * (bunga_persen / 100);
        // var total_harga = harga_kendaraan + total_bunga;
        // var cicilan_per_bulan = total_harga / jangka_waktu;
        var total_bunga = parseFloat((harga_kendaraan * (bunga_persen / 100)).toFixed(2));
        var total_harga = parseFloat((harga_kendaraan + total_bunga).toFixed(2));
        var cicilan_per_bulan = parseFloat((total_harga / jangka_waktu).toFixed(2));


        console.log('ttl bunga', total_bunga);
        console.log('ttl harga', total_harga);
        console.log('ttl cicilan', cicilan_per_bulan);

        document.getElementById('total_bunga').value = formatRupiah(total_bunga);
        document.getElementById('total_harga').value = formatRupiah(total_harga);
        document.getElementById('cicilan_per_bulan').value = formatRupiah(cicilan_per_bulan);
        document.getElementById('total_bunga_hidden').value = total_bunga;
        document.getElementById('total_harga_hidden').value = total_harga;
        document.getElementById('cicilan_per_bulan_hidden').value = cicilan_per_bulan;
    } else {
        document.getElementById('total_bunga').value = '';
        document.getElementById('total_harga').value = '';
        document.getElementById('cicilan_per_bulan').value = '';
    }
}
</script>