<?php
include "../include/auth.php";
include "../include/db.php";

if ($_SESSION['role'] !== 'buyer') {
    header("Location: ../login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

// Total bookings
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM bookings WHERE user_id=?");
$stmt->bind_param("i", $buyer_id);
$stmt->execute();
$totalBookings = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Buyer Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    height:100vh;
    background:
        linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
        url('../assets/images/bg2.jpg');
    background-size:cover;
    background-position:center;
    color:white;
}

/* MAIN CARD */
.dashboard-box{
    max-width:900px;
    margin:auto;
    margin-top:80px;
    background: rgba(0,0,0,0.55);
    border-radius:20px;
    padding:30px;
    backdrop-filter: blur(10px);
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

/* STAT CARD */
.stat-card{
    border-radius:15px;
    padding:25px;
    background: rgba(255,255,255,0.08);
    transition:0.3s;
}

.stat-card:hover{
    transform:translateY(-6px);
    box-shadow:0 10px 25px rgba(0,0,0,0.6);
}

/* ICON */
.icon{
    font-size:35px;
    color:#00ffcc;
}

/* BUTTONS */
.btn-modern{
    border-radius:30px;
    padding:10px 25px;
    font-weight:500;
    transition:0.3s;
    border:none;
}

.btn-blue{
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    color:white;
}

.btn-green{
    background: linear-gradient(45deg, #28a745, #5effa1);
    color:white;
}

.btn-red{
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    color:white;
}

.btn-modern:hover{
    transform:scale(1.05);
}

</style>
</head>

<body>

<div class="container">

    <div class="dashboard-box">

        <!-- HEADER -->
        <div class="header mb-4">
            <h4>Welcome, <?= $_SESSION['name'] ?> 👋</h4>

            <div class="mt-2 mt-md-0">
                <a href="../index.php" class="btn btn-blue btn-modern me-2">
                    <i class="bi bi-house-door"></i> Home
                </a>

                <a href="../logout.php" class="btn btn-red btn-modern">
                    Logout
                </a>
            </div>
        </div>

        <!-- STATS -->
        <div class="row text-center">

            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <i class="bi bi-calendar-check icon"></i>
                    <h5 class="mt-2">My Bookings</h5>
                    <h2><?= $totalBookings ?></h2>
                </div>
            </div>

        </div>

        <!-- BUTTONS -->
        <div class="text-center mt-4">

            <a href="../property/property_list.php" class="btn btn-blue btn-modern m-2">
                <i class="bi bi-building"></i> View Properties
            </a>

            <a href="my_bookings.php" class="btn btn-green btn-modern m-2">
                <i class="bi bi-list-check"></i> My Bookings
            </a>

        </div>

    </div>

</div>

</body>
</html>