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
  <title>Data Nilai CF - FixLAN</title>
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
      <h2 class="text-white text-center">Data Nilai CF Jaringan LAN</h2>
      <p class="text-center text-light">Halaman ini digunakan untuk mengelola data nilai CF dari relasi antara gejala dan gangguan jaringan pada sistem FixLAN</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <!-- Header Row -->
  <div class="row mb-4 justify-content-between align-items-center">
    <div class="col-md-6">
      <h4 class="mb-0">Data Nilai Certainty Factor</h4>
    </div>
    <div class="col-md-2.5 text-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahCF">
        + Tambah CF
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
                <th>Gangguan</th>
                <th>Gejala</th>
                <th>MB</th>
                <th>MD</th>
                <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
          <?php
            $no = 1;
            $query = mysqli_query($conn, "
              SELECT cf.*, 
                      g.nama_gangguan, 
                      ge.nama_gejala 
              FROM cf
              JOIN gangguan g ON cf.id_gangguan = g.id
              JOIN gejala ge ON cf.id_gejala = ge.id
            ");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama_gangguan']); ?></td>
              <td><?= htmlspecialchars($row['nama_gejala']); ?></td>
              <td><?= $row['mb']; ?></td>
              <td><?= $row['md']; ?></td>
              <td>
                <!-- Tombol Edit -->
                <a href="#"
                  class="btn btn-warning btn-sm btn-edit"
                  data-id="<?= $row['id'] ?>"
                  data-id_gangguan="<?= $row['id_gangguan'] ?>"
                  data-id_gejala="<?= $row['id_gejala'] ?>"
                  data-mb="<?= $row['mb'] ?>"
                  data-md="<?= $row['md'] ?>">
                  <i class="fas fa-edit"></i>
                </a>

                <!-- Tombol Hapus -->
                <a href="#"
                  class="btn btn-danger btn-sm btn-hapus"
                  data-id="<?= $row['id'] ?>"
                  data-nama="<?= $row['nama_gejala'] ?>"
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

<!-- Modal Tambah CF -->
<div class="modal fade" id="modalTambahCF" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahCF">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Nilai CF</h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div id="alertTambahCF"></div>

          <div class="mb-3">
            <label>Gangguan</label>
            <select name="id_gangguan" class="form-control" required>
              <option value="">Pilih Gangguan</option>
              <?php
              $gangguan = mysqli_query($conn, "SELECT * FROM gangguan");
              while ($g = mysqli_fetch_assoc($gangguan)) {
                echo "<option value='{$g['id']}'>{$g['nama_gangguan']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Gejala</label>
            <select name="id_gejala" class="form-control" required>
              <option value="">Pilih Gejala</option>
              <?php
              $gejala = mysqli_query($conn, "SELECT * FROM gejala");
              while ($g = mysqli_fetch_assoc($gejala)) {
                echo "<option value='{$g['id']}'>{$g['nama_gejala']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label>MB (Measure of Belief)</label>
            <input type="number" step="0.01" min="0" max="1" name="mb" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>MD (Measure of Disbelief)</label>
            <input type="number" step="0.01" min="0" max="1" name="md" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit CF -->
<div class="modal fade" id="modalEditCF" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditCF">
        <div class="modal-header">
          <h5 class="modal-title">Edit Nilai CF</h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label>Gangguan</label>
            <select name="id_gangguan" id="edit-id-gangguan" class="form-control" required>
              <option value="">Pilih Gangguan</option>
              <?php
              $gangguan = mysqli_query($conn, "SELECT * FROM gangguan");
              while ($g = mysqli_fetch_assoc($gangguan)) {
                echo "<option value='{$g['id']}'>{$g['nama_gangguan']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Gejala</label>
            <select name="id_gejala" id="edit-id-gejala" class="form-control" required>
              <option value="">Pilih Gejala</option>
              <?php
              $gejala = mysqli_query($conn, "SELECT * FROM gejala");
              while ($g = mysqli_fetch_assoc($gejala)) {
                echo "<option value='{$g['id']}'>{$g['nama_gejala']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label>MB</label>
            <input type="number" step="0.01" name="mb" id="edit-mb" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>MD</label>
            <input type="number" step="0.01" name="md" id="edit-md" class="form-control" required>
          </div>

          <div id="alertEditCF"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus CF -->
<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formHapusCF">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <p>Yakin ingin menghapus relasi gejala <strong id="hapusNama"></strong>?</p>
          <input type="hidden" name="id" id="hapusId">
          <div id="alertHapusCF"></div>
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
  // Tambah CF
  $('#formTambahCF').submit(function(e) {
    e.preventDefault();
    $.post('simpan_ajax.php', $(this).serialize(), function(res) {
      let result = JSON.parse(res);
      if (result.status === 'success') {
        $('#alertTambahCF').html('<div class="alert alert-success">Data berhasil disimpan!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertTambahCF').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });

  // Tampilkan modal Edit CF
  $('.btn-edit').click(function () {
    $('#edit-id').val($(this).data('id'));
    $('#edit-id-gangguan').val($(this).data('id_gangguan'));
    $('#edit-id-gejala').val($(this).data('id_gejala'));
    $('#edit-mb').val($(this).data('mb'));
    $('#edit-md').val($(this).data('md'));
    $('#modalEditCF').modal('show');
  });

  // Proses update CF
  $('#formEditCF').submit(function(e) {
    e.preventDefault();
    $.post('update_ajax.php', $(this).serialize(), function(res) {
      let result = JSON.parse(res);
      if (result.status === 'success') {
        $('#alertEditCF').html('<div class="alert alert-success">Data berhasil diperbarui!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertEditCF').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });

  // Hapus CF - tampilkan modal
  $('.btn-hapus').click(function () {
    $('#hapusId').val($(this).data('id'));
    $('#hapusNama').text($(this).data('nama'));
  });

  // Proses Hapus CF
  $('#formHapusCF').submit(function(e) {
    e.preventDefault();
    $.post('hapus_ajax.php', $(this).serialize(), function(res) {
      let result = JSON.parse(res);
      if (result.status === 'success') {
        $('#alertHapusCF').html('<div class="alert alert-success">Data berhasil dihapus!</div>');
        setTimeout(() => location.reload(), 1000);
      } else {
        $('#alertHapusCF').html('<div class="alert alert-danger">' + result.msg + '</div>');
      }
    });
  });
});
</script>

</body>
</html>
