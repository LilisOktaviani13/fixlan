<?php
session_start();
include '../../koneksi.php';
header('Content-Type: application/json');

$query = mysqli_query($conn, "DELETE FROM about LIMIT 1");

if ($query) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error']);
}
