<?php
session_start();
include '../../koneksi.php';

if ($_SESSION['status'] != "login") {
  echo json_encode(['status' => 'unauthorized']);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']);

  $query = "DELETE FROM gangguan WHERE id = $id";
  if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'error', 'msg' => mysqli_error($conn)]);
  }
} else {
  echo json_encode(['status' => 'invalid']);
}
?>
