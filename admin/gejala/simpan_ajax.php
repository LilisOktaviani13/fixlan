<?php
include '../../koneksi.php';

$kode = $_POST['kode_gejala'] ?? '';
$nama = $_POST['nama_gejala'] ?? '';

if ($kode && $nama) {
    $stmt = mysqli_prepare($conn, "INSERT INTO gejala (kode_gejala, nama_gejala) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $kode, $nama);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan ke database.']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Data tidak lengkap.']);
}
?>
