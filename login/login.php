<?php
session_start();
include '../koneksi.php';
$_SESSION['id'] = $row['id']; // pastikan kolom 'id' ada di tabel user
$username = $_POST['username'];
$password = md5($_POST['password']); // ini yang digunakan untuk dicocokkan

echo "Username: $username<br>";
echo "Password MD5: $password<br>";

// Cek user
$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION['username'] = $row['username'];
    $_SESSION['nama']     = $row['nama'];
    $_SESSION['role']     = $row['role'];
    $_SESSION['status']   = "login";

    if ($row['role'] === 'admin') {
        header("Location: ../admin/home/index.php");
    } else {
        header("Location: ../user/home/index.php");
    }
    exit;
} else {
    $_SESSION['login_error'] = "Username atau password salah!";
    header("Location: index.php");
    exit;
}
?>
