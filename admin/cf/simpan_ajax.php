<?php
include '../../koneksi.php';
$id_gangguan = $_POST['id_gangguan'];
$id_gejala   = $_POST['id_gejala'];
$mb          = $_POST['mb'];
$md          = $_POST['md'];

$query = mysqli_query($conn, "INSERT INTO cf (id_gangguan, id_gejala, mb, md) VALUES ('$id_gangguan', '$id_gejala', '$mb', '$md')");
if ($query) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan']);
}
?>
