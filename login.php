  <?php
  session_start();

  // Pemeriksaan jika sudah login, redirect ke halaman lain
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
      header("Location: index.php");
      exit;
  }

  ?>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>PERTO PACIFIC</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
      <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="loginstyle.css">
        <form action="login_process.php" method="post">
          <?php
          if (isset($_GET['error'])) {
              if ($_GET['error'] == 'wrongpassword') {
                  echo '<div class="alert alert-danger">Password salah.</div>';
              } elseif ($_GET['error'] == 'usernotfound') {
                  echo '<div class="alert alert-danger">Username tidak ditemukan.</div>';
              }
          }
          ?>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                <div class="input-box mb-4">
                <input type="text" placeholder="Username" id="username" name="username" class="form-control-lg" required />
                <i class="bx bxs-user"></i>
              </div>
              <div class="input-box mb-4">
                <input type="password" placeholder="Password" required name="password" id="password" class="form-control-lg" />
                <img src="assets/lock-alt.png" id="lockIcon" />
              </div>
                <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="forgot.php">Forgot password?</a></p>
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a>
                </p>
              </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

