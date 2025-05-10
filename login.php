<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>LOGIN</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/assets_admin/vendors/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/assets_admin/vendors/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/assets_admin/vendors/images/favicon-16x16.png">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="assets/assets_admin/vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="assets/assets_admin/vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="assets/assets_admin/vendors/styles/style.css">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-119386393-1');
    </script>
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="index.php">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="index.php">Kembali Ke Beranda</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="assets/assets_admin/vendors/images/login-page-img.png" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login</h2>
                        </div>
                        <form method="post">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" placeholder="Masukkan Email Anda" name="email">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********" name="password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button type="submit" name="simpan" value="simpan" class="btn btn-block btn-primary float-end btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST["simpan"])) {
                            $email = $_POST["email"];
                            $password = $_POST["password"];
                            $ambil = $koneksi->query("SELECT * FROM akun
		WHERE email='$email' AND password='$password'");
                            $akunyangcocok = $ambil->num_rows;
                            if ($akunyangcocok >= 1) {
                                $akun = $ambil->fetch_assoc();
                                if ($akun['role'] == "Peserta") {
                                    $_SESSION["akun"] = $akun;
                                    echo "<script> alert('Anda sukses login sebagai peserta');</script>";
                                    echo "<script> location ='index.php';</script>";
                                } else {
                                    $_SESSION['akun'] = $akun;
                                    echo "<script> alert('Anda sukses login sebagai Admin');</script>";
                                    echo "<script> location ='dashboard.php';</script>";
                                }
                            } else {
                                echo "<script> alert('Email atau Password anda salah');</script>";
                                echo "<script> location ='login.php';</script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="assets/assets_admin/vendors/scripts/core.js"></script>
    <script src="assets/assets_admin/vendors/scripts/script.min.js"></script>
    <script src="assets/assets_admin/vendors/scripts/process.js"></script>
    <script src="assets/assets_admin/vendors/scripts/layout-settings.js"></script>
</body>

</html>