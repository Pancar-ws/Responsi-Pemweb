<?php 
require 'includes/db.php';
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
        // Ambil 3 data wisata teratas
        $tours = query("SELECT * FROM tours LIMIT 3");
        foreach($tours as $tour): 
        ?>
        <div class="card">
            <!-- Link ke detail.php dengan ID -->
            <a href="detail.php?id=<?= $tour['id'] ?>">
                <img src="assets/img/<?= $tour['image_url'] ?>" alt="<?= $tour['name'] ?>">
                <div class="card-info">
                    <h3><?= $tour['name'] ?></h3>
                    <p><?= $tour['location'] ?></p>
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
            <div class="review-card"><div class="stars">★★★★★</div><p class="review-text">"Trip ke Raja Ampat sangat terorganisir."</p><div class="reviewer"><div class="reviewer-info"><h5>Sarah Wijaya</h5><span>Jakarta</span></div></div></div>
            <div class="review-card"><div class="stars">★★★★★</div><p class="review-text">"Lembah Baliem sungguh magis."</p><div class="reviewer"><div class="reviewer-info"><h5>Budi Santoso</h5><span>Surabaya</span></div></div></div>
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