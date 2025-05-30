<?php
include '../../config/config.php';
session_start();

if (isset($_GET['id_staf'])) {
    $id_staf = $_GET['id_staf'];
    // var_dump($_GET);
    // die;

    //hapus juga akun users nya
    $query_staf = "SELECT * FROM tstaf WHERE id_staf='$id_staf'";
    $result_staf = mysqli_query($conn, $query_staf);
    $staf = mysqli_fetch_assoc($result_staf);
    $id_user = $staf['id_user'];

    $query_users = "DELETE FROM tusers WHERE id_user='$id_user'";
    $result_users = mysqli_query($conn, $query_users);

    if ($result_users) {
        // $query = "DELETE FROM tstaf WHERE id_staf=$id_staf";
        // $result = mysqli_query($conn, $query);

        $_SESSION['alertype_sukses_s'] = "success";
        $_SESSION['alertmessage_sukses_s'] = "Staff berhasil dihapus!";
        header("Location: ../staff.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_s'] = "danger";
        $_SESSION['alertmessage_gagal_s'] = "Gagal menambahkan Staff!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
} else {
    die("akses dilarang...");
}
