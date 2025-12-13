<?php
require 'includes/db.php';

$extra_css = 'payment.css';
$hide_navbar = true;
$hide_footer = true;
include 'includes/header.php';

// Cek apakah ada invoice di session
if(!isset($_SESSION['last_invoice'])) {
    header("Location: index.php");
    exit;
}

$inv = mysqli_real_escape_string($conn, $_SESSION['last_invoice']);
$order = getOrderByInvoice($inv);

// Jika order tidak ditemukan
if(!$order) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}
?>

<nav class="navbar-simple"><a href="index.php" class="logo">Explore Papua</a></nav>
<div class="payment-container">
    <div class="payment-methods">
        <div class="timer-box"><p>Selesaikan pembayaran dalam</p><h2 id="countdown">24:00:00</h2></div>
        <h3>Metode Pembayaran</h3>
        <div class="method-card">
            <input type="radio" name="payment" id="bca" checked>
            <label for="bca" class="method-label"><div class="method-info"><strong>Bank BCA</strong><p>8830-1234-5678</p></div></label>
        </div>
        <a href="dashboard.php" class="btn-confirm" style="display:block; text-align:center; text-decoration:none;">Saya Sudah Transfer</a>
    </div>
    
    <div class="order-summary">
        <h3>Ringkasan</h3>
        <p class="order-id">ID: <span><?= escape($order['invoice_number']) ?></span></p>
        <hr>
        <div class="summary-item"><strong>Paket</strong><p><?= escape($order['name']) ?></p></div>
        <div class="summary-item"><strong>Tanggal</strong><p><?= date('d M Y', strtotime($order['booking_date'])) ?></p></div>
        <div class="summary-item"><strong>Peserta</strong><p><?= (int)$order['pax_count'] ?> orang</p></div>
        <hr>
        <div class="total-pay"><span>Total</span><h2><?= formatRupiah($order['total_price']) ?></h2></div>
    </div>
</div>