<?php
session_start();
require_once 'connect.php';
require_once 'functions.php';

$query = mysqli_query($conn, "SELECT * FROM wilayah_adat");
?>

<h1>Permisi Papua (Backend View)</h1>
<?php if(isset($_SESSION['login'])): ?>
    <p>Halo, <?= $_SESSION['nama_lengkap']; ?> (<?= $_SESSION['role']; ?>) | <a href="logout.php">Logout</a></p>
<?php else: ?>
    <a href="login.php">Login</a>
<?php endif; ?>

<hr>

<table border="1" cellpadding="10">
    <tr><th>Wilayah</th><th>Status</th><th>Harga</th><th>Aksi</th></tr>
    <?php while ($row = mysqli_fetch_assoc($query)) : ?>
    <tr>
        <td><?= $row['nama_wilayah']; ?></td>
        <td><?= $row['kondisi_alam']; ?></td>
        <td><?= formatRupiah($row['retribusi_adat']); ?></td>
        <td>
            <?php if($row['kondisi_alam'] == 'aman'): ?>
                <a href="ajukan_izin.php?id=<?= $row['id_wilayah']; ?>">Ajukan Izin</a>
            <?php else: ?>
                TUTUP (Bahaya)
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>