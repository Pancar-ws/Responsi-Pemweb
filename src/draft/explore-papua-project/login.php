<?php
require 'includes/db.php';
require 'functions/auth.php';

$message = '';

// LOGIKA REGISTER - Menggunakan function dari auth.php
if (isset($_POST['register'])) {
    // Validasi input
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
        $message = "Semua field harus diisi!";
    } else if(strlen($_POST['password']) < 6) {
        $message = "Password minimal 6 karakter!";
    } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid!";
    } else {
        $result = registrasi($_POST);
        if($result > 0) {
            $message = "✅ Registrasi berhasil! Silakan login.";
        } else if($result === false) {
            $message = "Email sudah terdaftar!";
        } else {
            $message = "Registrasi gagal! Silakan coba lagi.";
        }
    }
}

// LOGIKA LOGIN - Dengan security yang lebih baik
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, strtolower(trim($_POST['email'])));
    $password = $_POST['password'];

    // Validasi input
    if(empty($email) || empty($password)) {
        $message = "Email dan password harus diisi!";
    } else {
        $result = query("SELECT * FROM users WHERE email = '$email'");
        
        if (count($result) === 1) {
            $row = $result[0];
            if (password_verify($password, $row['password'])) {
                // Set Session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['full_name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['email'] = $row['email'];

                // Redirect sesuai role
                if ($row['role'] == 'admin') {
                    header("Location: admin_new.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            }
        }
        $message = "❌ Email atau Password salah!";
    }
}

// Setup Template
$page_title = 'Masuk / Daftar';
$extra_css = 'login.css'; // Pastikan login.css ada di assets/css/
$hide_navbar = true; // Sesuai desain login Anda yg standalone
$hide_footer = true; 
include 'includes/header.php';
?>

<div class="login-container">
    <div class="login-card">
        <a href="index.php" class="logo">Explore Papua</a>
        
        <?php if($message): ?>
            <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="auth-tabs">
            <button id="tab-login" class="active" onclick="switchTab('login')">Masuk</button>
            <button id="tab-register" onclick="switchTab('register')">Daftar</button>
        </div>

        <!-- FORM LOGIN -->
        <div id="form-login-box">
            <div class="login-header"><h2>Selamat Datang Kembali</h2><p>Silakan masuk untuk melanjutkan pemesanan.</p></div>
            <form class="auth-form" method="POST">
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                <button type="submit" name="login" class="btn-full">Masuk</button>
            </form>
        </div>

        <!-- FORM REGISTER -->
        <div id="form-register-box" style="display: none;">
            <div class="login-header"><h2>Buat Akun Baru</h2><p>Gabung bersama ribuan petualang lainnya.</p></div>
            <form class="auth-form" method="POST">
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
                <button type="submit" name="register" class="btn-full btn-register">Daftar Akun</button>
            </form>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    if (tab === 'login') {
        document.getElementById('form-login-box').style.display = 'block';
        document.getElementById('form-register-box').style.display = 'none';
        document.getElementById('tab-login').classList.add('active');
        document.getElementById('tab-register').classList.remove('active');
    } else {
        document.getElementById('form-login-box').style.display = 'none';
        document.getElementById('form-register-box').style.display = 'block';
        document.getElementById('tab-login').classList.remove('active');
        document.getElementById('tab-register').classList.add('active');
    }
}
</script>

<?php include 'includes/footer.php'; ?>