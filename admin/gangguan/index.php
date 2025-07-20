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
  <title>Data Gangguan - FixLAN</title>
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
      <h2 class="text-white text-center">Data Gangguan Jaringan LAN</h2>
      <p class="text-center text-light">Halaman ini digunakan untuk mengelola data gangguan jaringan pada sistem FixLAN</p>
    </div>
  </div>
</header>

<!-- Main Content -->
<div class="container my-5">
  <!-- Header Row -->
  <div class="row mb-4 justify-content-between align-items-center">
    <div class="col-md-6">
      <h4 class="mb-0">Data Gangguan</h4>
    </div>
    <div class="col-md-2.5 text-end">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahGangguan">
        + Tambah Gangguan
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
              <th>No</th>
              <th>Kode</th>
              <th>Nama Gangguan</th>
              <th>Detail Gangguan</th>
              <th>Saran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM gangguan");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['kode_gangguan']); ?></td>
              <td><?= htmlspecialchars($row['nama_gangguan']); ?></td>
              <td><?= htmlspecialchars($row['detail_gangguan']); ?></td>
              <td><?= htmlspecialchars($row['saran']); ?></td>
              <td>
                <a href="#" 
                    class="btn btn-warning btn-sm btn-edit"
                    data-id="<?= $row['id'] ?>"
                    data-kode="<?= htmlspecialchars($row['kode_gangguan']) ?>"
                    data-nama="<?= htmlspecialchars($row['nama_gangguan']) ?>"
                    data-detail="<?= htmlspecialchars($row['detail_gangguan']) ?>"
                    data-saran="<?= htmlspecialchars($row['saran']) ?>"
                    title="Edit">
                    <i class="fas fa-edit"></i>
               <a href="#" 
                    class="btn btn-danger btn-sm btn-hapus" 
                    data-id="<?= $row['id']; ?>" 
                    data-nama="<?= htmlspecialchars($row['nama_gangguan']); ?>" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalHapus">
                    <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php } ?>
            <?php if (mysqli_num_rows($query) === 0): ?>
            <tr>
              <td colspan="6" class="text-center">Data belum tersedia.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahGangguan" tabindex="-1" aria-labelledby="modalTambahGangguanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formTambahGangguan">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahGangguanLabel">Tambah Data Gangguan</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div id="alertMsg"></div>

          <div class="mb-3">
            <label>Kode Gangguan</label>
            <input type="text" name="kode_gangguan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama Gangguan</label>
            <input type="text" name="nama_gangguan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Detail Gangguan</label>
            <textarea name="detail_gangguan" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Saran</label>
            <textarea name="saran" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditGangguan" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formEditGangguan">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Gangguan</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div id="editAlertMsg"></div>

          <input type="hidden" name="id" id="edit-id">
          <div class="mb-3">
            <label>Kode Gangguan</label>
            <input type="text" name="kode_gangguan" id="edit-kode" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Nama Gangguan</label>
            <input type="text" name="nama_gangguan" id="edit-nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Detail Gangguan</label>
            <textarea name="detail_gangguan" id="edit-detail" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Saran</label>
            <textarea name="saran" id="edit-saran" class="form-control" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formHapusGangguan">
        <div class="modal-header">
          <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <div id="alertHapus"></div>
          <p>Apakah Anda yakin ingin menghapus <strong id="hapusNama"></strong>?</p>
          <input type="hidden" name="id" id="hapusId">
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

<!-- AJAX Simpan -->
<script>
  $('#formTambahGangguan').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: 'simpan_ajax.php',
      type: 'POST',
      data: $(this).serialize(),
      success: function(res) {
        var result = JSON.parse(res);
        if (result.status === 'success') {
          $('#alertMsg').html('<div class="alert alert-success">Data berhasil disimpan!</div>');
          setTimeout(() => {
            location.reload();
          }, 1000);
        } else {
          $('#alertMsg').html('<div class="alert alert-danger">Gagal menyimpan: ' + result.msg + '</div>');
        }
      },
      error: function() {
        $('#alertMsg').html('<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data.</div>');
      }
    });
  });
</script>

<script>
  $(document).ready(function () {
    // Tampilkan modal dan isi data
    $('.btn-edit').on('click', function () {
      $('#edit-id').val($(this).data('id'));
      $('#edit-kode').val($(this).data('kode'));
      $('#edit-nama').val($(this).data('nama'));
      $('#edit-detail').val($(this).data('detail'));
      $('#edit-saran').val($(this).data('saran'));
      $('#editAlertMsg').html(''); // bersihkan pesan
      $('#modalEditGangguan').modal('show');
    });

    // Proses update
    $('#formEditGangguan').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: 'update_ajax.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (res) {
          let result = JSON.parse(res);
          if (result.status === 'success') {
            $('#editAlertMsg').html('<div class="alert alert-success">Data berhasil diperbarui!</div>');
            setTimeout(() => {
              location.reload();
            }, 1000);
          } else {
            $('#editAlertMsg').html('<div class="alert alert-danger">Gagal: ' + result.msg + '</div>');
          }
        },
        error: function () {
          $('#editAlertMsg').html('<div class="alert alert-danger">Terjadi kesalahan saat mengupdate data.</div>');
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
  $('.btn-hapus').click(function() {
    const id = $(this).data('id');
    const nama = $(this).data('nama');
    $('#hapusId').val(id);
    $('#hapusNama').text(nama);
    $('#alertHapus').html('');
  });

  $('#formHapusGangguan').submit(function(e) {
    e.preventDefault();
    $.ajax({
      url: 'hapus_ajax.php',
      type: 'POST',
      data: $(this).serialize(),
      success: function(res) {
        let result = JSON.parse(res);
        if (result.status === 'success') {
          $('#alertHapus').html('<div class="alert alert-success">Data berhasil dihapus!</div>');
          setTimeout(() => {
            location.reload();
          }, 1000);
        } else {
          $('#alertHapus').html('<div class="alert alert-danger">Gagal menghapus data!</div>');
        }
      },
      error: function() {
        $('#alertHapus').html('<div class="alert alert-danger">Terjadi kesalahan server.</div>');
      }
    });
  });
});
</script>

</body>
</html>
