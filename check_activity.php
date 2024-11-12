<?php
// Periksa apakah sesi sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Waktu timeout dalam detik (5 menit)
$timeout_duration = 300;

// Periksa waktu aktivitas terakhir
if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity'];
    if ($elapsed_time >= $timeout_duration) {
        session_unset();
        session_destroy();
        header("Location: login.php?error=sessiontimeout");
        exit;
    }
}

// Perbarui waktu aktivitas terakhir
$_SESSION['last_activity'] = time();
?>
