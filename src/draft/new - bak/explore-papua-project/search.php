<?php
require 'includes/db.php';
$page_title = 'Cari Paket - Explore Papua';
$extra_css = 'search.css';
$navbar_style = 'background-color: #002f32;'; // Navbar solid color
include 'includes/header.php';

// Ambil semua data tours
$tours = query("SELECT * FROM tours");
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
        <?php foreach($tours as $tour): ?>
        <div class="product-card-horizontal">
            <div class="product-img"><img src="assets/img/<?= $tour['image_url'] ?>" alt="<?= $tour['name'] ?>"></div>
            <div class="product-details">
                <div>
                    <h2 class="product-title"><?= $tour['name'] ?></h2>
                    <p class="product-meta">📍 <?= $tour['location'] ?> | ⭐ <?= $tour['rating'] ?>/5 | 🏷️ <?= $tour['type'] ?></p>
                </div>
                <div class="product-footer">
                    <div class="product-price">Rp <?= number_format($tour['price'], 0, ',', '.') ?></div>
                    <a href="detail.php?id=<?= $tour['id'] ?>" class="btn-book">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </main>
</section>

<?php include 'includes/footer.php'; ?>