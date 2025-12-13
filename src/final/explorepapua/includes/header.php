<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Default Title jika tidak diset
if(!isset($page_title)) { $page_title = 'Explore Papua'; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- CSS Khusus Per Halaman -->
    <?php if(isset($extra_css)): ?>
        <link rel="stylesheet" href="assets/css/<?= $extra_css ?>">
    <?php endif; ?>
</head>
<body>
    <!-- Navbar (Hanya muncul jika bukan halaman login/payment) -->
    <?php if(!isset($hide_navbar) || !$hide_navbar): ?>
    <nav class="navbar" id="navbar" style="<?= (isset($navbar_style)) ? $navbar_style : '' ?>">
        <a href="index.php" class="logo">Explore Papua</a>
        <div class="menu-toggle" id="mobile-menu"><span class="bar"></span><span class="bar"></span><span class="bar"></span></div>
        <ul class="nav-links">
            <li><a href="#destinasi">Destinasi</a></li>
            <li><a href="#pengalaman">Pengalaman</a></li>
            <li><a href="#kuliner">Kuliner</a></li>
            <li><a href="#info">Informasi</a></li>
        </ul>
        
        <div class="nav-actions">
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="admin_new.php" class="btn-login" style="margin-right: 10px;">Admin Panel</a>
                <?php else: ?>
                    <a href="dashboard.php" class="btn-login" style="margin-right: 10px;">Dashboard</a>
                <?php endif; ?>
                <a href="logout.php" class="btn-login" style="background:#ff5252; border:none;">Keluar</a>
            <?php else: ?>
                <a href="login.php" class="btn-login">Masuk</a>
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>