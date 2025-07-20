<?php
session_start();
include '../../koneksi.php';

if ($_SESSION['status'] != "login") {
    header("location:../../login/index.php");
    exit;
}

$jumlahGangguan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM gangguan"))['total'];
$jumlahGejala   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM gejala"))['total'];
$jumlahCF       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM cf"))['total'];
$jumlahUser     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FixLAN</title>
  <link rel="shortcut icon" href="../../images/logo spakar.jpg" type="image/x-icon">

  <!-- Meta -->
  <meta name="description" content="Dashboard Admin FixLAN untuk monitoring data gangguan, gejala, dan pengguna." />

  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
  <link href="../../css/bootstrap.css" rel="stylesheet">
  <link href="../../css/fontawesome-all.css" rel="stylesheet">
  <link href="../../css/swiper.css" rel="stylesheet">
  <link href="../../css/magnific-popup.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet">
</head>
<body data-spy="scroll" data-target=".fixed-top">

<!-- Preloader -->
<div class="spinner-wrapper">
  <div class="spinner">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
  </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <?php include '../partials/navbar.php'; ?>
</nav>

          <!-- Header -->
<header id="header" class="header">
  <div class="header-content">
    <div class="container">
      <h2 class="text-white text-center">Hallo <?= htmlspecialchars($_SESSION['nama']); ?>, Selamat Datang di FixLAN</h2>
    </div>
  </div>
</header>

<br>
<br>
<br>
<br>
<!-- Statistik Panel -->
<div class="container my-5">
  <div class="row text-center">
    <div class="col-md-3">
      <div class="card shadow-sm p-3">
        <h5>Total Gangguan</h5>
        <h2><?= $jumlahGangguan ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3">
        <h5>Total Gejala</h5>
        <h2><?= $jumlahGejala ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3">
        <h5>Total Nilai CF</h5>
        <h2><?= $jumlahCF ?></h2>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm p-3">
        <h5>Total Pengguna</h5>
        <h2><?= $jumlahUser ?></h2>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<svg class="footer-frame" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 79"><path fill="#5f4def" d="M0,72.427C143,12.138..."/></svg>
<div class="copyright">
  <?php include '../partials/footer.php'; ?>
</div>

<!-- Scripts -->
<script src="../../js/jquery.min.js"></script>
<script src="../../js/popper.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.easing.min.js"></script>
<script src="../../js/swiper.min.js"></script>
<script src="../../js/jquery.magnific-popup.js"></script>
<script src="../../js/validator.min.js"></script>
<script src="../../js/scripts.js"></script>
</body>
</html>
