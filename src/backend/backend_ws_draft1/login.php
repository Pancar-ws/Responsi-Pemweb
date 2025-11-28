<?php
session_start();
require 'connect.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['role'] = $row['role']; // pendatang / kepala_suku
            $_SESSION['id_user'] = $row['id_user'];

            if ($row['role'] == 'kepala_suku') {
                header("Location: dashboard_adat.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    $error = true;
}
?>
<!-- HTML Form Login tetap sama -->