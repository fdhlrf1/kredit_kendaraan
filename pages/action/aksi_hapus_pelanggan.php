<?php
include '../../config/config.php';
session_start();

if (isset($_GET['id_pelanggan'])) {
    $id_pelanggan = $_GET['id_pelanggan'];
    // var_dump($_GET);
    // die;

    $query = "DELETE FROM tpelanggan WHERE id_pelanggan=$id_pelanggan";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['alertype_sukses_p'] = "success";
        $_SESSION['alertmessage_sukses_p'] = "Pelanggan berhasil dihapus!";
        header("Location: ../pelanggan.php");
        exit(); // Pastikan untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        $_SESSION['alertype_gagal_p'] = "danger";
        $_SESSION['alertmessage_gagal_p'] = "Gagal menambahkan pelanggan!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} else {
    die("akses dilarang...");
}
