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
  <title>Data Gejala - FixLAN</title>
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
      <h2 class="text-white text-center">Data Gejala Jaringan LAN</h2>
      <p class="text-center text-light">Halaman ini digunakan untuk mengelola data gejala jaringan pada sistem FixLAN</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <!-- Header Row -->
  <div class="row mb-4 justify-content-between align-items-center">
    <div class="col-md-6">
      <h4 class="mb-0">Data Gejala</h4>
    </div>
    <div class="col-md-2.5 text-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahGejala">
        + Tambah Gejala
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
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
          <?php
          $no = 1;
          $query = mysqli_query($conn, "SELECT * FROM gejala");
          while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['kode_gejala']); ?></td>
            <td><?= htmlspecialchars($row['nama_gejala']); ?></td>
            <td>
              <!-- Tombol Edit -->
              <a href="#" 
                class="btn btn-warning btn-sm btn-edit"
                data-id="<?= $row['id'] ?>"
                data-kode="<?= htmlspecialchars($row['kode_gejala']) ?>"
                data-nama="<?= htmlspecialchars($row['nama_gejala']) ?>">
                <i class="fas fa-edit"></i>
              </a>

              <!-- Tombol Hapus -->
              <a href="#" 
                class="btn btn-danger btn-sm btn-hapus" 
                data-id="<?= $row['id']; ?>" 
                data-nama="<?= htmlspecialchars($row['nama_gejala']); ?>" 
                data-bs-toggle="modal" 
                data-bs-target="#modalHapus">
                <i class="fas fa-trash"></i>
              </a>
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

<!-- Modal Tambah Gejala -->
<div class="modal fade" id="modalTambahGejala" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahGejala">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Gejala</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div id="alertTambahGejala"></div>
          <div class="mb-3">
            <label>Kode Gejala</label>
            <input type="text" name="kode_gejala" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama Gejala</label>
            <textarea name="nama_gejala" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Gejala -->
<div class="modal fade" id="modalEditGejala" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditGejala">
        <div class="modal-header">
          <h5 class="modal-title">Edit Gejala</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label>Kode Gejala</label>
            <input type="text" name="kode_gejala" id="edit-kode" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama Gejala</label>
            <textarea name="nama_gejala" id="edit-nama" class="form-control" required></textarea>
          </div>
          <div id="alertEditGejala"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formHapusGejala">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus <strong id="hapusNama"></strong>?</p>
          <input type="hidden" name="id" id="hapusId">
          <div id="alertHapusGejala"></div>
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
$(document).ready(function () {
  // Tambah Gejala
  $('#formTambahGejala').submit(function(e) {
    e.preventDefault();
    $.post('simpan_ajax.php', $(this).serialize(), function(res) {
      let result = JSON.parse(res);
      if (result.status === 'success') {
        $('#alertTambahGejala').html('<div class="alert alert-success">Data berhasil disimpan!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertTambahGejala').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });

  // Edit Gejala - tampilkan modal
  $('.btn-edit').click(function () {
    $('#edit-id').val($(this).data('id'));
    $('#edit-kode').val($(this).data('kode'));
    $('#edit-nama').val($(this).data('nama'));
    $('#modalEditGejala').modal('show');
  });

  // Update Gejala
  $('#formEditGejala').submit(function(e) {
    e.preventDefault();
    $.post('update_ajax.php', $(this).serialize(), function(res) {
      let result = JSON.parse(res);
      if (result.status === 'success') {
        $('#alertEditGejala').html('<div class="alert alert-success">Berhasil diperbarui!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertEditGejala').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });

  // Hapus Gejala - tampilkan modal
  $('.btn-hapus').click(function () {
    $('#hapusId').val($(this).data('id'));
    $('#hapusNama').text($(this).data('nama'));
  });

  // Proses Hapus Gejala
  $('#formHapusGejala').submit(function(e) {
    e.preventDefault();
    $.post('hapus_ajax.php', $(this).serialize(), function(res) {
      let result = JSON.parse(res);
      if (result.status === 'success') {
        $('#alertHapusGejala').html('<div class="alert alert-success">Berhasil dihapus!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertHapusGejala').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });
});
</script>


</body>
</html>
