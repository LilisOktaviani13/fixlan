<?php
include '../../koneksi.php';

$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$role = mysqli_real_escape_string($conn, $_POST['role']);

// Validasi input kosong
if (empty($nama) || empty($username) || empty($password) || empty($role)) {
    echo json_encode(['status' => 'error', 'msg' => 'Semua field wajib diisi.']);
    exit;
}

// Cek apakah username sudah dipakai
$cek = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
if (mysqli_num_rows($cek) > 0) {
    echo json_encode(['status' => 'error', 'msg' => 'Username sudah terdaftar.']);
    exit;
}

// Enkripsi password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$query = mysqli_query($conn, "INSERT INTO user (nama, username, password, role) 
                              VALUES ('$nama', '$username', '$hash', '$role')");

if ($query) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan data.']);
}
?>
