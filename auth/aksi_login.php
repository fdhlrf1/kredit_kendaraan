<?php
// menghubungkan ke database
include '../config/config.php';
session_start();

if (isset($_POST['login'])) {
    // menerima data yang di inputkan pada form login dan melakukan sanitasi
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // var_dump($_POST);
    // die;

    // membuat query login berdasarkan username
    $query = "SELECT * FROM tusers WHERE username='$username'";
    $login = mysqli_query($conn, $query);

    $cek = mysqli_num_rows($login);
    //kalau misal benar return 1
    //kalau salah return ke 0

    // cek username ada di table database atau tidak
    if ($cek == 1) {
        // Ambil data user dari hasil query
        $data = mysqli_fetch_assoc($login);
        // cek password benar 
        if ($password === $data['password']) {
            //nama session = user
            // $_SESSION['user'] = $data;
            if ($data['role'] == 'admin') {
                $_SESSION['alert_welcome'] = "success";
                $_SESSION['alert_welcome_message'] = "Halo Selamat Datang <b>" . $data['username'] . "</b>,  Hak Akses anda : <b>" . ucfirst($data['role']) . "</b>";

                $_SESSION['username'] = $data['username'];
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['role'] = $data['role'];
                header("Location: ../pages/dashboard.php");
                exit(); // Pastikan untuk menghentikan eksekusi skrip setelah melakukan redirect
            } else if ($data['role'] == 'staff') {
                $_SESSION['alert_welcome'] = "success";
                $_SESSION['alert_welcome_message'] = "Halo Selamat Datang <b>" . $data['username'] . "</b>,  Hak Akses anda : <b>" . ucfirst($data['role']) . "</b>";

                //ambil id staff
                $id_user = $data['id_user'];
                $query_staff = "SELECT * FROM tstaf WHERE id_user='$id_user'";
                $result_staff = mysqli_query($conn, $query_staff);
                $staff = mysqli_fetch_assoc($result_staff);
                // var_dump($staff['id_staf']);
                // die;
                $_SESSION['id_staf'] = $staff['id_staf'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['role'] = $data['role'];
                header("Location: ../pages/dashboard.php");
                exit();
            } else {
                echo "akses tidak ada";
            }
        } else {
            $_SESSION['alert_login'] = "danger";
            $_SESSION['alert_login_message'] = "Password Salah";
        }
    } else {
        $_SESSION['alert_login'] = "danger";
        $_SESSION['alert_login_message'] = "Username tidak ditemukan";
    }

    // Redirect kembali ke halaman login setelah menetapkan pesan alert
    header("Location: ../index.php");
    exit();
}
