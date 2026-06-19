<?php
include "../include/auth.php";
include "../include/db.php";

if($_SESSION['role'] !== 'buyer'){
    header("Location: ../login.php");
    exit();
}

$property_id = intval($_GET['id']);
$buyer_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM properties WHERE id=?");
$stmt->bind_param("i",$property_id);
$stmt->execute();
$property = $stmt->get_result()->fetch_assoc();

if(isset($_POST['book'])){

    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $stmt = $conn->prepare("INSERT INTO bookings
        (user_id, property_id, check_in, check_out, status)
        VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iiss",$buyer_id,$property_id,$check_in,$check_out);
    $stmt->execute();

    header("Location: my_bookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Property</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background: linear-gradient(135deg,#4e73df,#1cc88a);
    min-height:100vh;
}
.card{
    border-radius:20px;
}
</style>
</head>

<body>
<div class="container py-5 d-flex justify-content-center">

<div class="card shadow p-4" style="max-width:500px;width:100%;">
    <h4 class="mb-3"><?= $property['title'] ?></h4>
    <p><b>Location:</b> <?= $property['location'] ?></p>
    <p><b>Price:</b> ₹<?= $property['price'] ?> / day</p>

    <form method="POST">
        <div class="mb-3">
            <label>Check In</label>
            <input type="date" name="check_in" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Check Out</label>
            <input type="date" name="check_out" class="form-control" required>
        </div>

        <button type="submit" name="book" class="btn btn-primary w-100">
            Confirm Booking
        </button>
    </form>
</div>

</div>
</body>
</html>  