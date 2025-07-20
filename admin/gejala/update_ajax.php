<?php
include '../../koneksi.php';

$id = $_POST['id'] ?? '';
$kode = $_POST['kode_gejala'] ?? '';
$nama = $_POST['nama_gejala'] ?? '';

if ($id && $kode && $nama) {
    $stmt = mysqli_prepare($conn, "UPDATE gejala SET kode_gejala=?, nama_gejala=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $kode, $nama, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal memperbarui data.']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Data tidak lengkap untuk update.']);
}
?>
