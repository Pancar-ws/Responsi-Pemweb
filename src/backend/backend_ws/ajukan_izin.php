<?php
session_start();
require 'connect.php';
require 'functions.php';

// 1. Cek Login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'pendatang') {
    header("Location: login.php");
    exit;
}

// 2. Ambil Data Wilayah
$id_wilayah = $_GET['id'];
$query_wilayah = mysqli_query($conn, "SELECT * FROM wilayah_adat WHERE id_wilayah = $id_wilayah");
$data = mysqli_fetch_assoc($query_wilayah);

// 3. Cek Musim (Interaksi Dinamis)
$is_badai = ($data['kondisi_alam'] == 'badai');

// LOGIKA SUBMIT
if (isset($_POST['ajukan'])) {
    $id_user = $_SESSION['id_user'];
    
    // 4. Cek Noken (Core Mechanic)
    if (cekNokenPenuh($id_user, $conn)) {
        echo "<script>alert('Noken Anda Penuh! Selesaikan dulu izin yang pending.');</script>";
    } else {
        $masuk = $_POST['tgl_masuk'];
        $keluar = $_POST['tgl_keluar'];
        
        // Validasi Tanggal
        if ($masuk > $keluar) {
            echo "<script>alert('Tanggal pulang tidak boleh mendahului datang!');</script>";
        } else {
            $durasi = hitungDurasi($masuk, $keluar);
            $total = $durasi * $data['retribusi_adat'];

            $query = "INSERT INTO perizinan VALUES (NULL, '$id_user', '$id_wilayah', '$masuk', '$keluar', '$total', 'menunggu_sidang')";
            mysqli_query($conn, $query);

            echo "<script>alert('Permohonan izin terkirim ke Kepala Suku!'); window.location='index.php';</script>";
        }
    }
}
?>

<!-- TAMPILAN -->
<h2>Ajukan Izin Masuk: <?= $data['nama_wilayah']; ?></h2>

<?php if ($is_badai) : ?>
    <!-- Interaksi Dinamis: Blokir jika Badai -->
    <div style="background:red; color:white; padding:10px;">
        WARNING: Wilayah ini sedang dalam MUSIM BADAI. Kepala Suku menutup akses sementara.
    </div>
<?php else : ?>
    <!-- Form Aktif -->
    <form action="" method="post">
        <label>Tanggal Masuk Wilayah</label>
        <input type="date" name="tgl_masuk" required>
        
        <label>Tanggal Keluar</label>
        <input type="date" name="tgl_keluar" required>
        
        <p>Retribusi Adat: <?= formatRupiah($data['retribusi_adat']); ?> / malam</p>
        
        <button type="submit" name="ajukan">Serahkan Upeti & Ajukan</button>
    </form>
<?php endif; ?>