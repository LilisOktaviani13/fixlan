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
  <title>Data Pengguna - FixLAN</title>
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
      <h2 class="text-white text-center">Data Pengguna Sistem</h2>
      <p class="text-center text-light">Halaman ini digunakan untuk mengelola akun pengguna dalam sistem FixLAN</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <!-- Header Row -->
  <div class="row mb-4 justify-content-between align-items-center">
    <div class="col-md-6">
      <h4 class="mb-0">Daftar Pengguna</h4>
    </div>
    <div class="col-md-2.5 text-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Pengguna
      </button>
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
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
            <?php
              $no = 1;
              $users = mysqli_query($conn, "SELECT * FROM user ORDER BY role DESC, nama ASC");
              while ($u = mysqli_fetch_assoc($users)):
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($u['nama']); ?></td>
              <td><?= htmlspecialchars($u['username']); ?></td>
              <td><?= ucfirst($u['role']); ?></td>
              <td>
                <button class="btn btn-danger btn-sm btn-hapus"
                  data-id="<?= $u['id']; ?>"
                  data-nama="<?= $u['nama']; ?>"
                  data-bs-toggle="modal"
                  data-bs-target="#modalHapus">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($users) == 0): ?>
            <tr><td colspan="5" class="text-center">Belum ada data pengguna.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambah">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pengguna</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div id="alertTambah"></div>
          <div class="mb-3">
            <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="text" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="">-- Pilih Role --</option>
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formHapus">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Pengguna</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus pengguna <strong id="hapusNama"></strong>?</p>
          <input type="hidden" name="id" id="hapusId">
          <div id="alertHapus"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Hapus</button>
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
$(document).ready(function() {
  // Tambah Pengguna
  $('#formTambah').submit(function(e) {
    e.preventDefault();
    $.post('tambah_ajax.php', $(this).serialize(), function(res) {
      const result = JSON.parse(res);
      if (result.status == 'success') {
        $('#alertTambah').html('<div class="alert alert-success">Berhasil ditambahkan!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertTambah').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });

  // Isi data ke modal hapus
  $('.btn-hapus').click(function() {
    $('#hapusId').val($(this).data('id'));
    $('#hapusNama').text($(this).data('nama'));
  });

  // Proses Hapus
  $('#formHapus').submit(function(e) {
    e.preventDefault();
    $.post('hapus_ajax.php', $(this).serialize(), function(res) {
      const result = JSON.parse(res);
      if (result.status == 'success') {
        $('#alertHapus').html('<div class="alert alert-success">Berhasil dihapus!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertHapus').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });
});
</script>

</body>
</html>
