<?php
session_start();
include_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Debug: print user inputs
    error_log("Username: $username");

    // Query untuk mengambil data pengguna berdasarkan username
    $sql = "SELECT username, password FROM admin WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Debug: check if username exists
        error_log("Number of rows: " . $stmt->num_rows);

        // Periksa apakah username ditemukan di database
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_username, $db_password);
            $stmt->fetch();

            // Debug: check retrieved password
            error_log("DB Password: $db_password");

            // Verifikasi password
            if (password_verify($password, $db_password)) {
                // Jika login berhasil, simpan informasi pengguna dalam sesi
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $db_username;

                // Atur cookie waktu terakhir akses
                setcookie('last_activity', time(), time() + (5 * 60), "/"); // Cookie akan berakhir dalam 5 menit

                // Redirect pengguna ke halaman lain setelah login
                header("location: index.php?target=home");
                exit;
            } else {
                // Jika password salah
                error_log("Password verification failed");
                header("location: login.php?error=wrongpassword");
                exit;
            }
        } else {
            // Jika username tidak ditemukan
            error_log("Username not found");
            header("location: login.php?error=usernotfound");
            exit;
        }

        $stmt->close();
    } else {
        error_log("Database query failed");
        echo "Oops! Something went wrong. Please try again later.";
    }
}

$conn->close();
?>
