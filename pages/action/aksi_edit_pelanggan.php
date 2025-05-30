<?php

include '../../config/config.php';
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $query = "UPDATE tpelanggan SET nama='$nama',alamat='$alamat',no_telepon='$no_telepon',email='$email',tanggal_lahir='$tanggal_lahir' WHERE id_pelanggan = '$id_pelanggan'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alertype_sukses_p'] = "success";
        $_SESSION['alertmessage_sukses_p'] = "Pelanggan berhasil diedit!";
        header("Location: ../pelanggan.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_p'] = "danger";
        $_SESSION['alertmessage_gagal_p'] = "Gagal mengedit pelanggan!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
