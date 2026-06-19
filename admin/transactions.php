 <?php
include "auth.php";
include "../include/db.php";

$result = $conn->query("
    SELECT id, booking_id, amount, payment_status, payment_date
    FROM transactions
");

if(!$result){
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transactions | Admin</title>

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

.sidebar a:hover{
    background:#1e293b;
    color:white;
}

.sidebar .logout{
    color:#f87171;
}

.main-content{
    margin-left:240px;
    padding:25px;
}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php include "sidebar.php"; ?>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-cash"></i> Transactions Management</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Booking ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['booking_id'] ?></td>
                        <td>₹<?= $row['amount'] ?></td>

                        <td>
                            <?php if($row['payment_status']=='paid'){ ?>
                                <span class="badge bg-success">Paid</span>
                            <?php } elseif($row['payment_status']=='failed'){ ?>
                                <span class="badge bg-danger">Failed</span>
                            <?php } else { ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php } ?>
                        </td>

                        <td><?= $row['payment_date'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>

        </div>
    </div>

</div>
</div>
</div>

</body>
</html>
