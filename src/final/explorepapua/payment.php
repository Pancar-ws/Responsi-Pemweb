<?php
require 'includes/db.php';
require 'functions/functions.php';

// Handle status update dari PENDING ke PAID
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_payment'])) {
    if(isset($_SESSION['last_invoice'])) {
        $invoice = $_SESSION['last_invoice'];
        $result = updateOrderStatus($invoice, 'paid');
        if($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
    echo json_encode(['success' => false, 'message' => 'No invoice found']);
    exit;
}

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
        <div class="timer-box">
            <p>⏰ Selesaikan pembayaran dalam</p>
            <h2 id="countdown">30:00</h2>
            <p class="deadline">Batas: <span id="deadlineTime">...</span></p>
        </div>
        <h3>💳 Metode Pembayaran</h3>
        <div class="method-card">
            <input type="radio" name="payment" id="bca" checked>
            <label for="bca" class="method-label">
                <div class="method-icon" style="font-size: 2rem; margin-right: 15px;">🏦</div>
                <div class="method-info">
                    <strong>Bank BCA</strong>
                    <p>Dicek Otomatis</p>
                </div>
            </label>
            <div class="method-detail">
                <p style="margin-bottom: 8px; font-weight: 600; color: #555;">No. Rekening:</p>
                <div class="copy-box">
                    <span id="rek-bca">8830-1234-5678</span>
                    <button onclick="copyText('rek-bca')">Salin</button>
                </div>
            </div>
        </div>
        <button class="btn-confirm" onclick="finishPayment()">✅ Saya Sudah Transfer</button>
    </div>
    
    <div class="order-summary">
        <h3>📋 Ringkasan Pesanan</h3>
        <p class="order-id">🎫 ID: <span id="displayId"><?= escape($order['invoice_number']) ?></span></p>
        <hr>
        <div class="summary-item"><strong>📦 Paket</strong><p id="displayName"><?= escape($order['name']) ?></p></div>
        <div class="summary-item"><strong>📅 Tanggal</strong><p id="displayDate"><?= date('d M Y', strtotime($order['booking_date'])) ?></p></div>
        <div class="summary-item"><strong>👥 Peserta</strong><p id="displayPax"><?= (int)$order['pax_count'] ?> orang</p></div>
        <hr>
        <div class="total-pay"><span>💰 Total Pembayaran</span><h2 id="displayTotal"><?= formatRupiah($order['total_price']) ?></h2></div>
        <div style="background: #E8F5E9; padding: 12px; border-radius: 8px; margin-top: 15px; font-size: 0.85rem; color: #2E7D32;">
            <strong>ℹ️ Petunjuk Transfer:</strong><br>
            1. Transfer sesuai nominal<br>
            2. Simpan bukti transfer<br>
            3. Klik tombol "Saya Sudah Transfer"<br>
            4. Tunggu konfirmasi admin (maks 1x24 jam)
        </div>
    </div>
</div>

<script src="assets/js/payment.js"></script>
</body>
</html>