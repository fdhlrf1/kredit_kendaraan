<?php
include '../../config/config.php';
session_start();

if (isset($_GET['id_kendaraan'])) {
    $id_kendaraan = $_GET['id_kendaraan'];
    // var_dump($_GET);
    // die;

    $query = "DELETE FROM tkendaraan WHERE id_kendaraan=$id_kendaraan";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alertype_sukses_kd'] = "success";
        $_SESSION['alertmessage_sukses_kd'] = "Kendaraan berhasil dihapus!";
        header("Location: ../kendaraan.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_kd'] = "danger";
        $_SESSION['alertmessage_gagal_kd'] = "Gagal menambahkan Kendaraan! Error: " . mysqli_error($conn);
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} else {
    die("akses dilarang...");
}
