<?php
session_start();
include '../../koneksi.php';

$nama = $_POST['nama_sistem'];
$spk  = $_POST['definisi_spakar'];
$peny = $_POST['definisi_penyakit'];
$cf   = $_POST['definisi_cf'];
$lan  = $_POST['definisi_lan'];
$tr   = $_POST['definisi_tr'];

$query = mysqli_query($conn, "SELECT * FROM about");
if (mysqli_num_rows($query) > 0) {
    $update = mysqli_query($conn, "UPDATE about SET 
        nama_sistem='$nama',
        definisi_spakar='$spk',
        definisi_penyakit='$peny',
        definisi_cf='$cf',
        definisi_lan='$lan',
        definisi_tr='$tr' 
        LIMIT 1");
    echo json_encode(['status' => $update ? 'success' : 'error', 'msg' => $update ? 'Berhasil diperbarui' : 'Gagal memperbarui']);
} else {
    $insert = mysqli_query($conn, "INSERT INTO about 
        (nama_sistem, definisi_spakar, definisi_penyakit, definisi_cf, definisi_lan, definisi_tr) 
        VALUES ('$nama','$spk','$peny','$cf','$lan','$tr')");
    echo json_encode(['status' => $insert ? 'success' : 'error', 'msg' => $insert ? 'Berhasil ditambahkan' : 'Gagal menambahkan']);
}
?>
