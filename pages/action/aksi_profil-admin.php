<?php

include '../../config/config.php';
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Jika ada perubahan password
    if (!empty($password)) {
        // $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update_user = mysqli_query($conn, "UPDATE tusers SET username='$username',password='$password',nama='$nama',alamat='$alamat' WHERE id_user='$id_user'");
    } else {
        // var_dump('masuk');
        // die;
        $update_user = mysqli_query($conn, "UPDATE tusers SET username='$username',nama='$nama',alamat='$alamat' WHERE id_user='$id_user'");
    }

    if ($update_user) {
        $_SESSION['alertype_sukses_s'] = "success";
        $_SESSION['alertmessage_sukses_s'] = "Profile berhasil diedit!";
        header("Location: ../profile-admin.php");
        exit();
    } else {
        $_SESSION['alertype_gagal_s'] = "danger";
        $_SESSION['alertmessage_gagal_s'] = "Gagal mengedit Profile!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
