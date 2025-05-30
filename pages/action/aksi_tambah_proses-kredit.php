<?php

include "../../config/config.php";
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_kredit = $_POST['id_kredit'];

    if (isset($_SESSION['id_staf'])) {
        $id_staff = $_SESSION['id_staf'];
    } else {
        $id_staff = "NULL";
    }

    // var_dump($id_staff);
    // die;
    // $id_staff = 2;

    $hasil = $_POST['hasil'];
    $keterangan = $_POST['keterangan'];
    $tanggal_proses = date('Y-m-d');

    //ambil id_kendaraan dari tkredit
    $query_kendaraan = "SELECT id_kendaraan FROM tkredit WHERE id_kredit = '$id_kredit'";
    $result_kendaraan = mysqli_query($conn, $query_kendaraan);
    $kendaraan = mysqli_fetch_assoc($result_kendaraan);
    $id_kendaraan = $kendaraan['id_kendaraan'];

    //cek stok kendaraan
    $query_stok = "SELECT stok FROM tkendaraan WHERE id_kendaraan = '$id_kendaraan'";
    $result_stok = mysqli_query($conn, $query_stok);
    $stok = mysqli_fetch_assoc($result_stok);

    if ($stok['stok'] <= 0) {
        $_SESSION['alertype_gagal_pk'] = 'danger';
        $_SESSION['alertmessage_gagal_pk'] = 'Stok kendaraan habis. Tidak bisa disetujui.';
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $query_proses = "INSERT INTO tproseskredit VALUES (NULL,'$id_kredit',$id_staff,'$tanggal_proses','$hasil','$keterangan')";
    // var_dump($query_proses);
    // die;
    $result_proses = mysqli_query($conn, $query_proses);

    if ($result_proses) {

        if ($hasil == 'disetujui') {
            $status = 'sedang_berjalan';
            //kurangi stok
            $query_update_stok = "UPDATE tkendaraan SET stok = stok - 1 WHERE id_kendaraan = '$id_kendaraan'";
            mysqli_query($conn, $query_update_stok);
        } else {
            $status = 'gagal';
        }

        $query_kredit = "UPDATE tkredit SET status='$status' WHERE id_kredit='$id_kredit'";
        $result_kredit = mysqli_query($conn, $query_kredit);

        if ($result_kredit) {
            $_SESSION['alertype_sukses_pk'] = "success";
            $_SESSION['alertmessage_sukses_pk'] = "Proses Kredit berhasil dilakukan!";
            header("Location: ../proses-kredit.php");
            exit();

            $_SESSION['alertype_gagal_pk'] = "danger";
            $_SESSION['alertmessage_gagal_pk'] = "Proses Kredit gagal dilakukan!";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }
}
