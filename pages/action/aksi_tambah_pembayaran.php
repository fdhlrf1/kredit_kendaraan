<?php

include "../../config/config.php";
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_kredit = $_POST['id_kredit'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar_hidden'];
    $keterangan = $_POST['keterangan'];
    $jumlah_bayar = round((float)$jumlah_bayar, 2);

    //ambil total harga/total kredit
    $query_kredit = "SELECT total_harga FROM tkredit WHERE id_kredit='$id_kredit'";
    $result_kredit = mysqli_query($conn, $query_kredit);
    $kredit = mysqli_fetch_assoc($result_kredit);
    $total_kredit = round((float)$kredit['total_harga'], 2);
    // var_dump($total_kredit);
    // die;

    //ambil jumlah bayar sebelumnya
    $query_bayar_sebelumnya = "SELECT SUM(jumlah_bayar) AS jumlah_bayar FROM tpembayaran WHERE id_kredit = '$id_kredit'";
    $result_bayar_sebelumnya = mysqli_query($conn, $query_bayar_sebelumnya);
    $pembayaran = mysqli_fetch_assoc($result_bayar_sebelumnya);
    $jumlah_bayar_sebelumnya = round((float)($pembayaran['jumlah_bayar'] ?? 0), 2);
    $jumlah_bayar_terbaru = round($jumlah_bayar_sebelumnya + $jumlah_bayar, 2);
    // var_dump($jumlah_bayar_terbaru);
    // die;

    // if (abs($jumlah_bayar_terbaru - $total_kredit) > 0.01) {
    //     $_SESSION['alertype_gagal'] = "danger";
    //     $_SESSION['alertmessage_gagal'] = "Jumlah pembayaran melebihi sisa cicilan!";
    //     header("Location: {$_SERVER['HTTP_REFERER']}");
    //     exit();
    // }


    //hitung sisa cicilan
    $sisa_cicilan = round($total_kredit - $jumlah_bayar_terbaru, 2);
    // var_dump('SISA CICILAN', $sisa_cicilan);
    // var_dump('TOTAL KREDIT', $total_kredit);
    // var_dump('JUMLAH BAYAR', $jumlah_bayar_terbaru);
    // if (abs($sisa_cicilan) < 0.01) {
    //     var_dump('oke');
    // }
    // die;

    // var_dump($pembayaran['jumlah_bayar']);
    // die;

    // var_dump($total_kredit);
    // die;

    // var_dump($jumlah_bayar_terbaru >= $total_kredit || $sisa_cicilan == 0);
    // die;

    //insert ke tpembayaran
    $query_pembayaran = "INSERT INTO tpembayaran VALUES (NULL,'$id_kredit','$tanggal_pembayaran','$metode_pembayaran','$jumlah_bayar','$sisa_cicilan','$keterangan')";
    $result_pembayaran = mysqli_query($conn, $query_pembayaran);

    if ($result_pembayaran) {

        //menentukan status di tkredit
        if (abs($sisa_cicilan) < 1) {
            $query_status = "UPDATE tkredit SET status = 'selesai' WHERE id_kredit = '$id_kredit'";
            $result_status =  mysqli_query($conn, $query_status);
        }

        $_SESSION['alertype_sukses_pn'] = "success";
        $_SESSION['alertmessage_sukses_pn'] = "Pembayaran berhasil dilakukan!";
        header("Location: ../detail_riwayat-pembayaran.php?id_kredit=$id_kredit");
        exit();
    } else {
        $_SESSION['alertype_gagal_pn'] = "danger";
        $_SESSION['alertmessage_gagal_pn'] = "Gagal melakukan Pembayaran!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}