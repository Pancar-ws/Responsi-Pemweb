<?php
require 'includes/db.php';
$extra_css = 'admin.css';
$hide_navbar = true; // Admin punya sidebar sendiri
$hide_footer = true;
include 'includes/header.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') { header("Location: login.php"); exit; }

// Statistik
$income = query("SELECT SUM(total_price) as total FROM orders WHERE status='paid'")[0]['total'];
$total_orders = query("SELECT COUNT(*) as total FROM orders")[0]['total'];
$total_tours = query("SELECT COUNT(*) as total FROM tours")[0]['total'];

// Data
$orders = query("SELECT orders.*, users.full_name, tours.name as tour_name FROM orders JOIN users ON orders.user_id = users.id JOIN tours ON orders.tour_id = tours.id");
$tours = query("SELECT * FROM tours");
?>

<div class="admin-container">
    <aside class="sidebar">
        <div class="brand"><h2>Admin Panel</h2><p>Explore Papua</p></div>
        <ul class="menu">
            <li class="active">📊 Dashboard</li>
            <li><a href="index.php" style="color:white">🏠 Lihat Website</a></li>
            <li class="logout"><a href="logout.php">🚪 Keluar</a></li>
        </ul>
    </aside>
    
    <main class="content">
        <header>
            <h2 id="pageTitle">Dashboard Overview</h2>
            <div class="admin-profile"><span>Admin</span><img src="https://ui-avatars.com/api/?name=Admin&background=006064&color=fff"></div>
        </header>

        <div id="dashboard" class="section active">
            <div class="stats-grid">
                <div class="card stat"><h3>Total Pendapatan</h3><p class="number">Rp <?= number_format($income,0,',','.') ?></p></div>
                <div class="card stat"><h3>Pesanan Masuk</h3><p class="number"><?= $total_orders ?></p></div>
                <div class="card stat"><h3>Paket Wisata</h3><p class="number"><?= $total_tours ?></p></div>
            </div>
            
            <div class="card" style="margin-top:20px;">
                <h3>Pesanan Terbaru</h3>
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Pemesan</th><th>Paket</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach($orders as $o): ?>
                        <tr>
                            <td><?= $o['invoice_number'] ?></td>
                            <td><?= $o['full_name'] ?></td>
                            <td><?= $o['tour_name'] ?></td>
                            <td><span class="badge <?= $o['status'] ?>"><?= $o['status'] ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>