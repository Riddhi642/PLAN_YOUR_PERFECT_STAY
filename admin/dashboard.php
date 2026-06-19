<?php
include "auth.php";
include "../include/db.php";

// counts
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$properties = $conn->query("SELECT COUNT(*) as total FROM properties")->fetch_assoc()['total'];
$bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$transactions = $conn->query("SELECT COUNT(*) as total FROM transactions")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* BACKGROUND */
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:
        linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)),
        url('../assets/images/bg2.jpg');
    background-size: cover;
    background-position: center;
    color:white;
}

/* SIDEBAR (UNCHANGED) */
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
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
    color:white;
}

.sidebar a.active{
    background:#2563eb;
    color:white;
    border-left:4px solid #93c5fd;
}

/* MAIN */
.main-content{
    margin-left:240px;
    padding:30px;
}

/* TOP BAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

/* BUTTONS */
.btn-modern{
    border-radius:30px;
    padding:8px 20px;
    border:none;
}

.btn-blue{
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    color:white;
}

.btn-red{
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    color:white;
}

/* ✅ IMPROVED CARDS */
.stat-card{
    border-radius:15px;
    padding:20px 25px;
    background: rgba(255,255,255,0.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:0.3s;
}

.stat-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.6);
}

.stat-card h2{
    font-size:24px;
    margin:5px 0;
}

.stat-card h6{
    font-size:14px;
    color:#ccc;
}

.icon{
    font-size:30px;
    color:#00ffcc;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<?php include "sidebar.php"; ?>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">
        <h3><i class="bi bi-speedometer2"></i> Dashboard</h3>

        <div>
            <a href="../index.php" class="btn btn-blue btn-modern me-2">
                <i class="bi bi-house-door"></i> Home
            </a>

            <a href="../logout.php" class="btn btn-red btn-modern">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    <!-- ✅ IMPROVED STATS (2 PER ROW) -->
    <div class="row">

        <div class="col-md-6 mb-4">
            <div class="stat-card">
                <div>
                    <h6>Users</h6>
                    <h2><?= $users ?></h2>
                </div>
                <i class="bi bi-people icon"></i>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="stat-card">
                <div>
                    <h6>Properties</h6>
                    <h2><?= $properties ?></h2>
                </div>
                <i class="bi bi-house icon"></i>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="stat-card">
                <div>
                    <h6>Bookings</h6>
                    <h2><?= $bookings ?></h2>
                </div>
                <i class="bi bi-calendar-check icon"></i>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="stat-card">
                <div>
                    <h6>Transactions</h6>
                    <h2><?= $transactions ?></h2>
                </div>
                <i class="bi bi-cash icon"></i>
            </div>
        </div>

    </div>

</div>

</body>
</html>