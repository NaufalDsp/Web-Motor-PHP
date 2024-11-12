<?php
// Mulai sesi
include 'check_activity.php';

// Periksa apakah pengguna belum login dan mencoba mengakses halaman CRUDProduct.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, arahkan pengguna kembali ke halaman login
}

// Periksa apakah waktu terakhir akses dalam cookie sudah lebih dari 5 menit yang lalu
if (isset($_COOKIE['last_activity']) && (time() - $_COOKIE['last_activity']) > (5 * 60)) {
    // Hapus sesi pengguna
    session_destroy();

    // Redirect ke halaman login setelah logout otomatis
    header("location: login.php");
    exit;
}

// Perbarui waktu terakhir akses dalam cookie
setcookie('last_activity', time(), time() + (5 * 60), "/"); // Cookie akan diperbarui setiap kali pengguna mengakses halaman

// Halaman berikutnya
// Tambahkan konten halaman yang diinginkan di sini
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Motor2nd.</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="style.css" rel="stylesheet">
</head>


<body>
  <main>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Motor2nd.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="index.php?target=product">Show Products</a></li>
                        <li><a class="dropdown-item" href="index.php?target=tabelproduct">Manage Products</a></li>
                        <li><a class="dropdown-item" href="index.php?target=tambah">Add Products</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?target=about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?target=credit">Credit</a>
                </li>
                </li>
                <?php
                    // Periksa apakah pengguna sudah login
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        // Jika pengguna sudah login, tampilkan tombol logout
                        echo '<li class="nav-item">';
                        echo '<a class="btn btn-danger ms-3 login-btn" href="logout.php" role="button">Log out</a>';
                        echo '</li>';
                    } else {
                        // Jika pengguna belum login, tampilkan tombol login
                        echo '<li class="nav-item">';
                        echo '<a class="btn btn-success ms-3 login-btn" href="login.php" role="button">Log In</a>';
                        echo '</li>';
                    }
                ?>
            </ul>
            </ul>
        </div>
    </div>
</nav>


    <!-- CONTENT -->
    <div>
      <div class="bg-body-tertiaryp-5 rounded">
        <!-- <div class="col-sm-8 mx-auto"> -->
        <?php
    if (isset($_GET['target'])) {
      $target = $_GET['target'];
      if ($target == 'home') {
          require('modularitas/home.php');
        } else if ($_GET['target'] == "tabelproduct") {
          require ('modularitas/tabelproduct.php');
        } else if ($_GET['target'] == "product") {
          require ('modularitas/product.php');
        } else if ($_GET['target'] == "edit") {
          require ('modularitas/edit.php');
        } else if ($_GET['target'] == "about") {
          require ('modularitas/about.php');
        } else if ($_GET['target'] == "hapus") {
          require ('modularitas/hapus.php');
        } else if ($_GET['target'] == "credit") {
          require ('modularitas/credit.php');
        } else if ($_GET['target'] == "terima") {
          require ('modularitas/terima.php');
        } else if ($_GET['target'] == "terimacredit") {
          require ('modularitas/terimacredit.php');
        } else if ($_GET['target'] == "tambah") {
          require ('modularitas/tambah.php');
        } else if ($_GET['target'] == "login") {
          require ('login.php');
        } else if ($_GET['target'] == "forgot") {
          require ('forgot.php');
        } else {
          require ('modularitas/eror.php');
        }
        
      } else {
        require('modularitas/home.php');
    }
        ?>
        <!-- </div> -->
      </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer bg-transparent">
      <div class="container3">
        <div class="row">
          <div class=" text-center">
            <p class="text-white">&copy; 2024 Motor<span>2nd.</span> Contact : +621311825516</p>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <script>
const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
})
</script>
<script>
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