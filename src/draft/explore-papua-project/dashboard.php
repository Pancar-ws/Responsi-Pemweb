<?php
require 'includes/db.php';
$navbar_style = 'background-color: #002f32;';
$extra_css = 'dashboard.css';
include 'includes/header.php';

// Proteksi halaman - harus login
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

// Ambil orders user dengan function
$user_id = (int) $_SESSION['user_id'];
$orders = getUserOrders($user_id);
?>

<div class="dashboard-container">
    <aside class="dashboard-sidebar">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name']) ?>&background=E0F7FA&color=006064" alt="Profil">
            <h3><?= escape($_SESSION['name']) ?></h3>
            <p>Member</p>
        </div>
        <ul class="menu-list">
            <li><a href="#" class="active">📦 Riwayat Pesanan</a></li>
            <li><a href="logout.php">🚪 Keluar</a></li>
        </ul>
    </aside>

    <main class="dashboard-content">
        <div class="content-header"><h2>Riwayat Pesanan</h2></div>
        <div class="orders-list">
            <?php if(count($orders) > 0): ?>
                <?php foreach($orders as $order): ?>
                <div class="order-card">
                    <div class="order-info">
                        <h4><?= escape($order['tour_name']) ?></h4>
                        <div class="order-meta">
                            <span>📅 <?= date('d M Y', strtotime($order['booking_date'])) ?></span>
                            <span>👥 <?= (int)$order['pax_count'] ?> Orang</span>
                            <span class="order-id">#<?= escape($order['invoice_number']) ?></span>
                        </div>
                        <div class="order-price"><?= formatRupiah($order['total_price']) ?></div>
                    </div>
                    <div class="order-actions">
                        <button class="btn-download" style="background: <?= ($order['status']=='paid')?'#e8f5e9':'#fff3e0' ?>">
                            <?= strtoupper(escape($order['status'])) ?>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 50px;">
                    <p style="color: #666;">Belum ada pesanan</p>
                    <a href="search.php" style="margin-top: 20px; display: inline-block; padding: 10px 20px; background: #006064; color: white; text-decoration: none; border-radius: 5px;">Mulai Jelajah</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>