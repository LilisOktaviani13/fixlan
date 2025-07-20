<?php
include '../../koneksi.php';
session_start();

if ($_SESSION['status'] != 'login') {
  echo "<p>Unauthorized</p>";
  exit;
}

$id = $_GET['id'];
$id_user = $_SESSION['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM riwayat WHERE id='$id' AND id_user='$id_user'"));

if (!$data) {
  echo "<p>Data tidak ditemukan.</p>";
  exit;
}
?>

<div id="printArea">
  <h4 class="mb-3">Informasi Diagnosa</h4>
  <p><strong>Tanggal Diagnosa:</strong> <?= date('d/m/Y H:i', strtotime($data['tanggal_diagnosa'])); ?></p>
  <p><strong>Nama Gangguan:</strong> <?= htmlspecialchars($data['nama_gangguan']); ?></p>
  <p><strong>Persentase Kepastian (CF):</strong> <?= $data['persentase_cf']; ?>%</p>
  <p><strong>Gejala yang Dipilih:</strong><br><?= nl2br(htmlspecialchars($data['gejala_terpilih'])); ?></p>
  <p><strong>Deskripsi Gangguan:</strong><br><?= nl2br(htmlspecialchars($data['detail_gangguan'])); ?></p>
  <p><strong>Saran Penanganan:</strong><br><?= nl2br(htmlspecialchars($data['saran'])); ?></p>
</div>
