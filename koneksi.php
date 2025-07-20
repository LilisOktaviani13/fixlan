<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lan";

$conn = new mysqli($host, $user, $pass, $db);
date_default_timezone_set('Asia/Jakarta');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
