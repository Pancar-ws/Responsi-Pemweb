<?php
require 'includes/db.php';
$navbar_style = 'background-color: #002f32;';
$extra_css = 'detail.css';

// Ambil ID dari URL dengan validasi
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: search.php");
    exit;
}

$id = (int) $_GET['id'];
$tour = getTourById($id);

// Jika tour tidak ditemukan
if(!$tour) {
    echo "<script>alert('Tour tidak ditemukan!'); window.location='search.php';</script>";
    exit;
}

// Proses Booking
if(isset($_POST['book'])) {
    if(!isset($_SESSION['user_id'])) {
        echo "<script>alert('Harap login dulu!'); window.location='login.php';</script>";
        exit;
    }

    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $pax = (int) $_POST['pax'];
    
    // Validasi input
    if(!validateBookingDate($date)) {
        echo "<script>alert('Tanggal booking tidak valid! Tidak boleh tanggal yang sudah lewat.');</script>";
    } else if($pax < 1 || $pax > 50) {
        echo "<script>alert('Jumlah peserta harus antara 1-50 orang!');</script>";
    } else {
        // Buat order menggunakan function
        $order_data = [
            'user_id' => $_SESSION['user_id'],
            'tour_id' => $id,
            'booking_date' => $date,
            'pax_count' => $pax,
            'total_price' => $tour['price'] * $pax
        ];
        
        $invoice = createOrder($order_data);
        
        if($invoice) {
            $_SESSION['last_invoice'] = $invoice;
            header("Location: payment.php");
            exit;
        } else {
            echo "<script>alert('Gagal membuat pesanan! Silakan coba lagi.');</script>";
        }
    }
}

$page_title = $tour['name'];
include 'includes/header.php';
?>

<section class="detail-container">
    <div class="main-content">
        <div class="breadcrumb">
            <a href="index.php">Home</a> &gt; <a href="search.php">Pencarian</a> &gt; <span><?= escape($tour['name']) ?></span>
        </div>
        
        <h1 class="tour-title"><?= escape($tour['name']) ?></h1>
        <div class="tour-meta">
            <span>📍 <?= escape($tour['location']) ?></span> • 
            <span>🏷️ <?= escape($tour['type']) ?></span> • 
            <span>⭐ <?= $tour['rating'] ?></span>
        </div>
        
        <div class="gallery">
            <div class="main-image"><img src="assets/img/<?= escape($tour['image_url']) ?>" alt="<?= escape($tour['name']) ?>"></div>
        </div>
        
        <div class="description-box">
            <h3>Tentang Perjalanan Ini</h3>
            <p><?= nl2br(escape($tour['description'])) ?></p>
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
                <h2><?= formatRupiah($tour['price']) ?></h2>
                <span>per orang</span>
            </div>
            
            <form class="booking-form" method="POST">
                <div class="form-group">
                    <label>Tanggal Keberangkatan</label>
                    <input type="date" name="date" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Peserta</label>
                    <input type="number" min="1" max="50" value="1" name="pax" required>
                </div>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <button type="submit" name="book" class="btn-book-now">Pesan Sekarang</button>
                <?php else: ?>
                    <a href="login.php" class="btn-book-now" style="text-align:center; display:block; background: gray;">Login untuk Pesan</a>
                <?php endif; ?>
                
                <p class="secure-note">🔒 Pembayaran Aman</p>
            </form>
        </div>
    </aside>
</section>

<?php include 'includes/footer.php'; ?>