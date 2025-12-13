<?php
$host = 'localhost';
$user = 'root';      // Default XAMPP
$pass = '';          // Default XAMPP kosong
$db   = 'explore_papua'; // Nama database yang harus Anda buat

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi bantu sederhana untuk query (Optional tapi sangat membantu)
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}
?>
