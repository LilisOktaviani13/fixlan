<?php
session_start();
include '../../koneksi.php';

if ($_SESSION['status'] != "login") {
    header("location:../../login/index.php");
    exit;
}

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
      <div class="text-center my-4">
      <a class="btn-solid-lg page-scroll" href="sign-up.html">Mulai Diagnosa</a>
</div>

    </div>
  </div>
</header>

<br>
<br>
<br>
<br>
<?php
$id_user = $_SESSION['id'];
$riwayat = mysqli_query($conn, "SELECT * FROM riwayat WHERE id_user='$id_user' ORDER BY tanggal_diagnosa DESC LIMIT 3");
?>
<div class="container mt-4">
  <h5>Riwayat Diagnosa Terakhir</h5>
  <ul class="list-group">
    <?php while ($r = mysqli_fetch_assoc($riwayat)): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <?= htmlspecialchars($r['nama_gangguan']) ?> 
      <span><?= date('d/m/Y H:i', strtotime($r['tanggal_diagnosa'])) ?></span>
      <a href="../riwayat/index.php" class="btn btn-sm btn-outline-primary">Lihat</a>
    </li>
    <?php endwhile; ?>
  </ul>
</div>

<br>
<br>

<section class="bg-light py-5">
  <div class="container">
    <h4 class="text-center mb-4">Apa yang bisa kamu lakukan di FixLAN?</h4>
    <div class="row text-center">
      <div class="col-md-4">
        <i class="fas fa-network-wired fa-2x mb-2 text-primary"></i>
        <h6>Diagnosa Gangguan</h6>
        <p>Pilih gejala yang kamu alami dalam kendala jaringan LAN, dan dapatkan hasil diagnosa nya.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-history fa-2x mb-2 text-success"></i>
        <h6>Lihat Riwayat</h6>
        <p>Cek hasil diagnosa kamu sebelumnya kapan pun dibutuhkan.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-info-circle fa-2x mb-2 text-info"></i>
        <h6>Pelajari Sistem</h6>
        <p>Kenali cara kerja sistem pakar dan Certainty Factor (CF).</p>
      </div>
    </div>
  </div>
</section>

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
