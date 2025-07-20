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
  <title>Pengaturan Sistem - FixLAN</title>
  <link rel="shortcut icon" href="../../images/logo spakar.jpg" type="image/x-icon">

  <!-- Styles -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
  <link href="../../css/bootstrap.css" rel="stylesheet">
  <link href="../../css/fontawesome-all.css" rel="stylesheet">
  <link href="../../css/styles.css" rel="stylesheet">
<!-- Bootstrap 5 Bundle -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
      <h2 class="text-white text-center">Pengaturan Sistem Pakar</h2>
      <p class="text-center text-light">Menampilkan informasi sistem dan konsep yang digunakan.</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <div class="row mb-4 justify-content-between align-items-center">
    <div class="col-md-6">
      <h4 class="mb-0">Informasi Sistem</h4>
    </div>
    <div class="col-md-2.5 text-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAbout">Tambah / Edit</button>
    </div>
  </div>

  <div class="card card-custom">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="thead-light">
            <tr>
              <th>Nama Sistem</th>
              <th>Sistem Pakar</th>
              <th>Penyakit</th>
              <th>Certainty Factor</th>
              <th>Jaringan LAN Komputer</th>
              <th>Troubleshooting Jaringan LAN Komputer</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data): ?>
            <tr>
              <td><?= htmlspecialchars($data['nama_sistem']) ?></td>
              <td><?= nl2br(htmlspecialchars($data['definisi_spakar'])) ?></td>
              <td><?= nl2br(htmlspecialchars($data['definisi_penyakit'])) ?></td>
              <td><?= nl2br(htmlspecialchars($data['definisi_cf'])) ?></td>
              <td><?= nl2br(htmlspecialchars($data['definisi_lan'])) ?></td>
              <td><?= nl2br(htmlspecialchars($data['definisi_tr'])) ?></td>
            </tr>
            <?php else: ?>
            <tr><td colspan="6" class="text-center">Data belum tersedia</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal About -->
<div class="modal fade" id="modalAbout" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formAbout">
        <div class="modal-header">
          <h5 class="modal-title">Tambah / Edit Informasi Sistem</h5>
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div id="alertFormAbout" class="mb-3"></div>
          <div class="row">
            <div class="mb-3 col-md-6">
              <label>Nama Sistem</label>
              <input type="text" name="nama_sistem" class="form-control" value="<?= $data['nama_sistem'] ?? '' ?>" required>
            </div>
            <div class="mb-3 col-md-6">
              <label>Sistem Pakar</label>
              <textarea name="definisi_spakar" class="form-control" required><?= $data['definisi_spakar'] ?? '' ?></textarea>
            </div>
            <div class="mb-3 col-md-6">
              <label>Penyakit</label>
              <textarea name="definisi_penyakit" class="form-control" required><?= $data['definisi_penyakit'] ?? '' ?></textarea>
            </div>
            <div class="mb-3 col-md-6">
              <label>Certainty Factor</label>
              <textarea name="definisi_cf" class="form-control" required><?= $data['definisi_cf'] ?? '' ?></textarea>
            </div>
            <div class="mb-3 col-md-6">
              <label>Jaringan LAN</label>
              <textarea name="definisi_lan" class="form-control" required><?= $data['definisi_lan'] ?? '' ?></textarea>
            </div>
            <div class="mb-3 col-md-6">
              <label>Troubleshooting</label>
              <textarea name="definisi_tr" class="form-control" required><?= $data['definisi_tr'] ?? '' ?></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
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
$('#formAbout').submit(function(e) {
  e.preventDefault();
  $.post('simpan_ajax.php', $(this).serialize(), function(res) {
    let result = JSON.parse(res);
    let alertBox = $('#alertFormAbout');
    if (result.status === 'success') {
      alertBox.html('<div class="alert alert-success">' + result.msg + '</div>');
      setTimeout(() => location.reload(), 1200);
    } else {
      alertBox.html('<div class="alert alert-danger">' + result.msg + '</div>');
    }
  });
});
</script>

</body>
</html>
