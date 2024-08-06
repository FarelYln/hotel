<?php 
include('koneksi.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="public/scss/style.css">
	<link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
  </head>
  <body>
    <div class="wrap">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col">
            <p class="mb-0 phone">
              <span class="fa fa-phone"></span>
              <a href="#">+62 111-2222-3333</a>
            </p>
          </div>
          <div class="col d-flex justify-content-end">
            <div class="social-media">
              <p class="mb-0 d-flex">
                <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="/dashboard.php">&nbsp;HOTEL <span>azure oasis</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="fa fa-bars"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav m-auto">
            <li class="nav-item"><a href="/dashboard.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="/content/tamu/index.php" class="nav-link">Tamu</a></li>
            <li class="nav-item"><a href="/content/kamar/index.php" class="nav-link">Kamar</a></li>
            <li class="nav-item"><a href="/content/reservasi/index.php" class="nav-link">Reservasi</a></li>
            <li class="nav-item"><a href="/content/pembayaran/index.php" class="nav-link">Pembayaran</a></li>
            <li class="nav-item"><a href="/content/staf/index.php" class="nav-link">Staf</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
