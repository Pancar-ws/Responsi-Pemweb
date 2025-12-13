<?php
require 'includes/db.php';
$navbar_style = 'background-color: #002f32;';
$extra_css = 'dashboard.css';
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$user_id = $_SESSION['user_id'];
$orders = query("SELECT orders.*, tours.name as tour_name 
                 FROM orders 
                 JOIN tours ON orders.tour_id = tours.id 
                 WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<div class="dashboard-container">
    <aside class="dashboard-sidebar">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['name'] ?>&background=E0F7FA&color=006064" alt="Profil">
            <h3><?= $_SESSION['name'] ?></h3>
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
            <?php foreach($orders as $order): ?>
            <div class="order-card">
                <div class="order-info">
                    <h4><?= $order['tour_name'] ?></h4>
                    <div class="order-meta">
                        <span>📅 <?= $order['booking_date'] ?></span>
                        <span>👥 <?= $order['pax_count'] ?> Orang</span>
                        <span class="order-id">#<?= $order['invoice_number'] ?></span>
                    </div>
                    <div class="order-price">Rp <?= number_format($order['total_price'],0,',','.') ?></div>
                </div>
                <div class="order-actions">
                    <button class="btn-download" style="background: <?= ($order['status']=='paid')?'#e8f5e9':'#fff3e0' ?>">
                        <?= strtoupper($order['status']) ?>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>