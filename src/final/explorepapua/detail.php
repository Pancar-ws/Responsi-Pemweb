<?php
require 'includes/db.php';
require 'functions/functions.php';

// Handle booking form submission
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_tour'])) {
    session_start();
    
    // Validasi user sudah login
    if(!isset($_SESSION['user_id'])) {
        echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
        exit;
    }
    
    $tour_id = (int) $_POST['tour_id'];
    $booking_date = mysqli_real_escape_string($conn, $_POST['date']);
    $pax_count = (int) $_POST['pax'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $user_id = $_SESSION['user_id'];
    
    // Ambil harga tour
    $tour = getTourById($tour_id);
    if(!$tour) {
        echo "<script>alert('Tour tidak ditemukan!'); window.location='search.php';</script>";
        exit;
    }
    
    $total_price = $tour['price'] * $pax_count;
    $invoice_number = 'INV-' . date('Ymd') . '-' . substr(uniqid(), -6);
    
    // Insert order ke database
    $query = "INSERT INTO orders (invoice_number, user_id, tour_id, booking_date, pax_count, total_price, status) 
              VALUES ('$invoice_number', $user_id, $tour_id, '$booking_date', $pax_count, $total_price, 'pending')";
    
    if(mysqli_query($conn, $query)) {
        $_SESSION['last_invoice'] = $invoice_number;
        header("Location: payment.php");
        exit;
    } else {
        echo "<script>alert('Gagal membuat pesanan!'); window.location='detail.php?id=$tour_id';</script>";
        exit;
    }
}

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

$page_title = $tour['name'];
$hide_navbar = true; // Hide default navbar, we'll create custom one
$extra_css = 'detail.css';
$extra_js = 'detail.js';
include 'includes/header.php';
?>

<!-- Custom Navbar for Detail Page -->
<nav class="navbar" id="navbar" style="background-color: #002f32;">
    <a href="index.php" class="logo" style="text-decoration:none; color:inherit;">Explore Papua</a>
    <div class="menu-toggle" id="mobile-menu"><span class="bar"></span><span class="bar"></span><span class="bar"></span></div>
    <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="search.php">Cari Paket</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <li><a href="admin.php">Admin Panel</a></li>
            <?php else: ?>
                <li><a href="dashboard.php">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="logout.php" class="btn-login-mobile">Keluar</a></li>
        <?php else: ?>
            <li><a href="login.php" class="btn-login-mobile">Masuk</a></li>
        <?php endif; ?>
    </ul>
    <?php if(!isset($_SESSION['user_id'])): ?>
        <div class="nav-actions"><a href="login.php" class="btn-login">Masuk</a></div>
    <?php endif; ?>
</nav>

