<?php

include "../../config/config.php";
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $query_tambah = "INSERT INTO tpelanggan VALUES (NULL,'$nama','$alamat','$no_telepon','$email','$tanggal_lahir')";
    $result_tambah = mysqli_query($conn, $query_tambah);

    if ($result_tambah) {
        $_SESSION['alertype_sukses_p'] = "success";
        $_SESSION['alertmessage_sukses_p'] = "Pelanggan berhasil ditambahkan!";
        header("Location: ../pelanggan.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_p'] = "danger";
        $_SESSION['alertmessage_gagal_p'] = "Gagal menambahkan pelanggan!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
