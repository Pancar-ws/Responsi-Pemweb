<?php
require 'includes/db.php';

echo "<h2>Test Login Admin</h2>";

$email = 'admin@explorepapua.com';
$password = 'password123';

$result = query("SELECT * FROM users WHERE email = '$email'");

if (count($result) > 0) {
    $user = $result[0];
    
    echo "<pre>";
    echo "Email ditemukan: " . $user['email'] . "\n";
    echo "Nama: " . $user['full_name'] . "\n";
    echo "Role: " . $user['role'] . "\n";
    echo "Password Hash (30 char): " . substr($user['password'], 0, 30) . "...\n";
    echo "\n--- Test Password Verify ---\n";
    
    if (password_verify($password, $user['password'])) {
        echo "✅ PASSWORD COCOK! Login seharusnya berhasil.\n";
        echo "\nKredensial yang benar:\n";
        echo "Email: admin@explorepapua.com\n";
        echo "Password: password123\n";
    } else {
        echo "❌ PASSWORD TIDAK COCOK!\n";
        echo "Hash di database mungkin corrupt.\n";
    }
    echo "</pre>";
} else {
    echo "❌ Email tidak ditemukan di database!";
}
?>
