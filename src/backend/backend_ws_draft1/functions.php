<?php
require 'connect.php';

// FUNCTION 1: Hitung Durasi (Wajib)
function hitungDurasi($masuk, $keluar) {
    $tgl1 = new DateTime($masuk);
    $tgl2 = new DateTime($keluar);
    $selisih = $tgl1->diff($tgl2);
    return $selisih->days;
}

// FUNCTION 2: Cek Noken (Fitur Unik - Pembatasan)
function cekNokenPenuh($id_user, $conn) {
    // Hitung berapa izin yang statusnya masih 'menunggu_sidang'
    $query = mysqli_query($conn, "SELECT count(*) as total FROM perizinan WHERE id_user = '$id_user' AND status = 'menunggu_sidang'");
    $data = mysqli_fetch_assoc($query);
    
    // Jika sudah ada 3 pengajuan pending, return true (penuh)
    if ($data['total'] >= 3) {
        return true;
    }
    return false;
}

// FORMAT RUPIAH
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>
