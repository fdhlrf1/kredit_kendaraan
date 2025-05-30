<?php

include '../../config/config.php';
session_start();

//Proses form ketika disubmit
if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_kredit = $_POST['id_kredit'];
    //ambil data dari form
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_kendaraan = $_POST['id_kendaraan'];
    // $harga_kendaraan = $_POST['harga_kendaraan'];
    $tanggal_pengajuan = date('Y-m-d');
    $jangka_waktu = $_POST['jangka_waktu'];
    $bunga_persen = $_POST['bunga_persen'];
    $total_bunga = $_POST['total_bunga'];
    $total_harga = $_POST['total_harga'];
    $jumlah_cicilan = $_POST['cicilan_per_bulan'];

    // var_dump($harga_kendaraan);
    // var_dump($total_bunga);
    // var_dump($total_harga);
    // var_dump($jumlah_cicilan);
    // die;

    // Jika nilai hidden input kosong, gunakan nilai dari database
    // if (empty($harga_kendaraan) || empty($total_bunga) || empty($total_harga) || empty($jumlah_cicilan)) {
    //     // Ambil data dari database
    //     $sql = "SELECT * FROM tkredit WHERE id_kredit='$id_kredit'";
    //     $query = mysqli_query($conn, $sql);
    //     $kredit = mysqli_fetch_assoc($query);

    //     // var_dump($kredit);

    //     // Gunakan nilai dari database jika input kosong
    //     $harga_kendaraan = empty($harga_kendaraan) ? $kredit['harga_kendaraan'] : $harga_kendaraan;
    //     $total_bunga = empty($total_bunga) ? $kredit['total_bunga'] : $total_bunga;
    //     $total_harga = empty($total_harga) ? $kredit['total_harga'] : $total_harga;
    //     $jumlah_cicilan = empty($jumlah_cicilan) ? $kredit['jumlah_cicilan'] : $jumlah_cicilan;
    // }

    try {
        $query = "UPDATE tkredit SET 
        id_pelanggan='$id_pelanggan',
        id_kendaraan='$id_kendaraan',
        tanggal_pengajuan='$tanggal_pengajuan',
        jangka_waktu='$jangka_waktu',
        bunga_persen='$bunga_persen',
        total_bunga='$total_bunga',
        total_harga='$total_harga',
        jumlah_cicilan='$jumlah_cicilan'
        WHERE id_kredit = '$id_kredit'";

        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            $_SESSION['alertype_sukses_k'] = 'success';
            $_SESSION['alertmessage_sukses_k'] = 'Pengajuan kredit berhasil diedit!';
            header("Location: ../kredit.php");
            exit();
        } else {
            throw new Exception("Query gagal dijalankan: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $_SESSION['alertype_gagal_k'] = 'danger';
        $_SESSION['alertmessage_gagal_k'] = 'Gagal mengedit Pengajuan Kredit! Error: ' . $e->getMessage();
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}