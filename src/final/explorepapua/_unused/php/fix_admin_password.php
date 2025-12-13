<?php
require 'includes/db.php';

echo "<h2>Fix Admin Password</h2>";

// Generate password hash baru untuk 'password123'
$new_password = password_hash('password123', PASSWORD_DEFAULT);

echo "<p>Password hash baru: <code>" . substr($new_password, 0, 40) . "...</code></p>";

// Update password admin
$email = 'admin@explorepapua.com';
$query = "UPDATE users SET password = '$new_password' WHERE email = '$email'";

if (mysqli_query($conn, $query)) {
    echo "<p style='color: green; font-weight: bold;'>✅ Password admin berhasil diupdate!</p>";
    
    // Test verify
    $result = query("SELECT * FROM users WHERE email = '$email'");
    if (count($result) > 0) {
        $user = $result[0];
        if (password_verify('password123', $user['password'])) {
            echo "<p style='color: green;'>✅ Verifikasi berhasil! Password 'password123' sudah cocok.</p>";
            echo "<hr>";
            echo "<h3>Silakan login dengan:</h3>";
            echo "<ul>";
            echo "<li><strong>Email:</strong> admin@explorepapua.com</li>";
            echo "<li><strong>Password:</strong> password123</li>";
            echo "</ul>";
            echo "<p><a href='login.php' style='background: #006064; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login Sekarang</a></p>";
        } else {
            echo "<p style='color: red;'>❌ Masih ada masalah dengan password verification</p>";
        }
    }
} else {
    echo "<p style='color: red;'>❌ Gagal update: " . mysqli_error($conn) . "</p>";
}
?>
