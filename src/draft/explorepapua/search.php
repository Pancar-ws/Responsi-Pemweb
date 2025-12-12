<?php
require 'includes/db.php';
$page_title = 'Cari Paket - Explore Papua';
$extra_css = 'search.css';
$extra_js = 'search.js'; // Add JavaScript file
$hide_navbar = true; // Hide main navbar
include 'includes/header.php';

// Ambil semua data tours menggunakan function
$tours = getTours();
?>

<div class="simple-nav">
    <a href="index.php" class="btn-back">&larr; Kembali ke Beranda</a>
    <div class="logo-simple">Explore Papua</div>
</div>

<section class="search-layout">
    <aside class="sidebar">
        <div class="filter-box">
            <h3>Filter Harga</h3>
            <div class="range-group">
                <input type="range" min="1000000" max="20000000" step="500000" id="priceRange" value="20000000">
                <p>Maks: <span id="priceValue">Rp 20.000.000</span></p>
            </div>
        </div>
        <div class="filter-box">
            <h3>Lokasi</h3>
            <label class="checkbox-container"><input type="checkbox" class="location-filter" value="Raja Ampat"> Raja Ampat</label>
            <label class="checkbox-container"><input type="checkbox" class="location-filter" value="Wamena"> Wamena</label>
            <label class="checkbox-container"><input type="checkbox" class="location-filter" value="Nabire"> Nabire</label>
        </div>
    </aside>

    <main class="result-list" id="resultContainer">
        <!-- Render PHP Loop -->
        <?php if(count($tours) > 0): ?>
            <?php foreach($tours as $tour): ?>
            <div class="product-card-horizontal" data-price="<?= $tour['price'] ?>" data-location="<?= escape($tour['location']) ?>">
                <div class="product-img">
                    <img src="assets/img/<?= escape($tour['image_url']) ?>" 
                         alt="<?= escape($tour['name']) ?>" 
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?q=80&w=600&auto=format&fit=crop';">
                </div>
                <div class="product-details">
                    <div>
                        <h2 class="product-title"><?= escape($tour['name']) ?></h2>
                        <p class="product-meta">📍 <?= escape($tour['location']) ?> | ⭐ <?= $tour['rating'] ?>/5 | 🏷️ <?= escape($tour['type']) ?></p>
                    </div>
                    <div class="product-footer">
                        <div class="product-price"><?= formatRupiah($tour['price']) ?></div>
                        <a href="detail.php?id=<?= (int)$tour['id'] ?>" class="btn-book">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; width: 100%;">
                <p style="color: #666; font-size: 18px;">Tidak ada paket wisata tersedia</p>
            </div>
        <?php endif; ?>
    </main>
</section>

<?php include 'includes/footer.php'; ?>