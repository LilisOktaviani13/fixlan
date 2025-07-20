<?php
include '../../koneksi.php';

$id = $_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(['status' => 'error', 'msg' => 'ID tidak valid.']);
    exit;
}

$query = mysqli_query($conn, "DELETE FROM user WHERE id = '$id'");

if ($query) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Gagal menghapus data.']);
}
?>
