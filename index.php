<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Plan Your Perfect Stay</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* BODY */
body{
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
}

/* NAVBAR */
.custom-navbar{
    background: rgba(0,0,0,0.35);
    backdrop-filter: blur(15px);
    padding: 10px 0;
}

/* LOGO */
.logo-img{
    height: 50px;
}

/* NAV LINKS */
.nav-link{
    color: #fff !important;
    margin: 0 12px;
    font-weight: 500;
}

.nav-link:hover{
    color: #00c6ff !important;
}

/* HERO */
.hero{
    background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
                url("assets/images/bg.jpg") center/cover no-repeat;
    height: 100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:white;
}

/* SEARCH BOX */
.search-box{
    background:white;
    border-radius:50px;
    padding:15px;
    box-shadow:0 10px 40px rgba(0,0,0,0.3);
}

.search-box input{
    border:none;
    height:45px;
}

.search-box input:focus{
    box-shadow:none;
}

.btn-search{
    border-radius:30px;
    height:45px;
    font-weight:600;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo_pps.jpg" class="logo-img">
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

      <!-- LINKS -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">Home</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="property_list.php">Search</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>

      <!-- LOGIN / LOGOUT -->
      <?php if(isset($_SESSION['user_id'])) { ?>
        <a href="logout.php" class="btn btn-light me-2">Logout</a>
      <?php } else { ?>
        <a href="login.php" class="btn btn-light me-2">Sign In</a>
      <?php } ?>

      <!-- LIST PROPERTY -->
      <a href="property/property_list.php" class="btn btn-primary">
        List Property
      </a>

    </div>
  </div>
</nav>

<!-- HERO SECTION -->
<section class="hero">
  <div class="container">

    <h1 class="display-4 fw-bold">
        Plan Your Perfect Stay
    </h1>

    <p class="lead mb-4">
        Discover homes, flats and rental properties at best prices
    </p>

    <!-- SEARCH FORM -->
    <form action="property/property_list.php" method="get"
          class="search-box mx-auto col-lg-10">

      <div class="row g-3 align-items-center">

        <div class="col-md-3">
          <input type="text" name="location"
                 class="form-control"
                 placeholder="Where are you going?">
        </div>

        <div class="col-md-2">
          <input type="date" name="checkin" class="form-control">
        </div>

        <div class="col-md-2">
          <input type="date" name="checkout" class="form-control">
        </div>

        <div class="col-md-2">
          <input type="number" name="guests"
                 class="form-control" min="1" value="1">
        </div>

        <div class="col-md-3 d-grid">
          <button class="btn btn-primary btn-search">
            <i class="bi bi-search"></i> Search
          </button>
        </div>

      </div>
    </form>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>