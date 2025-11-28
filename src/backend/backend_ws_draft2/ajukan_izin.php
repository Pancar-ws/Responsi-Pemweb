<?php
session_start();
require_once 'connect.php';
require_once 'functions.php';

// 1. Cek Login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'pendatang') {
    header("Location: login.php");
    exit;
}

// 2. Validasi ID URL (PENTING AGAR TIDAK ERROR)
if (!isset($_GET['id'])) {
    echo "ERROR: Pilih wilayah dulu dari halaman <a href='index.php'>Depan</a>.";
    exit;
}

$id_wilayah = $_GET['id'];
$query_wilayah = mysqli_query($conn, "SELECT * FROM wilayah_adat WHERE id_wilayah = $id_wilayah");
$data = mysqli_fetch_assoc($query_wilayah);

// 3. Proses Transaksi
if (isset($_POST['ajukan'])) {
    $id_user = $_SESSION['id_user'];
    
    // Cek Noken
    if (cekNokenPenuh($id_user, $conn)) {
        echo "<script>alert('Noken Penuh! (Maks 3)');</script>";
    } else {
        $masuk = $_POST['tgl_masuk'];
        $keluar = $_POST['tgl_keluar'];
        
        if ($masuk > $keluar) {
            echo "<script>alert('Tanggal Invalid!');</script>";
        } else {
            $durasi = hitungDurasi($masuk, $keluar);
            $total = $durasi * $data['retribusi_adat'];

            $q = "INSERT INTO perizinan VALUES (NULL, '$id_user', '$id_wilayah', '$masuk', '$keluar', '$total', 'menunggu_sidang')";
            
            if(mysqli_query($conn, $q)) {
                echo "<script>alert('Berhasil!'); window.location='index.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<h3>Minta Izin Masuk: <?= $data['nama_wilayah']; ?></h3>
<?php if($data['kondisi_alam'] == 'badai'): ?>
    <h2 style="color:red">STOP! SEDANG BADAI.</h2>
    <a href="index.php">Kembali</a>
<?php else: ?>
    <form method="post">
        Masuk: <input type="date" name="tgl_masuk" required><br>
        Keluar: <input type="date" name="tgl_keluar" required><br>
        Upeti: <?= formatRupiah($data['retribusi_adat']); ?> /malam<br>
        <button type="submit" name="ajukan">Ajukan Izin</button>
    </form>
<?php endif; ?>