<?php
include "auth.php";
include "../include/db.php";

/* COUNTS */
$users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$properties = $conn->query("SELECT COUNT(*) AS total FROM properties")->fetch_assoc()['total'];
$bookings = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$transactions = $conn->query("SELECT COUNT(*) AS total FROM transactions")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reports | Admin</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
}

.sidebar{
    width:240px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:linear-gradient(180deg,#0f172a,#020617);
    padding-top:20px;
}

.sidebar .logo{
    color:white;
    text-align:center;
    margin-bottom:30px;
    font-weight:600;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 20px;
    color:#cbd5f5;
    text-decoration:none;
    font-size:15px;
}

.sidebar a i{ font-size:18px; }

.sidebar a:hover{
    background:#1e293b;
    color:white;
}

.sidebar .logout{ color:#f87171; }

.main-content{
    margin-left:240px;
    padding:25px;
}

.report-box{
    background:#fff;
    border-radius:14px;
    padding:30px;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php include "sidebar.php"; ?>

<div class="main-content">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-bar-chart"></i> Reports</h3>
    </div>

    <!-- CARD (SAME AS USERS PAGE) -->
    <div class="card">
        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="report-box">
                        <i class="bi bi-people fs-1 text-primary"></i>
                        <h6 class="mt-2">Users</h6>
                        <h2><?= $users ?></h2>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="report-box">
                        <i class="bi bi-house fs-1 text-success"></i>
                        <h6 class="mt-2">Properties</h6>
                        <h2><?= $properties ?></h2>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="report-box">
                        <i class="bi bi-calendar-check fs-1 text-warning"></i>
                        <h6 class="mt-2">Bookings</h6>
                        <h2><?= $bookings ?></h2>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="report-box">
                        <i class="bi bi-cash fs-1 text-danger"></i>
                        <h6 class="mt-2">Transactions</h6>
                        <h2><?= $transactions ?></h2>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
</div>
</div>

</body>
</html>
