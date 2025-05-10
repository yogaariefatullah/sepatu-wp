<?php include 'koneksi.php';
session_start();
if (empty($_SESSION['akun'])) {
   echo "<script> alert('Maaf, anda belum login, silahkan login terlebih dahulu');</script>";
   echo "<script> location ='login.php';</script>";
}
function alert($msg, $to = null)
{
   $to = ($to) ? $to : $_SERVER["PHP_SELF"];
   return "<script>alert('{$msg}');window.location='{$to}';</script>";
}

function rupiah($angka)
{
   if ($angka != "") {
      $angkafix = $angka;
   } else {
      $angkafix = 0;
   }
   $hasilrupiah = "Rp " . number_format($angkafix, 2, ',', '.');
   return $hasilrupiah;
}
function tanggal($tgl)
{
   $tanggal = substr($tgl, 8, 2);
   $bulan = bulan(substr($tgl, 5, 2));
   $tahun = substr($tgl, 0, 4);
   return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function bulan($bln)
{
   switch ($bln) {
      case 1:
         return "Januari";
         break;
      case 2:
         return "Februari";
         break;
      case 3:
         return "Maret";
         break;
      case 4:
         return "April";
         break;
      case 5:
         return "Mei";
         break;
      case 6:
         return "Juni";
         break;
      case 7:
         return "Juli";
         break;
      case 8:
         return "Agustus";
         break;
      case 9:
         return "September";
         break;
      case 10:
         return "Oktober";
         break;
      case 11:
         return "November";
         break;
      case 12:
         return "Desember";
         break;
   }
}
?>
<!DOCTYPE html>
<html>

<head>
   <!-- Basic Page Info -->
   <meta charset="utf-8">
   <title>Sepatu WP</title>

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
   <link rel="stylesheet" type="text/css" href="assets/assets_admin/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" type="text/css" href="assets/assets_admin/src/plugins/datatables/css/responsive.bootstrap4.min.css">
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

<body>
   <div class="header">
      <div class="header-left">
         <div class="menu-icon dw dw-menu"></div>
         <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>

      </div>
      <div class="header-right">
         <div class="user-info-dropdown">
            <div class="dropdown">
               <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                  <span class="user-icon">
                     <img src="assets/adm.png" alt="">
                  </span>
                  <?php
                  $idakun = $_SESSION['akun']['idakun'];
                  $ambildataakun = $koneksi->query("SELECT * FROM akun WHERE idakun='$idakun'");
                  $akun = $ambildataakun->fetch_assoc();
                  ?>
                  <?php if ($akun['foto'] != '') { ?>
                     <span class="nav-profile-name"><?php echo $akun['nama']; ?></span>
                  <?php } else { ?>
                     <span class="nav-profile-name"><?php echo $akun['nama']; ?></span>
                  <?php } ?>
               </a>
               <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                  <a class="dropdown-item" href="logout.php" onclick="return confirm('Apakah Anda Yakin Ingin Keluar dari Halaman ini ?')"><i class="dw dw-logout"></i> Log Out</a>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="left-side-bar">
      <div class="brand-logo">
         <a href="dashboard.php">
            <?php
            $idakun = $_SESSION['akun']['idakun'];
            $ambildataakun = $koneksi->query("SELECT * FROM akun WHERE idakun='$idakun'");
            $akun = $ambildataakun->fetch_assoc();
            ?>
            <?php if ($akun['foto'] != '') { ?>
               <span class="nav-profile-name"><?php echo $akun['nama']; ?></span>
            <?php } else { ?>
               <span class="nav-profile-name"><?php echo $akun['nama']; ?></span>
            <?php } ?>
         </a>
         <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
         </div>
      </div>
      <div class="menu-block customscroll">
         <div class="sidebar-menu">
            <ul id="accordion-menu">
               <li>
                  <a href="dashboard.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                  </a>
               </li>
               <li>
                  <a href="profil.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-user"></span><span class="mtext">Profil</span>
                  </a>
               </li>
               <li>
                  <a href="akundaftar.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-user"></span><span class="mtext">Daftar Akun</span>
                  </a>
               </li>
               <li>
                  <a href="sepatu.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-edit2"></span><span class="mtext">Sepatu</span>
                  </a>
               </li>
               <li>
                  <a href="kriteria.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-edit2"></span><span class="mtext">Kriteria</span>
                  </a>
               </li>
               <li>
                  <a href="subkriteria.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-library"></span><span class="mtext">Sub Kriteria</span>
                  </a>
               </li>
               <li>
                  <a href="bobotkriteria.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-analytics-21"></span><span class="mtext">Bobot Kriteria</span>
                  </a>
               </li>
               <!-- <li>
                  <a href="nilai.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-right-arrow1"></span><span class="mtext">Isi Nilai Alternatif</span>
                  </a>
               </li>
               <li>
                  <a href="hasilsepatu.php" class="dropdown-toggle no-arrow">
                     <span class="micon dw dw-copy"></span><span class="mtext">Hasil</span>
                  </a>
               </li> -->
            </ul>
         </div>
      </div>
   </div>
   <div class="mobile-menu-overlay"></div>