<?php
require 'includes/db.php';
session_start();

$message = '';

// LOGIKA REGISTER
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default role

    // Cek email kembar
    $check = query("SELECT * FROM users WHERE email = '$email'");
    if(count($check) > 0) {
        $message = "Email sudah terdaftar!";
    } else {
        mysqli_query($conn, "INSERT INTO users VALUES (NULL, '$name', '$email', '$password', '$role', NOW())");
        $message = "Registrasi berhasil! Silakan login.";
    }
}

// LOGIKA LOGIN
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = query("SELECT * FROM users WHERE email = '$email'");
    
    if (count($result) === 1) {
        $row = $result[0];
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['full_name'];
            $_SESSION['role'] = $row['role'];

            // Redirect sesuai role
            if ($row['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    $message = "Email atau Password salah!";
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