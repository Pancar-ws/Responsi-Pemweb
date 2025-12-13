<?php
require 'includes/db.php';
require 'functions/functions.php';

// Proteksi halaman - harus login
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}

$page_title = 'Dashboard - Explore Papua';
$hide_navbar = true; // Hide default navbar
$extra_css = 'dashboard.css';
$extra_js = 'dashboard.js';

// Ambil orders user dengan function
$user_id = (int) $_SESSION['user_id'];
$orders = getUserOrders($user_id);

// Ambil info user untuk tahun registrasi
$user_query = query("SELECT created_at FROM users WHERE id = $user_id");
$user_data = $user_query[0] ?? null;
$member_since = $user_data ? date('Y', strtotime($user_data['created_at'])) : date('Y');

include 'includes/header.php';
?>

<!-- Custom Navbar for Dashboard -->
<nav class="navbar" id="navbar" style="background-color: #002f32;">
    <a href="index.php" class="logo" style="text-decoration:none; color:inherit;">Explore Papua</a>
    <div class="nav-actions" style="display: flex; align-items: center; gap: 15px;">
        <span style="color: white; font-size: 0.9rem;">👤 <?= escape($_SESSION['name']) ?></span>
    </div>
</nav>

<div class="dashboard-container">
    <aside class="dashboard-sidebar">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['name']) ?>&background=E0F7FA&color=006064" alt="Profil">
            <h3><?= escape($_SESSION['name']) ?></h3>
            <p>Bergabung sejak <?= $member_since ?></p>
        </div>
        <ul class="menu-list">
            <li><a href="#" class="active">📦 Riwayat Pesanan</a></li>
            <li><a href="logout.php">🚪 Keluar</a></li>
        </ul>
    </aside>

    <main class="dashboard-content">
        <div class="content-header"><h2>Riwayat Pesanan</h2></div>
        <div class="orders-list" id="orderContainer">
            <?php if(count($orders) > 0): ?>
                <?php foreach($orders as $order): ?>
                <div class="order-card">
                    <div class="order-info">
                        <h4><?= escape($order['tour_name']) ?></h4>
                        <div class="order-meta">
                            <span>📅 <?= date('Y-m-d', strtotime($order['booking_date'])) ?></span>
                            <span>👥 <?= (int)$order['pax_count'] ?> Orang</span>
                            <span class="order-id">#<?= escape($order['invoice_number']) ?></span>
                        </div>
                        <div class="order-price"><?= formatRupiah($order['total_price']) ?></div>
                        <?php
                        // Status badge dengan warna berbeda
                        $status = $order['status'];
                        $statusText = '';
                        $statusColor = '';
                        
                        switch($status) {
                            case 'pending':
                                $statusText = 'MENUNGGU PEMBAYARAN';
                                $statusColor = '#FF9800'; // Orange
                                break;
                            case 'paid':
                                $statusText = 'MENUNGGU VERIFIKASI ADMIN';
                                $statusColor = '#2196F3'; // Blue
                                break;
                            case 'confirmed':
                                $statusText = 'TERKONFIRMASI - SIAP BERANGKAT';
                                $statusColor = '#4CAF50'; // Green
                                break;
                            case 'cancelled':
                                $statusText = 'DIBATALKAN';
                                $statusColor = '#F44336'; // Red
                                break;
                        }
                        ?>
                        <div class="order-status" style="margin-top: 10px; padding: 8px 12px; background: <?= $statusColor ?>; color: white; border-radius: 5px; font-weight: bold; font-size: 0.85rem; text-align: center;">
                            <?= $statusText ?>
                        </div>
                    </div>
                    <div class="order-actions">
                        <button class="btn-download" onclick="downloadTicket('<?= escape($order['invoice_number']) ?>', '<?= escape($order['tour_name']) ?>', '<?= date('d M Y', strtotime($order['booking_date'])) ?>', '<?= $order['pax_count'] ?>', '<?= formatRupiah($order['total_price']) ?>', '<?= escape($_SESSION['name']) ?>', '<?= $statusText ?>')">⬇ Unduh Tiket</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada pesanan</p>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>