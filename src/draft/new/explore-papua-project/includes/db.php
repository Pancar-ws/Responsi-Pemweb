<?php
// Start session jika belum
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$user = 'root';      // Default XAMPP
$pass = '';          // Default XAMPP kosong
$db   = 'explore_papua'; // Nama database yang harus Anda buat

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset untuk mencegah masalah encoding
mysqli_set_charset($conn, 'utf8mb4');

// Fungsi bantu sederhana untuk query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    
    if(!$result) {
        // Log error untuk debugging
        error_log("Query Error: " . mysqli_error($conn));
        return [];
    }
    
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

// Include functions setelah koneksi database tersedia
require_once __DIR__ . '/../functions/functions.php';
?>
