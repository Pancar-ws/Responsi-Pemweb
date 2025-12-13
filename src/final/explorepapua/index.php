<?php 
require 'includes/db.php';
require 'functions/functions.php';
$page_title = 'Beranda - Explore Papua';
$extra_css = 'home.css'; 
include 'includes/header.php'; 
?>

<!-- Hero Section -->
<header class="hero">
    <div class="hero-content">
        <h1>Menjelajahi Keajaiban Papua</h1>
        <p>There's More Than Meets The Eye</p>
        <div class="cta-container">
            <a href="search.php" class="btn-cta">Cari Tiket Sekarang</a>
        </div>
    </div>
    <div class="hero-footer"><span>Raja Ampat, Papua Barat</span></div>
</header>

<!-- Spotlight (Data dari DB) -->
<section class="spotlight" id="destinasi">
    <div class="spotlight-text">
        <h4>Spotlight</h4>
        <h2>Destinasi <br>Ikonik</h2>
        <p>Papua menawarkan keindahan alam yang tak tertandingi.</p>
        <a href="search.php" class="btn-outline">Lihat Semua</a>
    </div>
    <div class="card-scroll">
        <?php 
        // Ambil 3 data wisata teratas menggunakan function
        $tours = getTours();
        $tours = array_slice($tours, 0, 3); // Ambil 3 teratas
        
        // Foto berbeda untuk setiap tour ID
        $tourImages = [
            1 => 'https://images.pexels.com/photos/15416579/pexels-photo-15416579.jpeg', // Raja Ampat
            2 => 'https://images.unsplash.com/photo-1570789210967-2cac24afeb00?q=80&w=1470', // Baliem Valley
            3 => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2070', // Whale Shark
            4 => 'https://media.gettyimages.com/id/689863862/photo/marine-life-of-raja-ampat-west-papua-indonesia.jpg?s=612x612&w=0&k=20&c=oBevIMfzcXvIcgsDApKd8DAPgq2dvZ18yYxox7Pabc8=', // Premium Diving
            5 => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070', // Lake Sentani
            6 => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070', // Carstensz Mountain
            7 => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2070', // Lorentz Forest
            8 => 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?q=80&w=2070'  // Biak Beach
        ];
        
        foreach($tours as $tour): 
            $tourImage = $tourImages[$tour['id']];
            
            // Badge warna untuk tipe paket
            $typeColor = '#FF9800'; // Default Orange
            $typeIcon = '🎒';
            if($tour['type'] == 'Private') {
                $typeColor = '#2196F3'; // Blue
                $typeIcon = '👥';
            } elseif($tour['type'] == 'Customized') {
                $typeColor = '#4CAF50'; // Green
                $typeIcon = '⚙️';
            }
        ?>
        <div class="card">
            <!-- Link ke detail.php dengan ID -->
            <a href="detail.php?id=<?= (int)$tour['id'] ?>" style="position: relative;">
                <img src="<?= $tourImage ?>" alt="<?= escape($tour['name']) ?>">
                <!-- Badge tipe paket -->
                <div style="position: absolute; top: 10px; right: 10px; background: <?= $typeColor ?>; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                    <?= $typeIcon ?> <?= escape($tour['type']) ?>
                </div>
                <div class="card-info">
                    <h3><?= escape($tour['name']) ?></h3>
                    <p><?= escape($tour['location']) ?></p>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Testimoni & Kuliner (Statis) -->
<section class="testimonials" id="pengalaman">
    <div class="container">
        <div class="section-header"><h4>Kata Mereka</h4><h2>Pengalaman Tak Terlupakan</h2><p>Cerita asli dari para petualang.</p></div>
        <div class="review-grid">
            <div class="review-card">
                <div class="stars">★★★★★</div>
                <p class="review-text">"Trip ke Raja Ampat sangat terorganisir."</p>
                <div class="reviewer">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150" alt="Sarah Wijaya">
                    <div class="reviewer-info">
                        <h5>Sarah Wijaya</h5>
                        <span>Jakarta</span>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="stars">★★★★★</div>
                <p class="review-text">"Lembah Baliem sungguh magis."</p>
                <div class="reviewer">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150" alt="Budi Santoso">
                    <div class="reviewer-info">
                        <h5>Budi Santoso</h5>
                        <span>Surabaya</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="culinary" id="kuliner">
    <div class="container">
        <div class="section-header-dark"><h4>Cita Rasa Timur</h4><h2>Kuliner Legendaris</h2><p>Rasa autentik Papua.</p></div>
        <div class="food-grid">
            <div class="food-card"><img src="assets/img/papeda.jpeg" alt="Papeda"><div class="food-content"><h3>Papeda</h3><p>Makanan pokok sagu.</p></div></div>
            <div class="food-card"><img src="assets/img/udang.jpg" alt="Udang"><div class="food-content"><h3>Udang Selingkuh</h3><p>Udang unik Baliem.</p></div></div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>