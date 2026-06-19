<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us | Stayz</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- CSS -->
<link rel="stylesheet" href="assets/css/style.css">

<style>

/* BODY */
body{
    padding-top: 80px;
    font-family:'Segoe UI',sans-serif;
}

/* NAVBAR */
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

/* LOGO */
.logo-img{
    height: 45px;
}

/* BACKGROUND */
.contact-section{
    background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                url("assets/images/bg.jpg") center/cover no-repeat;
    min-height: 100vh;
    display: flex;
    align-items: center;
    color: #fff;
}

/* GLASS CARD */
.glass-card{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border-radius: 15px;
    padding: 35px;
}

/* MODERN FORM */
.form-control{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    border-radius: 10px;
}

.form-control:focus{
    background: rgba(255,255,255,0.12);
    border-color: #00d4ff;
    box-shadow: 0 0 10px rgba(0,212,255,0.4);
    color: #fff;
}

.form-floating label{
    color: #ccc;
}

/* BUTTON */
.modern-btn{
    height: 50px;
    font-weight: 600;
    border-radius: 12px;
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    border: none;
    transition: 0.3s;
}

.modern-btn:hover{
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}

/* IMAGE */
.company-img{
    width:100%;
    border-radius:12px;
    margin-bottom:15px;
}

/* WIDTH */
.contact-section .container{
    max-width:1100px;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar">
  <div class="container">

    <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo_pps.jpg" class="logo-img">
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="property_list.php">Search</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
      </ul>

      <?php if(isset($_SESSION['user_id'])){ ?>
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

<!-- CONTACT -->
<section class="contact-section">
<div class="container">

<div class="row align-items-center gy-4">

<!-- FORM -->
<div class="col-md-6">
<div class="glass-card">

<h3 class="fw-bold mb-4 text-center">Get in Touch</h3>

<form>

<div class="form-floating mb-3">
<input type="text" class="form-control" placeholder="Name">
<label>Your Name</label>
</div>

<div class="form-floating mb-3">
<input type="email" class="form-control" placeholder="Email">
<label>Email Address</label>
</div>

<div class="form-floating mb-3">
<input type="text" class="form-control" placeholder="Subject">
<label>Subject</label>
</div>

<div class="form-floating mb-3">
<textarea class="form-control" style="height:120px;" placeholder="Message"></textarea>
<label>Message</label>
</div>

<button class="btn modern-btn w-100">
<i class="bi bi-send"></i> Send Message
</button>

</form>

</div>
</div>

<!-- INFO -->
<div class="col-md-6">
<div class="glass-card text-center">

<img src="assets/images/company.jpeg" class="company-img">

<h5 class="fw-bold">Our Office</h5>

<p><i class="bi bi-geo-alt-fill"></i> Pune, Maharashtra, India</p>

<iframe
src="https://www.google.com/maps?q=Pune%20Maharashtra&output=embed"
width="100%"
height="200"
style="border:0;border-radius:12px;"
loading="lazy">
</iframe>

<hr>

<p><i class="bi bi-envelope-fill"></i> support@stayz.com</p>
<p><i class="bi bi-telephone-fill"></i> +91 98765 43210</p>

</div>
</div>

</div>

</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>