<?php

include '../../config/config.php';
session_start();

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // die;
    $id_staf = $_POST['id_staf'];
    $id_user = $_POST['id_user'];
    // var_dump($id_staf);
    // die;
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];
    //users
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE tstaf SET nama='$nama',jabatan='$jabatan',no_telepon='$no_telepon',email='$email' WHERE id_staf = '$id_staf'";
    $result = mysqli_query($conn, $query);
    // var_dump($result);
    // die;

    if ($result) {
        // Jika ada perubahan password
        if (!empty($password)) {
            // $hashed = password_hash($password, PASSWORD_DEFAULT);
            $update_user = mysqli_query($conn, "UPDATE tusers SET username='$username',password='$password' WHERE id_user='$id_user'");
        } else {
            // var_dump('masuk');
            // die;
            $update_user = mysqli_query($conn, "UPDATE tusers SET username='$username' WHERE id_user='$id_user'");
        }

        if ($update_user) {
            $_SESSION['alertype_sukses_s'] = "success";
            $_SESSION['alertmessage_sukses_s'] = "Staff berhasil diedit!";
            header("Location: ../staff.php");
            exit();
        } else {
            $_SESSION['alertype_gagal_s'] = "danger";
            $_SESSION['alertmessage_gagal_s'] = "Gagal mengedit Staff!";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }
}
