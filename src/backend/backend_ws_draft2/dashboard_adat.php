<?php
session_start(); // INI WAJIB NYALA
require_once 'connect.php'; // Pakai connect.php
require_once 'functions.php';

// Proteksi: Tendang jika bukan Kepala Suku
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'kepala_suku') {
    echo "AKSES DITOLAK. <a href='login.php'>Login disini</a>";
    exit;
}

// LOGIKA 1: TERIMA IZIN
if (isset($_GET['terima'])) {
    $id_izin = $_GET['terima'];
    mysqli_query($conn, "UPDATE perizinan SET status='diizinkan' WHERE id_izin='$id_izin'");
    echo "<script>alert('Izin diberikan!'); window.location='dashboard_adat.php';</script>";
}

// LOGIKA 2: UPDATE MUSIM
if (isset($_POST['update_musim'])) {
    $id_wil = $_POST['id_wilayah'];
    $status_baru = $_POST['status_alam'];
    mysqli_query($conn, "UPDATE wilayah_adat SET kondisi_alam='$status_baru' WHERE id_wilayah='$id_wil'");
    echo "<script>alert('Status Alam Diperbarui!'); window.location='dashboard_adat.php';</script>";
}

// Ambil Data untuk View
$data_izin = mysqli_query($conn, "SELECT p.*, u.nama_lengkap, w.nama_wilayah 
                                  FROM perizinan p 
                                  JOIN users u ON p.id_user = u.id_user 
                                  JOIN wilayah_adat w ON p.id_wilayah = w.id_wilayah 
                                  ORDER BY p.id_izin DESC");
$data_wilayah = mysqli_query($conn, "SELECT * FROM wilayah_adat");
?>

<!-- UI Sederhana Backend -->
<h1>Dashboard Kepala Suku (<?= $_SESSION['nama_lengkap']; ?>)</h1>
<a href="logout.php">[Keluar]</a>

<h3>1. Kontrol Alam</h3>
<table border="1" cellpadding="10">
    <tr><th>Wilayah</th><th>Status</th><th>Aksi</th></tr>
    <?php while ($w = mysqli_fetch_assoc($data_wilayah)) : ?>
    <tr>
        <td><?= $w['nama_wilayah']; ?></td>
        <td><?= $w['kondisi_alam']; ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="id_wilayah" value="<?= $w['id_wilayah']; ?>">
                <select name="status_alam">
                    <option value="aman">Aman</option>
                    <option value="badai">Badai</option>
                </select>
                <button type="submit" name="update_musim">Update</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>2. Sidang Perizinan</h3>
<table border="1" cellpadding="10">
    <tr><th>Pendatang</th><th>Tujuan</th><th>Tgl</th><th>Upeti</th><th>Status</th><th>Aksi</th></tr>
    <?php while ($row = mysqli_fetch_assoc($data_izin)) : ?>
    <tr>
        <td><?= $row['nama_lengkap']; ?></td>
        <td><?= $row['nama_wilayah']; ?></td>
        <td><?= $row['tgl_masuk']; ?> s/d <?= $row['tgl_keluar']; ?></td>
        <td><?= formatRupiah($row['total_retribusi']); ?></td>
        <td><?= $row['status']; ?></td>
        <td>
            <?php if ($row['status'] == 'menunggu_sidang') : ?>
                <a href="?terima=<?= $row['id_izin']; ?>"> [IZINKAN] </a>
            <?php else : ?>
                Selesai
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>