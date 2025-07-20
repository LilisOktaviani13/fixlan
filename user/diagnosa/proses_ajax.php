<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    exit("Unauthorized access.");
}

if (!isset($_POST['gejala_terpilih'])) {
    exit("Tidak ada gejala yang dipilih.");
}

$gejala_terpilih = $_POST['gejala_terpilih'];
$nama_gejala_terpilih = [];

// Ambil nama gejala
foreach ($gejala_terpilih as $id_gejala) {
    $g = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_gejala FROM gejala WHERE id = '$id_gejala'"));
    $nama_gejala_terpilih[] = $g['nama_gejala'];
}

$hasil_diagnosa = [];

$gangguan_query = mysqli_query($conn, "SELECT * FROM gangguan");

while ($gangguan = mysqli_fetch_assoc($gangguan_query)) {
    $id_gangguan = $gangguan['id'];
    $cf_values = [];

    foreach ($gejala_terpilih as $id_gejala) {
        $cf_query = mysqli_query($conn, "SELECT * FROM cf WHERE id_gangguan = '$id_gangguan' AND id_gejala = '$id_gejala'");
        if (mysqli_num_rows($cf_query) > 0) {
            $cf_data = mysqli_fetch_assoc($cf_query);
            $cf = $cf_data['mb'] - $cf_data['md'];
            $cf_values[] = $cf;
        }
    }

    if (count($cf_values) > 0) {
        $cf_combine = $cf_values[0];
        for ($i = 1; $i < count($cf_values); $i++) {
            $cf_combine = $cf_combine + $cf_values[$i] * (1 - $cf_combine);
        }

        $hasil_diagnosa[] = [
            'nama_gangguan'    => $gangguan['nama_gangguan'],
            'cf'               => round($cf_combine * 100, 2),
            'detail_gangguan'  => $gangguan['detail_gangguan'],
            'saran'            => $gangguan['saran']
        ];
    }
}

// Urutkan berdasarkan CF tertinggi
usort($hasil_diagnosa, function ($a, $b) {
    return $b['cf'] <=> $a['cf'];
});

// Simpan ke riwayat jika belum ada
if (count($hasil_diagnosa) > 0) {
    $id_user = $_SESSION['id'];
    $tanggal = date('Y-m-d H:i:s');

    $nama_gangguan = $hasil_diagnosa[0]['nama_gangguan'];
    $cf = $hasil_diagnosa[0]['cf'];
    $detail = $hasil_diagnosa[0]['detail_gangguan'];
    $saran = $hasil_diagnosa[0]['saran'];

    sort($nama_gejala_terpilih);
    $gejala_str = implode(', ', $nama_gejala_terpilih);

    $cek_query = mysqli_query($conn, "SELECT * FROM riwayat 
        WHERE id_user='$id_user' 
        AND nama_gangguan='$nama_gangguan' 
        AND persentase_cf='$cf'
        AND gejala_terpilih='$gejala_str'
        AND DATE(tanggal_diagnosa) = CURDATE()
        AND HOUR(tanggal_diagnosa) = HOUR('$tanggal')
        AND MINUTE(tanggal_diagnosa) = MINUTE('$tanggal')");

    if (mysqli_num_rows($cek_query) === 0) {
        mysqli_query($conn, "INSERT INTO riwayat 
            (id_user, tanggal_diagnosa, nama_gangguan, persentase_cf, gejala_terpilih, detail_gangguan, saran)
            VALUES (
                '$id_user',
                '$tanggal',
                '$nama_gangguan',
                '$cf',
                '$gejala_str',
                '$detail',
                '$saran'
            )");
    }
}

// Tampilkan hasil diagnosa
if (count($hasil_diagnosa) > 0):
?>
    <h5>Gejala yang Dipilih:</h5>
    <ul>
        <?php foreach ($nama_gejala_terpilih as $g): ?>
            <li><?= htmlspecialchars($g) ?></li>
        <?php endforeach; ?>
    </ul>

    <h5 class="mt-4">Gangguan Teridentifikasi:</h5>
    <p><strong>Nama Gangguan:</strong> <?= htmlspecialchars($hasil_diagnosa[0]['nama_gangguan']) ?></p>
    <p><strong>Persentase Kepastian:</strong> <?= $hasil_diagnosa[0]['cf'] ?>%</p>
    <p><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($hasil_diagnosa[0]['detail_gangguan'])) ?></p>
    <p><strong>Saran:</strong><br><?= nl2br(htmlspecialchars($hasil_diagnosa[0]['saran'])) ?></p>
<?php else: ?>
    <div class="alert alert-warning">Tidak ditemukan gangguan berdasarkan gejala yang dipilih.</div>
<?php endif; ?>
