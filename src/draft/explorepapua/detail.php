<?php
require 'includes/db.php';

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
            <span id="tourType">🏷️ <?= escape($tour['type']) ?></span> • 
            <span id="tourRating">⭐ <?= $tour['rating'] ?></span>
        </div>
        
        <div class="gallery">
            <div class="main-image">
                <img id="mainImg" src="<?= escape($tour['image_url']) ?>" alt="<?= escape($tour['name']) ?>" onerror="this.src='https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?q=80&w=2070'">
            </div>
            <div class="thumbnails">
                <img src="https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?q=80&w=2070" class="thumb active" onclick="changeImage(this)">
                <img src="https://images.unsplash.com/photo-1544551763-46a8723ba3f9?w=600" class="thumb" onclick="changeImage(this)">
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
            
            <form class="booking-form" onsubmit="handleBooking(event)">
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