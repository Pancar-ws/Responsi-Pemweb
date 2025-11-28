<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // Redirect ke login, bukan index
exit;
?>