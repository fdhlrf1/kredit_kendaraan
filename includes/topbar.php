<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari disini..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form> -->

            <?php
            include '../config/config.php';

            $id_user = $_SESSION['id_user'] ?? '';
            $id_staf = $_SESSION['id_staf'] ?? '';
            $role = $_SESSION['role'] ?? '';

            if ($role == 'admin') {
                $query_admin = "SELECT * FROM tusers WHERE id_user = '$id_user'";
                $execute_admin = mysqli_query($conn, $query_admin);
                $data_admin = mysqli_fetch_assoc($execute_admin);
            } else if ($role == 'staff') {
                $query_staf_profile = "SELECT * FROM tstaf WHERE id_staf = '$id_staf'";
                $execute_staf_profile = mysqli_query($conn, $query_staf_profile);
                $data_staf_profile = mysqli_fetch_assoc($execute_staf_profile);

                $id_user_staf = $data_staf_profile['id_user'];

                $query_staf_akun = "SELECT * FROM tusers WHERE id_user = '$id_user_staf'";
                $execute_staf_akun = mysqli_query($conn, $query_staf_akun);
                $data_staf_akun = mysqli_fetch_assoc($execute_staf_akun);
            }

            ?>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-800 small">
                            <?php
                            if ($_SESSION['role'] == 'admin' && isset($data_admin['username'])) {
                                echo $data_admin['username'];
                            } elseif ($_SESSION['role'] == 'staff' && isset($data_staf_akun['username'])) {
                                echo $data_staf_akun['username'];
                            }
                            ?>
                            <img class="img-profile rounded-circle" src="../assets/img/user.png">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">

                        <div class="dropdown-item text-center">
                            <strong>Profil Pengguna</strong>
                        </div>
                        <div class="dropdown-divider"></div>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Nama:</strong>
                                <span><?= $data_admin['nama'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Alamat:</strong>
                                <span><?= $data_admin['alamat'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Username:</strong>
                                <span><?= $data_admin['username'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Role:</strong>
                                <span><?= $data_admin['role'] ?></span>
                            </div>

                        <?php endif; ?>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'staff') : ?>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Nama:</strong>
                                <span><?= $data_staf_profile['nama'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Jabatan:</strong>
                                <span><?= $data_staf_profile['jabatan'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>No. Telepon:</strong>
                                <span><?= $data_staf_profile['no_telepon'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Email:</strong>
                                <span><?= $data_staf_profile['email'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Username:</strong>
                                <span><?= $data_staf_akun['username'] ?></span>
                            </div>

                            <div class="px-4 py-1 justify-content-between">
                                <strong>Role:</strong>
                                <span><?= $data_staf_akun['role'] ?></span>
                            </div>

                        <?php endif; ?>

                        <div class="dropdown-divider"></div>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                            <a class="dropdown-item" href="../pages/profile-admin.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Edit Profile
                            </a>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'staff') : ?>
                            <a class="dropdown-item" href="../pages/profile-staf.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Edit Profile
                            </a>
                        <?php endif; ?>


                        <!-- <div class="dropdown-divider"></div> -->
                        <div class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </div>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">