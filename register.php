<?php
// Pastikan Anda telah membuat koneksi ke database sebelumnya
include_once 'koneksi.php';

// Inisialisasi variabel pesan error
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Memproses data ketika form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah field username tidak kosong
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Memeriksa apakah field email tidak kosong
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Memeriksa apakah field password tidak kosong
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Memeriksa apakah field confirm password tidak kosong
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        // Memeriksa apakah password dan confirm password cocok
        if ($password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Jika tidak ada pesan error, lakukan penambahan data ke dalam database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Siapkan pernyataan INSERT
        $sql = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameter ke pernyataan
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            // Set parameter
            $param_username = $username;
            $param_email = $email;
              $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash password sebelum disimpan ke database

            // Debug: cek nilai parameter yang akan disimpan
            error_log("Username: $param_username");
            error_log("Email: $param_email");
            error_log("Hashed Password: $param_password");

            // Cobalah untuk mengeksekusi pernyataan yang telah disiapkan
            if ($stmt->execute()) {
                // Jika berhasil, redirect ke halaman login
                header("location: login.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Tutup pernyataan
            $stmt->close();
        }
    }

    // Tutup koneksi
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Motor2nd.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body class="bg-dark">
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
              <p class="text-white-50 mb-5">Please enter your details to create an account.</p>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-box mb-4">
                <input type="text" name="username" placeholder="Username" required />
                        <i class="bx bxs-user"></i>
                </div>
                <div class="input-box mb-4">
                <input type="email" name="email" placeholder="Email" required />
                        <i class="bx bx-envelope"></i>
                </div>
                <div class="input-box mb-4">
                <input type="password" name="password" placeholder="Password" required />
                        <i class="bx bxs-lock-alt"></i>
                </div>
                <div class="input-box mb-4">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                        <i class="bx bxs-lock-alt"></i>
                </div>

                <button class="btn btn-outline-light btn-lg px-5" type="submit">Create Account</button>

                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                  <a href="login.php" class="text-white-50">
                    <i class="bx bx-arrow-back me-2"></i>Back to Login
                  </a>
                  <div class="register-link">
                </div>
              </form>

              <div class="text-center text-white-50 mt-4">
                By continuing, you agree to our <a href="#" class="text-white">Terms of Service</a> and <a href="#" class="text-white">Privacy Policy.</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
})

let lockIcon = document.getElementById("lockIcon");
let password = document.getElementById("password");

lockIcon.onclick = function () {
    if (password.type == "password") {
        password.type = "text";
        lockIcon.src = "assets/lock-open-alt.png";
    } else {
        password.type = "password";
        lockIcon.src = "assets/lock-alt.png";
    }
};
</script>
</body>
</html>
