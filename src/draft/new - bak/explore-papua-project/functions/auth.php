<?php
// Fungsi untuk Menambah User Baru (Register)
function registrasi($data) {
    global $conn; // Mengambil koneksi dari db.php

    // 1. Ambil data dari form & amankan dari karakter aneh (stripslashes/mysqli_real_escape)
    $name = mysqli_real_escape_string($conn, htmlspecialchars($data["name"]));
    $email = mysqli_real_escape_string($conn, strtolower(stripslashes($data["email"])));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    
    // 2. Cek apakah email sudah ada di database?
    $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
        return false;
    }

    // 3. Enkripsi password (wajib, jangan simpan plain text!)
    $password = password_hash($password, PASSWORD_DEFAULT);

    // 4. Set role default
    $role = 'user';

    // 5. Masukkan ke database
    mysqli_query($conn, "INSERT INTO users VALUES(NULL, '$name', '$email', '$password', '$role', NOW())");

    // Kembalikan angka 1 jika berhasil (baris yang terpengaruh)
    return mysqli_affected_rows($conn);
}
?>