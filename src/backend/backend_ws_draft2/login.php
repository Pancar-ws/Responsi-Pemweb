<?php
session_start();

// Cek apakah file koneksi namanya 'connect.php' atau 'koneksi.php'?
// Sesuaikan baris ini dengan nama file asli Anda.
if (file_exists('koneksi.php')) {
    require 'koneksi.php';
} elseif (file_exists('connect.php')) {
    require 'connect.php';
} else {
    die("Error: File koneksi database tidak ditemukan!");
}

// Cek Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    // Cek Username
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Cek Password (Plain text sesuai request awal, bukan hash)
        if ($password == $row['password']) {
            
            // Set Session
            $_SESSION['login'] = true;
            $_SESSION['role'] = $row['role']; 
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];

            // Redirect berdasarkan Role
            if ($row['role'] == 'kepala_suku') {
                header("Location: dashboard_adat.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    
    $error = true; // Flag untuk menampilkan pesan error di HTML
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Permisi Papua</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        h2 { color: #3E2723; margin-bottom: 1.5rem; }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Agar padding tidak melebarkan input */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3E2723; /* Coklat Papua */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover { background-color: #5D4037; }
        .error-msg {
            color: red;
            font-style: italic;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .link-back {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Permisi Papua</h2>
        
        <!-- Tampilkan Pesan Error jika login gagal -->
        <?php if (isset($error)) : ?>
            <p class="error-msg">Username atau Password salah!</p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="username" style="display:none;">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required autofocus>
            
            <label for="password" style="display:none;">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
            
            <button type="submit" name="login">Minta Izin Masuk</button>
        </form>

        <a href="index.php" class="link-back">Kembali ke Beranda</a>
    </div>

</body>
</html>