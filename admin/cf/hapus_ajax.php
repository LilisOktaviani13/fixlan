<?php
include '../../koneksi.php';
$id = $_POST['id'];
$query = mysqli_query($conn, "DELETE FROM cf WHERE id='$id'");
if ($query) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'msg' => 'Gagal hapus']);
}
?>
