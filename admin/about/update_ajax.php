<?php
include '../../koneksi.php';
$id          = $_POST['id'];
$id_gangguan = $_POST['id_gangguan'];
$id_gejala   = $_POST['id_gejala'];
$mb          = $_POST['mb'];
$md          = $_POST['md'];

$query = mysqli_query($conn, "UPDATE cf SET id_gangguan='$id_gangguan', id_gejala='$id_gejala', mb='$mb', md='$md' WHERE id='$id'");
if ($query) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'msg' => 'Gagal update']);
}
?>
