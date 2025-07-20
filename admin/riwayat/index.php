<?php
session_start();
include '../../koneksi.php';

if ($_SESSION['status'] != "login") {
    header("location:../../login/index.php");
    exit;
}

$id_user = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Riwayat - FixLAN</title>
  <meta name="description" content="Kelola Data Gangguan Sistem Pakar Jaringan FixLAN" />
  <link rel="shortcut icon" href="../../images/logo spakar.jpg" type="image/x-icon">

  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
  <link href="../../css/bootstrap.css" rel="stylesheet">
  <link href="../../css/fontawesome-all.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet">

  <style>
    .table td, .table th {
      white-space: normal;
      vertical-align: middle;
    }
    .card-custom {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .btn-sm {
      font-size: 0.8rem;
      padding: 5px 10px;
    }
  </style>
</head>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS (wajib bundle agar modal berfungsi) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
      <h2 class="text-white text-center">Data Riwayat Diagnosa Jaringan LAN</h2>
      <p class="text-center text-light">Halaman ini digunakan untuk mengelola data diagnosa yang sudah dilakukan oleh user di sistem FixLAN</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <!-- Header Row -->
  <div class="row mb-4 justify-content-between align-items-center">
    <div class="col-md-6">
      <h4 class="mb-0">Data Riwayat Diagnosa</h4>
    </div>
  </div>

  <!-- Tabel -->
  <div class="card card-custom">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="thead-light">
            <tr>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Gangguan</th>
                <th>CF(%)</th>
                <th>Gejala</th>
                <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
          <?php
            $no = 1;
          $query = mysqli_query($conn, "SELECT * FROM riwayat WHERE id_user='$id_user' ORDER BY tanggal_diagnosa DESC");
          while ($row = mysqli_fetch_assoc($query)) {
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= date('d/m/Y H:i', strtotime($row['tanggal_diagnosa'])); ?></td>
              <td><?= htmlspecialchars($row['nama_gangguan']); ?></td>
              <td><?= $row['persentase_cf']; ?>%</td>
              <td><?= htmlspecialchars($row['gejala_terpilih']); ?></td>
              <td>
                <button class="btn btn-primary btn-sm btn-detail"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDetail"
                        data-id="<?= $row['id']; ?>">
                  <i class="fas fa-eye"></i> Detail
                </button>
              </td>
          </tr>
          <?php } ?>
          <?php if (mysqli_num_rows($query) === 0): ?>
          <tr>
            <td colspan="4" class="text-center">Data belum tersedia.</td>
          </tr>
          <?php endif; ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Riwayat -->
<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Riwayat Diagnosa</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body" id="detailContent">
        <p class="text-center">Memuat data...</p>
      </div>
      <div class="modal-footer no-print">
        <button onclick="printDiv('detailContent')" class="btn btn-outline-success">
          <i class="fas fa-print"></i> Download
        </button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/scripts.js"></script>

<script>
function printDiv(divId) {
  let printContents = document.getElementById(divId).innerHTML;
  let originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  window.location.reload();
}

$(document).ready(function () {
  $('.btn-detail').click(function () {
    const id = $(this).data('id');
    $('#detailContent').html('<p class="text-center">Memuat data...</p>');

    $.get('get_detail.php', { id: id }, function (data) {
      $('#detailContent').html(data);
    });
  });
});
</script>

</body>
</html>
