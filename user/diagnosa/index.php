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
  <title>Diagnosa - FixLAN</title>
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
      <form id="formDiagnosa">
        <h5 class="mb-4">Checklist Gejala</h5>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th>Pilih</th>
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
                <td class="text-center">
                  <input type="checkbox" name="gejala_terpilih[]" value="<?= $row['id']; ?>">
                </td>
              </tr>
              <?php } ?>
              <?php if (mysqli_num_rows($query) === 0): ?>
              <tr><td colspan="4" class="text-center">Data tidak tersedia.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan & Diagnosa</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hasil -->
<div class="modal fade" id="modalHasil" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hasil Diagnosa</h5>
      </div>
      <div class="modal-body" id="printArea">
        <!-- Hasil dari AJAX -->
      </div>
      <div class="modal-footer">
        <button onclick="printDiv('printArea')" class="btn btn-outline-primary">Cetak</button>
<button id="btnTutupModal" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
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

<!-- Script Anda sendiri -->
<script>
  document.getElementById('formDiagnosa').addEventListener('submit', function(e) {
    e.preventDefault();

    const checkbox = document.querySelectorAll('input[name="gejala_terpilih[]"]:checked');
    if (checkbox.length === 0) {
      alert('Pilih minimal satu gejala!');
      return;
    }

    const formData = new FormData(this);

    fetch('proses_ajax.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById('printArea').innerHTML = data;

      // ✅ Inisialisasi Modal
      const hasilModal = new bootstrap.Modal(document.getElementById('modalHasil'));
      hasilModal.show();
    });
  });
</script>

<script>
function printDiv(divId) {
  var printContents = document.getElementById(divId).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  location.reload();
}

document.getElementById('formDiagnosa').addEventListener('submit', function(e) {
  e.preventDefault();

  const checked = document.querySelectorAll('input[name="gejala_terpilih[]"]:checked');
  if (checked.length === 0) {
    alert("Silakan pilih minimal satu gejala!");
    return;
  }

  const formData = new FormData(this);

  fetch('proses_ajax.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('printArea').innerHTML = data;
    const modal = new bootstrap.Modal(document.getElementById('modalHasil'));
    modal.show();
  })
  .catch(error => {
    alert("Terjadi kesalahan: " + error);
  });
});
</script>

<script>
  document.getElementById('btnTutupModal').addEventListener('click', function () {
    // Tampilkan spinner preloader
    const spinner = document.querySelector('.spinner-wrapper');
    if (spinner) spinner.style.display = 'flex';

    // Setelah 1.5 detik, reload halaman
    setTimeout(() => {
      location.reload();
    }, 1500);
  });
</script>

</body>
</html>
