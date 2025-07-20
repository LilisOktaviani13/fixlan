<?php
session_start();
include '../../koneksi.php';

if ($_SESSION['status'] != "login") {
    header("location:../../login/index.php");
    exit;
}
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM about LIMIT 1"));

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tentang Sistem - FixLAN</title>
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

<body data-spy="scroll" data-target=".fixed-top">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <?php include '../partials/navbar.php'; ?>
</nav>

<!-- Header -->
<header id="header" class="header">
  <div class="header-content">
    <div class="container text-center">
      <h2 class="text-white">Diagnosa Gangguan Jaringan LAN</h2>
      <p class="text-light">Silakan pilih gejala yang Anda alami untuk mulai mendiagnosa gangguan.</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <div class="card card-custom">
    <div class="card-body">
      <div class="container my-5">
    <div class="artikel-box">
      <?php if ($data): ?>
        <h3 align="center"><?= htmlspecialchars($data['nama_sistem']) ?></h3>
        <p align="justify"><strong>Sistem Pakar:</strong><br><?= nl2br(htmlspecialchars($data['definisi_spakar'])) ?></p>
        <p align="justify"><strong>Penyakit:</strong><br><?= nl2br(htmlspecialchars($data['definisi_penyakit'])) ?></p>
        <p align="justify"><strong>Certainty Factor:</strong><br><?= nl2br(htmlspecialchars($data['definisi_cf'])) ?></p>
        <p align="justify"><strong>Jaringan LAN:</strong><br><?= nl2br(htmlspecialchars($data['definisi_lan'])) ?></p>
        <p align="justify"><strong>Troubleshooting:</strong><br><?= nl2br(htmlspecialchars($data['definisi_tr'])) ?></p>
      <?php else: ?>
        <p class="text-center">Informasi sistem belum tersedia. Silakan hubungi admin.</p>
      <?php endif; ?>
    </div>
  </div>
    </div>
  </div>
</div>



<!-- Footer -->
<svg class="footer-frame" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 79">
  <path fill="#5f4def" d="M0,72.427C143,12.138..."/>
</svg>
<div class="copyright">
  <?php include '../partials/footer.php'; ?>
</div>

<!-- Scripts -->
<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/scripts.js"></script>
<!-- Scripts -->
<script src="../../js/jquery.min.js"></script>
<script src="../../js/popper.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/jquery.easing.min.js"></script>
<script src="../../js/swiper.min.js"></script>
<script src="../../js/scripts.js"></script>
<!-- jQuery -->
<script src="../../js/jquery.min.js"></script>

<!-- Bootstrap Bundle (dengan Popper.js di dalamnya) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
