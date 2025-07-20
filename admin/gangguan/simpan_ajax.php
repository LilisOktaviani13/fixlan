<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id     = $_POST['id'];
  $kode   = $_POST['kode_gangguan'];
  $nama   = $_POST['nama_gangguan'];
  $detail = $_POST['detail_gangguan'];
  $saran  = $_POST['saran'];

  $sql = "UPDATE gangguan SET 
            kode_gangguan = '$kode',
            nama_gangguan = '$nama',
            detail_gangguan = '$detail',
            saran = '$saran' 
          WHERE id = '$id'";

  if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
  }
}
