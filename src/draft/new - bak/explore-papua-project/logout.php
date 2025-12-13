<?php
// 1. Mulai session
session_start();

// 2. Kosongkan semua data session
$_SESSION = [];
session_unset();

// 3. Hancurkan session
session_destroy();

// 4. Redirect ke halaman utama (atau login)
header("Location: index.php");
exit;
?>