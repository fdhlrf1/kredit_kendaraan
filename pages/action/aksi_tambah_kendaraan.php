<?php

include "../../config/config.php";
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $tipe = $_POST['tipe'];

    $query_tambah = "INSERT INTO tkendaraan VALUES (NULL,'$merk','$model','$tahun','$harga','$stok','$tipe')";
    $result_tambah = mysqli_query($conn, $query_tambah);

    if ($result_tambah) {
        $_SESSION['alertype_sukses_kd'] = "success";
        $_SESSION['alertmessage_sukses_kd'] = "Kendaraan berhasil ditambahkan!";
        header("Location: ../kendaraan.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_kd'] = "danger";
        $_SESSION['alertmessage_gagal_kd'] = "Gagal menambahkan Kendaraan!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
