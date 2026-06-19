<?php
session_start();
include('../include/db.php');

$booking_id = $_GET['booking_id'] ?? 0;
$booking_id = (int)$booking_id;

$booking = $conn->query("
    SELECT b.*, p.title, p.price 
    FROM bookings b 
    JOIN properties p ON b.property_id = p.id 
    WHERE b.id = $booking_id
")->fetch_assoc();

if (!$booking) die("Booking not found");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment - <?= $booking['title']; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
body {
    background: linear-gradient(135deg, #1cc88a, #4e73df);
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
}
.card-payment {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    border-radius: 25px;
    padding: 40px 30px;
    max-width: 500px;
    margin: auto;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
}
h3 {
    font-weight: 700;
    margin-bottom: 20px;
}
h5 {
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}
p {
    color: #555;
}
.price {
    font-size: 32px;
    font-weight: 700;
    color: #28a745;
    margin: 20px 0;
}
.btn-pay {
    border-radius: 30px;
    font-weight: 600;
    padding: 12px;
    background: linear-gradient(90deg, #4e73df, #1cc88a);
    color: white;
    transition: all 0.3s ease;
}
.btn-pay:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}
</style>
</head>

<body>
<div class="container py-5">
    <div class="card-payment text-center">
        <h3><i class="bi bi-credit-card-2-front"></i> Payment</h3>
        <h5><?= $booking['title']; ?></h5>
        <p><strong>Check-in:</strong> <?= $booking['check_in']; ?> | <strong>Check-out:</strong> <?= $booking['check_out']; ?></p>
        <div class="price">₹<?= number_format($booking['total_price']); ?></div>

        <form action="payment_success.php" method="POST">
            <input type="hidden" name="booking_id" value="<?= $booking['id']; ?>">
            <input type="hidden" name="amount" value="<?= $booking['total_price']; ?>">
            <button type="submit" class="btn btn-pay w-100">💳 Pay Now</button>
        </form>
    </div>
</div>
</body>
</html>