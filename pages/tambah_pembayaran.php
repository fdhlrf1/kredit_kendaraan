<?php
$pageTitle = 'Kredit Kendaraan - Tambah Pembayaran';
session_start();

include '../config/config.php';
include '../includes/header.php';
$active_page = 'tambah-pembayaran';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-900 border-bottom border-color:text-gray-900 pb-2">Input Pembayaran Cicilan</h1>

<!-- Form Input Pembayaran -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pembayaran Kredit</h6>
    </div>
    <div class="card-body">
        <form action="action/aksi_tambah_pembayaran.php" method="POST">
            <div class="form-group">
                <label for="id_kredit">Pilih Kredit (Sedang Berjalan)</label>
                <select id="id_kredit" name="id_kredit" class="form-control select2" required
                    onchange="updateInvoice()">
                    <option value="">-- Pilih Kredit --</option>
                    <?php
                    // Ambil data kredit yang sedang berjalan
                    $query = mysqli_query($conn, "SELECT k.id_kredit, p.nama, k.total_harga, k.jumlah_cicilan, k.jangka_waktu
                        FROM tkredit k
                        JOIN tpelanggan p ON p.id_pelanggan = k.id_pelanggan
                        WHERE k.status = 'sedang_berjalan'");
                    while ($row = mysqli_fetch_assoc($query)) {
                        // ambil sisa cicilan
                        $id_kredit = $row['id_kredit'];
                        $bayar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah_bayar) as total_bayar FROM tpembayaran WHERE id_kredit = '$id_kredit'"));
                        $total_bayar = $bayar['total_bayar'] ?? 0;

                        $sisa_cicilan = $row['total_harga'] - $total_bayar;
                        if ($sisa_cicilan < 0) $sisa_cicilan = 0;

                        echo "<option value='{$row['id_kredit']}' data-jumlah_cicilan='{$row['jumlah_cicilan']}' data-sisa='{$sisa_cicilan}' data-jangka_waktu='{$row['jangka_waktu']}' data-total_harga={$row['total_harga']}>
                            #{$row['id_kredit']} - {$row['nama']} - Total: Rp" . number_format($row['total_harga']) . "
                        </option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="total_harga">Total Harga</label>
                <input id="total_harga" type="text" class="form-control" name="total_harga" readonly>
            </div>

            <div class="form-group">
                <label for="jumlah_cicilan">Jumlah Cicilan per (Bulan)</label>
                <input id="jumlah_cicilan" type="text" class="form-control" name="jumlah_cicilan" readonly>
            </div>

            <div class="form-group">
                <label for="sisa_cicilan">Sisa Cicilan Saat Ini</label>
                <input id="sisa_cicilan" type="text" class="form-control" name="sisa_cicilan" readonly>
            </div>

            <div class="form-group">
                <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                <input type="date" class="form-control" name="tanggal_pembayaran" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" name="metode_pembayaran" class="form-control">
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="cash">Cash</option>
                    <option value="bank">Bank</option>
                </select>
            </div>


            <div class="form-group">
                <label for="jumlah_bayar">Jumlah Bayar</label>
                <input id="jumlah_bayar" type="text" class="form-control" name="jumlah_bayar" required>
                <input type="hidden" id="jumlah_bayar_hidden" name="jumlah_bayar_hidden">
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2"></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Pembayaran
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
    let jumlah_cicilan_global = 0;
    let sisa_cicilan_global = 0;
    let total_harga_global = 0;


    function formatRupiah(angka) {
        return 'Rp ' + parseFloat(angka).toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
    }

    //fungsi untuk update INVOICE berdasarkan kredit yang dipilih
    function updateInvoice() {
        const select = document.getElementById('id_kredit');
        const option = select.options[select.selectedIndex];

        if (option && option.value !== '') {
            const jumlah_cicilan = parseFloat(option.getAttribute("data-jumlah_cicilan"));
            const sisa_cicilan = parseFloat(option.getAttribute("data-sisa"));
            const total_harga = parseFloat(option.getAttribute("data-total_harga"));
            // const jangka_waktu = option.getAttribute("data-jangka_waktu");
            console.log('ttl', total_harga);
            console.log('ccl', jumlah_cicilan);
            console.log('ssc', sisa_cicilan);

            jumlah_cicilan_global = jumlah_cicilan;
            sisa_cicilan_global = sisa_cicilan;
            total_harga_global = total_harga;

            document.getElementById("total_harga").value = formatRupiah(total_harga);
            document.getElementById("jumlah_cicilan").value = formatRupiah(jumlah_cicilan);
            document.getElementById("sisa_cicilan").value = formatRupiah(sisa_cicilan);

            //reset bayar field
            document.getElementById("jumlah_bayar").value = '';
            document.getElementById("jumlah_bayar_hidden").value = '';

        } else {
            jumlah_cicilan_global = 0;
            sisa_cicilan_global = 0;
            total_harga_global = 0;

            document.getElementById("total_harga").value = '';
            document.getElementById("jumlah_bayar_hidden").value = '';
            document.getElementById("jumlah_cicilan").value = '';
            document.getElementById("sisa_cicilan").value = '';
        }
    }


    document.getElementById("jumlah_bayar").addEventListener("input", function() {
        validateBayar(this.value);
    });


    function validateBayar(value) {
        //bersihkan format rupiah
        let numeric_value = value.replace(/[Rp\s.]/g, '').replace(',', '.');
        numeric_value = parseFloat(numeric_value);

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

    // function updateJumlahBayar() {
    //     const kelipatan = parseInt(document.getElementById("kelipatan").value) || 1;
    //     // const total_bayar = jumlah_cicilan_global * kelipatan;
    //     const total_bayar = parseFloat((jumlah_cicilan_global * kelipatan).toFixed(2));

    //     document.getElementById("jumlah_bayar").value = formatRupiah(total_bayar.toString());
    //     document.getElementById("jumlah_bayar_hidden").value = total_bayar;
    // }
</script>