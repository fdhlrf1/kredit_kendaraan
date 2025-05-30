<?php

include "../../config/config.php";
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_kredit = $_POST['id_kredit'];
    $id_pembayaran = $_POST['id_pembayaran'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar_hidden'];
    $keterangan = $_POST['keterangan'];
    $jumlah_bayar = round((float)$jumlah_bayar, 2);

    //ambil total harga/total kredit
    $query_kredit = "SELECT total_harga FROM tkredit WHERE id_kredit='$id_kredit'";
    $result_kredit = mysqli_query($conn, $query_kredit);
    $kredit = mysqli_fetch_assoc($result_kredit);
    // $total_kredit = $kredit['total_harga'];
    $total_kredit = round((float)$kredit['total_harga'], 2);
    // var_dump($total_kredit);
    // die;

    //ambil jumlah bayar sebelumnya
    $query_bayar_sebelumnya = "SELECT SUM(jumlah_bayar) AS jumlah_bayar 
                                FROM tpembayaran 
                                WHERE id_kredit = '$id_kredit'
                                AND id_pembayaran != '$id_pembayaran'";
    $result_bayar_sebelumnya = mysqli_query($conn, $query_bayar_sebelumnya);
    $pembayaran = mysqli_fetch_assoc($result_bayar_sebelumnya);
    // $jumlah_bayar_sebelumnya = $pembayaran['jumlah_bayar'] ?? 0;
    // $jumlah_bayar_terbaru = $jumlah_bayar_sebelumnya + $jumlah_bayar;
    $jumlah_bayar_sebelumnya = round((float)($pembayaran['jumlah_bayar'] ?? 0), 2);
    $jumlah_bayar_terbaru = round($jumlah_bayar_sebelumnya + $jumlah_bayar, 2);
    // var_dump($jumlah_bayar_terbaru);
    // die;

    // if ($jumlah_bayar_terbaru > $total_kredit) {
    //     $_SESSION['alertype_gagal_pn'] = "danger";
    //     $_SESSION['alertmessage_gagal_pn'] = "Jumlah pembayaran melebihi sisa cicilan!";
    //     header("Location: {$_SERVER['HTTP_REFERER']}");
    //     exit();
    // }



    //hitung sisa cicilan
    // $sisa_cicilan = $total_kredit - $jumlah_bayar_terbaru;
    $sisa_cicilan = round($total_kredit - $jumlah_bayar_terbaru, 2);
    // var_dump($sisa_cicilan);
    // die;

    // var_dump($pembayaran['jumlah_bayar']);
    // die;

    // var_dump($total_kredit);
    // die;

    // var_dump($jumlah_bayar_terbaru >= $total_kredit || $sisa_cicilan == 0);
    // die;

    //insert ke tpembayaran
    $query_pembayaran = "UPDATE tpembayaran SET 
                        tanggal_pembayaran = '$tanggal_pembayaran', 
                        metode_pembayaran = '$metode_pembayaran',
                        jumlah_bayar = '$jumlah_bayar', 
                        sisa_cicilan = '$sisa_cicilan', 
                        keterangan = '$keterangan' 
                    WHERE id_pembayaran = '$id_pembayaran'";
    $result_pembayaran = mysqli_query($conn, $query_pembayaran);

    if ($result_pembayaran) {
        //ambil semua pembayaran dari awal, urutkan berdasarkan tanggal dan id
        //untuk menghitung ulang sisa_cicilan setiap ada perubahan
        $query_all_pembayaran = "SELECT * FROM tpembayaran 
                             WHERE id_kredit = '$id_kredit' 
                             ORDER BY tanggal_pembayaran ASC, id_pembayaran ASC";
        $result_all_pembayaran = mysqli_query($conn, $query_all_pembayaran);

        $sisa = $total_kredit; //awalnya total kredit
        while ($row = mysqli_fetch_assoc($result_all_pembayaran)) {
            $id_p = $row['id_pembayaran'];
            $jumlah = round((float)$row['jumlah_bayar'], 2);
            $sisa -= $jumlah;
            if ($sisa < 0) $sisa = 0;

            // Update sisa_cicilan berdasarkan urutan terbaru
            $update_sisa = "UPDATE tpembayaran SET sisa_cicilan = '$sisa' WHERE id_pembayaran = '$id_p'";
            mysqli_query($conn, $update_sisa);
        }


        //menentukan status di tkredit
        if ($sisa == 0) {
            $status = 'selesai';
        } else {
            $status = 'sedang_berjalan';
        }

        $query_status = "UPDATE tkredit SET status = '$status' WHERE id_kredit = '$id_kredit'";
        $result_status =  mysqli_query($conn, $query_status);

        $_SESSION['alertype_sukses_pn'] = "success";
        $_SESSION['alertmessage_sukses_pn'] = "Pembayaran berhasil diedit!";
        header("Location: ../detail_riwayat-pembayaran.php?id_kredit=$id_kredit");
        exit();
    } else {
        $_SESSION['alertype_gagal_pn'] = "danger";
        $_SESSION['alertmessage_gagal_pn'] = "Gagal melakukan edit Pembayaran!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}