<section class="detail-container">
    <div class="main-content">
        <div class="breadcrumb">
            <a href="index.php">Home</a> &gt; <a href="search.php">Pencarian</a> &gt; <span id="breadcrumbName"><?= escape($tour['name']) ?></span>
        </div>
        
        <h1 class="tour-title" id="tourTitle"><?= escape($tour['name']) ?></h1>
        <div class="tour-meta">
            <span id="tourLocation">📍 <?= escape($tour['location']) ?></span> • 
            <span id="tourRating">⭐ <?= $tour['rating'] ?></span>
        </div>
        
        <?php
        // Badge besar untuk tipe paket
        $typeColor = '#FF9800'; // Default Orange
        $typeIcon = '🎒';
        $typeLabel = 'OPEN TRIP';
        $typeDesc = 'Paket Gabungan - Harga Terjangkau';
        if($tour['type'] == 'Private') {
            $typeColor = '#2196F3'; // Blue
            $typeIcon = '👥';
            $typeLabel = 'PRIVATE TRIP';
            $typeDesc = 'Paket Eksklusif - Privasi Maksimal';
        } elseif($tour['type'] == 'Customized') {
            $typeColor = '#4CAF50'; // Green
            $typeIcon = '⚙️';
            $typeLabel = 'CUSTOMIZED TRIP';
            $typeDesc = 'Paket Custom - Sesuai Keinginan Anda';
        }
        ?>
        <div style="margin: 15px 0; padding: 15px; background: <?= $typeColor ?>15; border-left: 5px solid <?= $typeColor ?>; border-radius: 8px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="font-size: 2rem;"><?= $typeIcon ?></div>
                <div>
                    <div style="font-size: 1.1rem; font-weight: bold; color: <?= $typeColor ?>; margin-bottom: 4px;">
                        <?= $typeLabel ?>
                    </div>
                    <div style="font-size: 0.9rem; color: #666;">
                        <?= $typeDesc ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="gallery">
            <?php
            // Foto utama berbeda untuk setiap tour ID (Foto 1)
            $mainImages = [
                1 => 'https://images.pexels.com/photos/15416579/pexels-photo-15416579.jpeg', // Raja Ampat
                2 => 'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?q=80&w=1470', // Baliem Valley
                3 => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2070', // Whale Shark
                4 => 'https://media.gettyimages.com/id/689863862/photo/marine-life-of-raja-ampat-west-papua-indonesia.jpg?s=612x612&w=0&k=20&c=oBevIMfzcXvIcgsDApKd8DAPgq2dvZ18yYxox7Pabc8=', // Premium Diving
                5 => 'https://images.pexels.com/photos/35172425/pexels-photo-35172425.jpeg', // Lake Sentani
                6 => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070', // Carstensz Mountain
                7 => 'https://thumbs.dreamstime.com/b/saltwater-crocodile-powerfully-splashes-muddy-river-papua-indonesia-breathtaking-moment-raw-natural-power-captured-402116631.jpg?w=992', // Lorentz Forest
                8 => 'https://images.pexels.com/photos/32507843/pexels-photo-32507843.jpeg'  // Biak Beach
            ];
            $mainImage = $mainImages[$tour['id']];
            ?>
            <div class="main-image">
                <img id="mainImg" src="<?= $mainImage ?>" alt="<?= escape($tour['name']) ?>">
            </div>
            <div class="thumbnails">
                <img src="<?= $mainImage ?>" class="thumb active" onclick="changeImage(this)">
                <?php
                // Gambar alternatif untuk setiap tour ID (Foto 2)
                $altImages = [
                    1 => 'https://images.pexels.com/photos/18080802/pexels-photo-18080802.jpeg', // Raja Ampat view 2
                    2 => 'https://cdn.pixabay.com/photo/2021/05/14/15/17/mountain-6253669_640.jpg', // Wamena traditional
                    3 => 'https://media.gettyimages.com/id/500719316/photo/photographer-and-shark.jpg?s=612x612&w=0&k=20&c=I-kfyGxtsSRWhPOibjsdVivdEDQ-sv-Ecxzvgjex1z8=', // Whale shark swimming
                    4 => 'https://images.pexels.com/photos/30929079/pexels-photo-30929079.jpeg', // Diving underwater
                    5 => 'https://media.istockphoto.com/id/1656678305/id/foto/danau-imfote-pemandangan-indah-di-jayapura-papua-indonesia-bentuk-danau-ini-terlihat-seperti.jpg?s=612x612&w=0&k=20&c=jskR_ZcoFpDF0pajiZv_MK20HnFDgBzVYe2MGlvdBBU=', // Lake sunset
                    6 => 'https://images.pexels.com/photos/2346007/pexels-photo-2346007.jpeg', // Mountain climbing
                    7 => 'https://thumbs.dreamstime.com/b/lorentz-national-park-beautiful-flourishing-natural-heritage-unesco-ai-generated-ecological-indonesia-290037655.jpg?w=992', // Forest wildlife
                    8 => 'https://images.pexels.com/photos/35189572/pexels-photo-35189572.jpeg'  // Beach paradise
                ];
                $secondImage = $altImages[$tour['id']];
                ?>
                <img src="<?= $secondImage ?>" class="thumb" onclick="changeImage(this)">
            </div>
        </div>
        
        <div class="description-box">
            <h3>Tentang Perjalanan Ini</h3>
            <p id="tourDesc"><?= nl2br(escape($tour['description'])) ?></p>
            <hr>
            <h3>Fasilitas</h3>
            <ul class="check-list">
                <li>Transportasi</li>
                <li>Penginapan</li>
                <li>Makan 3x</li>
                <li>Tiket Masuk</li>
            </ul>
            <hr>
            <div class="warning-box">
                <strong>⚠️ Syarat Dokumen:</strong>
                <p>Wajib melampirkan KTP/Paspor untuk pengurusan Surat Jalan.</p>
            </div>
        </div>
    </div>

    <aside class="booking-sidebar">
        <div class="booking-card">
            <div class="price-tag">
                <p>Mulai dari</p>
                <h2 id="tourPrice" data-value="<?= $tour['price'] ?>"><?= formatRupiah($tour['price']) ?></h2>
                <span>per orang</span>
            </div>
            
            <form class="booking-form" method="POST" action="">
                <input type="hidden" name="book_tour" value="1">
                <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
                <div class="form-group">
                    <label>Tanggal Keberangkatan</label>
                    <input type="date" name="date" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Peserta</label>
                    <input type="number" min="1" max="50" value="1" id="paxCount" name="pax" required>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" placeholder="Sesuai KTP" required>
                </div>
                <div class="form-group file-upload">
                    <label>Upload KTP / Paspor</label>
                    <small>Format: JPG/PDF</small>
                    <input type="file" name="id_card" accept=".jpg,.png,.pdf" required>
                </div>
                <div class="total-price">
                    <span>Total:</span>
                    <strong id="totalPrice"><?= formatRupiah($tour['price']) ?></strong>
                </div>
                
                <button type="submit" class="btn-book-now">Pesan Sekarang</button>
                
                <p class="secure-note">🔒 Pembayaran Aman via Midtrans</p>
            </form>
        </div>
    </aside>
</section>

<?php include 'includes/footer.php'; ?>