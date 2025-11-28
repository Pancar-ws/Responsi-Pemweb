<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_permisi_papua";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("KONEKSI DATABASE GAGAL: " . mysqli_connect_error());
}
?>