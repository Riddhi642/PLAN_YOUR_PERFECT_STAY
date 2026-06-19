<?php
session_start();
include "include/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$property_id = $_GET['property_id'];
$user_id = $_SESSION['user_id'];

$property = mysqli_query($conn, 
    "SELECT * FROM properties WHERE id='$property_id'");
$data = mysqli_fetch_assoc($property);

if(isset($_POST['book'])){

    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    $price = $data['price'];

    $days = (strtotime($check_out) - strtotime($check_in)) / (60*60*24);
    $total_price = $days * $price;

    mysqli_query($conn,"INSERT INTO bookings 
    (user_id, property_id, check_in, check_out, total_price, status) 
    VALUES 
    ('$user_id','$property_id','$check_in','$check_out','$total_price','pending')");

    mysqli_query($conn,"UPDATE properties 
    SET status='booked' WHERE id='$property_id'");

    echo "<script>alert('Booking Successful!');window.location='property_list.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Property</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
<div class="card p-4 shadow">

<h4 class="fw-bold mb-3"><?php echo $data['title']; ?></h4>
<p>Price per day: ₹ <?php echo $data['price']; ?></p>

<form method="POST">

<div class="mb-3">
<label>Check In</label>
<input type="date" name="check_in" class="form-control" required>
</div>

<div class="mb-3">
<label>Check Out</label>
<input type="date" name="check_out" class="form-control" required>
</div>

<button type="submit" name="book" class="btn btn-success w-100">
Confirm Booking
</button>

</form>

</div>
</div>

</body>
</html>
