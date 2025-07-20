<?php
include '../../koneksi.php';

$id = $_POST['id'] ?? '';

if ($id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM gejala WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menghapus data.']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'ID tidak valid.']);
}
?>
