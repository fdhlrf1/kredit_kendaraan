<?php

include '../../config/config.php';
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_kendaraan = $_POST['id_kendaraan'];
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $tipe = $_POST['tipe'];

    $query = "UPDATE tkendaraan SET merk='$merk',model='$model',tahun='$tahun',harga='$harga',tipe='$tipe',stok='$stok' WHERE id_kendaraan = '$id_kendaraan'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alertype_sukses_kd'] = "success";
        $_SESSION['alertmessage_sukses_kd'] = "Kendaraan berhasil diedit!";
        header("Location: ../kendaraan.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_kd'] = "danger";
        $_SESSION['alertmessage_gagal_kd'] = "Gagal mengedit Kendaraan!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
