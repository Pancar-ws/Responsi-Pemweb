<?php
require 'includes/db.php';
require 'functions/functions.php';
$page_title = 'Cari Paket - Explore Papua';
$extra_css = 'search.css';
$extra_js = 'search.js'; // Add JavaScript file
$hide_navbar = true; // Hide main navbar
include 'includes/header.php';

// Ambil semua data tours menggunakan function
$tours = getTours();
// Batasi hanya 4 paket saja
$tours = array_slice($tours, 0, 8);
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
            <?php 
            // Foto berbeda untuk setiap tour ID
            $tourImages = [
                1 => 'https://images.pexels.com/photos/15416579/pexels-photo-15416579.jpeg', // Raja Ampat
                2 => 'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?q=80&w=1470', // Baliem Valley
                3 => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2070', // Whale Shark
                4 => 'https://media.gettyimages.com/id/689863862/photo/marine-life-of-raja-ampat-west-papua-indonesia.jpg?s=612x612&w=0&k=20&c=oBevIMfzcXvIcgsDApKd8DAPgq2dvZ18yYxox7Pabc8=', // Premium Diving
                5 => 'https://images.pexels.com/photos/35172425/pexels-photo-35172425.jpeg', // Lake Sentani
                6 => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070', // Carstensz Mountain
                7 => 'https://thumbs.dreamstime.com/b/saltwater-crocodile-powerfully-splashes-muddy-river-papua-indonesia-breathtaking-moment-raw-natural-power-captured-402116631.jpg?w=992', // Lorentz Forest
                8 => 'https://images.pexels.com/photos/32507843/pexels-photo-32507843.jpeg'  // Biak Beach
            ];
            
            foreach($tours as $tour): 
                $tourImage = $tourImages[$tour['id']];
                
                // Badge warna untuk tipe paket
                $typeColor = '#FF9800'; // Default Orange
                $typeIcon = '🎒';
                $typeLabel = 'GABUNGAN';
                if($tour['type'] == 'Private') {
                    $typeColor = '#2196F3'; // Blue
                    $typeIcon = '👥';
                    $typeLabel = 'EKSKLUSIF';
                } elseif($tour['type'] == 'Customized') {
                    $typeColor = '#4CAF50'; // Green
                    $typeIcon = '⚙️';
                    $typeLabel = 'CUSTOM';
                }
            ?>
            <div class="product-card-horizontal" data-price="<?= $tour['price'] ?>" data-location="<?= escape($tour['location']) ?>">
                <div class="product-img" style="position: relative;">
                    <img src="<?= $tourImage ?>" alt="<?= escape($tour['name']) ?>">
                    <!-- Badge tipe paket -->
                    <div style="position: absolute; top: 10px; left: 10px; background: <?= $typeColor ?>; color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                        <?= $typeIcon ?> <?= $typeLabel ?>
                    </div>
                </div>
                <div class="product-details">
                    <div>
                        <h2 class="product-title"><?= escape($tour['name']) ?></h2>
                        <p class="product-meta">📍 <?= escape($tour['location']) ?> | ⭐ <?= $tour['rating'] ?>/5</p>
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