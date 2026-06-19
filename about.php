<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About - Plan Your Perfect Stay</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SAME CSS -->
<link rel="stylesheet" href="assets/css/style.css">

<style>

/* navbar खाली space */
body{
    padding-top: 80px;
}

/* 🔥 NAVBAR PERFECT ALIGN */
.custom-navbar{
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(12px);
}

.custom-navbar .container{
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.navbar-nav{
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.navbar-collapse{
    justify-content: flex-end;
}

/* LOGO FIX */
.logo-img{
    height: 45px;
}

/* ABOUT BG */
.about-section{
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                url("assets/images/bg.jpg") center/cover no-repeat;
    min-height: 100vh;
    color: white;
    display: flex;
    align-items: center;
}

/* CONTENT WIDTH */
.about-section .container{
    max-width: 1100px;
}

/* GLASS CARD */
.about-card{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    padding: 30px;
}

/* TEXT SPACING */
.about-card h2{
    margin-bottom: 15px;
}

.about-card h5{
    margin-top: 15px;
}

/* FEATURES */
.feature-box{
    background: rgba(255,255,255,0.08);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    backdrop-filter: blur(10px);
    transition: 0.3s;
}

.feature-box:hover{
    transform: translateY(-5px);
}

</style>

</head>

<body>

<!-- ✅ PERFECT NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo_pps.jpg" class="logo-img">
    </a>

    <!-- MOBILE -->
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

      <!-- LINKS CENTER -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="property_list.php">Search</a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" href="about.php">About</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>

      <!-- RIGHT SIDE -->
      <?php if(isset($_SESSION['user_id'])) { ?>
        <a href="logout.php" class="btn btn-light me-2">Logout</a>
      <?php } else { ?>
        <a href="login.php" class="btn btn-light me-2">Sign In</a>
      <?php } ?>

      <a href="property/property_list.php" class="btn btn-primary">
        List Property
      </a>

    </div>
  </div>
</nav>

<!-- ✅ ABOUT CONTENT -->
<section class="about-section">
  <div class="container">

    <div class="row align-items-center gy-4">

      <!-- TEXT -->
      <div class="col-md-6">
        <div class="about-card">

          <h2 class="fw-bold">About Stayz</h2>

          <h5>Our Mission</h5>
          <p>We make finding and listing properties simple, transparent and fast.</p>

          <h5>Who We Are</h5>
          <p>We help users discover flats, homes and rental spaces easily.</p>

        </div>
      </div>

      <!-- IMAGE -->
      <div class="col-md-6 text-center">
        <img src="assets/images/company.jpeg"
             class="img-fluid rounded shadow"
             style="max-height:400px;">
      </div>

    </div>

    <!-- FEATURES -->
    <div class="row mt-5 text-white">

      <div class="col-md-4">
        <div class="feature-box">
          <h5>Easy Search</h5>
          <p>Find properties quickly with smart filters.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box">
          <h5>Verified Listings</h5>
          <p>Only trusted and genuine properties.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="feature-box">
          <h5>24/7 Support</h5>
          <p>We are always here to help you.</p>
        </div>
      </div>

    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>