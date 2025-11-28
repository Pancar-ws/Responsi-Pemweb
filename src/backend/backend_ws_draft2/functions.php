<?php
// Gunakan require_once agar tidak crash jika dipanggil 2x
require_once 'connect.php';

function hitungDurasi($masuk, $keluar) {
    $tgl1 = new DateTime($masuk);
    $tgl2 = new DateTime($keluar);
    $selisih = $tgl1->diff($tgl2);
    return $selisih->days;
}

function cekNokenPenuh($id_user, $conn) {
    $query = mysqli_query($conn, "SELECT count(*) as total FROM perizinan WHERE id_user = '$id_user' AND status = 'menunggu_sidang'");
    $data = mysqli_fetch_assoc($query);
    
    // Logika: Jika >= 3, return TRUE (Penuh)
    return ($data['total'] >= 3);
}

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>