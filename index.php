<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Kredit Kendaraan">
    <meta name="author" content="">

    <title>Kredit Kendaraan - Login</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<link rel="stylesheet" href="assets/css/style.css">

<body class="bg-gradient-primary">

    <div class="container">
        <!-- App Title -->
        <div class="row justify-content-center mt-5">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <h1 class="h1 text-white text-center font-weight-bold">Kredit Kendaraan</h1>
            </div>
        </div>

        <!-- <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle"></i></strong>
            <?= $alert_login_message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> -->

        <!-- ALERT DANGER USERNAME ATAU PASSWORD SALAH -->
        <?php
        if (isset($_SESSION['alert_login']) && isset($_SESSION['alert_login_message'])) {
            $alert_login = $_SESSION['alert_login'];
            $alert_login_message = $_SESSION['alert_login_message'];
        ?>
            <div class="alert alert-<?= $alert_login ?> alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i></strong>
                <?= $alert_login_message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
            unset($_SESSION['alert_login']);
            unset($_SESSION['alert_login_message']);
        }
        ?>


        <!-- Login Form -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-4">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                            </div>


                            <form class="user" method="POST" action="auth/aksi_login.php">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="username"
                                        name="username" placeholder="Masukkan Username...">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password"
                                        name="password" placeholder="Password">
                                </div>

                                <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <hr>
                            <div class="text-center text-gray-900">
                                <small>&copy; Kredit Kendaraan 2025</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>