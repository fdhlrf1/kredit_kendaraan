<?php

include "../../config/config.php";
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    //staff
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    //users
    $username = $_POST['username'];
    $password = $_POST['password'];

    //cek USERNAME
    $query_cek_username = "SELECT * FROM tusers WHERE username = '$username'";
    $result_cek_username = mysqli_query($conn, $query_cek_username);
    if (mysqli_num_rows($result_cek_username) > 0) {
        $_SESSION['alertype_gagal_s'] = "danger";
        $_SESSION['alertmessage_gagal_s'] = "Username sudah digunakan, silakan pilih username lain.";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //insert ke tabel users dulu
    $query_user = "INSERT INTO tusers VALUES (NULL,'$username','$password',NULL,NULL,'staff')";
    $result_user = mysqli_query($conn, $query_user);

    if ($result_user) {
        $id_user = mysqli_insert_id($conn);
        // var_dump($id_user);
        // die;
        //masukan ke tabel staff
        $query_staf = "INSERT INTO tstaf VALUES (NULL,'$id_user','$nama','$jabatan','$no_telepon','$email')";
        $result_staf = mysqli_query($conn, $query_staf);

        if ($result_staf) {
            $_SESSION['alertype_sukses_s'] = "success";
            $_SESSION['alertmessage_sukses_s'] = "Staff berhasil ditambahkan!";
            header("Location: ../staff.php");
            exit();
        } else {
            $_SESSION['alertype_gagal_s'] = "danger";
            $_SESSION['alertmessage_gagal_ss'] = "Gagal menambahkan Staff!";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }
}
