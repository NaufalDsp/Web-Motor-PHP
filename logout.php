<?php
// Mulai sesi
session_start();

// Unset semua variabel sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login setelah logout
header("location: index.php");
exit;
?>