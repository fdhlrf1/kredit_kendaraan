<?php

include '../../config/config.php';
session_start();

$pesan = '';
$sukses = false;

//Proses form ketika disubmit
if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
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
    $status = 'menunggu';

    try {
        $query = "INSERT INTO tkredit VALUES (NULL,'$id_pelanggan','$id_kendaraan','$tanggal_pengajuan','$jangka_waktu','$bunga_persen','$total_bunga','$total_harga','$jumlah_cicilan','$status')";
        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            $_SESSION['alertype_sukses_k'] = 'success';
            $_SESSION['alertmessage_sukses_k'] = 'Pengajuan kredit berhasil disimpan!';
            header("Location: ../kredit.php");
            exit();
        } else {
            // var_dump('masuk kesini');
            // die;
            throw new Exception("Query gagal dijalankan: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $_SESSION['alertype_gagal_k'] = 'danger';
        $isi = $_SESSION['alertmessage_gagal_k'] = "Gagal menambahkan Pengajuan Kredit! Error: " . $e->getMessage();
        // var_dump($isi);
        // die;
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}