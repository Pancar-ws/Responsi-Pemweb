<?php
require 'includes/db.php';
$navbar_style = 'background-color: #002f32;';
$extra_css = 'detail.css';

// Ambil ID dari URL
$id = $_GET['id'];
$tour = query("SELECT * FROM tours WHERE id = $id")[0];

// Proses Booking
if(isset($_POST['book'])) {
    session_start();
    if(!isset($_SESSION['user_id'])) {
        echo "<script>alert('Harap login dulu!'); window.location='login.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $tour_id = $id;
    $date = $_POST['date'];
    $pax = $_POST['pax'];
    $total = $tour['price'] * $pax;
    $inv = 'INV-' . time();
    $status = 'pending';

    // Insert ke tabel Orders
    $query = "INSERT INTO orders VALUES (NULL, '$inv', '$user_id', '$tour_id', '$date', '$pax', '$total', 'ktp_dummy.jpg', '$status', NOW())";
    
    if(mysqli_query($conn, $query)) {
        // Simpan ID invoice ke session untuk halaman payment
        $_SESSION['last_invoice'] = $inv;
        header("Location: payment.php");
    } else {
        echo mysqli_error($conn);
    }
}

$page_title = $tour['name'];
include 'includes/header.php';
?>

<section class="detail-container">
    <div class="main-content">
        <div class="breadcrumb">
            <a href="index.php">Home</a> &gt; <a href="search.php">Pencarian</a> &gt; <span><?= $tour['name'] ?></span>
        </div>
        
        <h1 class="tour-title"><?= $tour['name'] ?></h1>
        <div class="tour-meta">
            <span>📍 <?= $tour['location'] ?></span> • 
            <span>🏷️ <?= $tour['type'] ?></span> • 
            <span>⭐ <?= $tour['rating'] ?></span>
        </div>
        
        <div class="gallery">
            <div class="main-image"><img src="assets/img/<?= $tour['image_url'] ?>" alt="Foto Utama"></div>
        </div>
        
        <div class="description-box">
            <h3>Tentang Perjalanan Ini</h3>
            <p><?= nl2br($tour['description']) ?></p>
            <hr>
            <h3>Fasilitas</h3>
            <ul class="check-list"><li>Transportasi</li><li>Penginapan</li><li>Makan 3x</li><li>Tiket Masuk</li></ul>
            <hr>
            <div class="warning-box"><strong>⚠️ Syarat Dokumen:</strong><p>Wajib melampirkan KTP/Paspor.</p></div>
        </div>
    </div>

    <aside class="booking-sidebar">
        <div class="booking-card">
            <div class="price-tag">
                <p>Mulai dari</p>
                <h2>Rp <?= number_format($tour['price'],0,',','.') ?></h2>
                <span>per orang</span>
            </div>
            
            <form class="booking-form" method="POST">
                <div class="form-group"><label>Tanggal Keberangkatan</label><input type="date" name="date" required></div>
                <div class="form-group"><label>Jumlah Peserta</label><input type="number" min="1" value="1" name="pax" required></div>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button type="submit" name="book" class="btn-book-now">Pesan Sekarang</button>
                <?php else: ?>
                    <a href="login.php" class="btn-book-now" style="text-align:center; display:block; background: gray;">Login untuk Pesan</a>
                <?php endif; ?>
                
                <p class="secure-note">🔒 Pembayaran Aman via Midtrans</p>
            </form>
        </div>
    </aside>
</section>

<?php include 'includes/footer.php'; ?>