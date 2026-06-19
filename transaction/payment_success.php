<?php
session_start();
include('../include/db.php');

$booking_id = $_POST['booking_id'] ?? 0;
$amount = $_POST['amount'] ?? 0;

$booking_id = (int)$booking_id;
$amount = (float)$amount;

$booking = $conn->query("
    SELECT b.*, p.title, p.price 
    FROM bookings b 
    JOIN properties p ON b.property_id=p.id 
    WHERE b.id=$booking_id
")->fetch_assoc();

if (!$booking) die("Booking not found");

// Update payment status to 'paid'
$conn->query("UPDATE bookings SET status='approved', total_price=$amount WHERE id=$booking_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Success</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
body {
    background: linear-gradient(135deg, #1cc88a, #4e73df);
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
}
.card-success {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    border-radius: 25px;
    padding: 40px 30px;
    max-width: 500px;
    margin: auto;
    text-align: center;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
}
h3 { font-weight: 700; margin-bottom: 20px; color: #28a745; }
p { color: #555; margin: 5px 0; }
.price { font-size: 28px; font-weight: 700; color: #28a745; margin: 20px 0; }
.btn-modern {
    border-radius: 30px;
    font-weight: 600;
    padding: 12px;
    background: linear-gradient(90deg, #4e73df, #1cc88a);
    color: white;
    transition: all 0.3s ease;
    margin-top: 10px;
}
.btn-modern:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}
</style>
</head>

<body>
<div class="container py-5">
    <div class="card-success">
        <h3><i class="bi bi-check-circle"></i> Payment Successful</h3>

        <h5><?= $booking['title']; ?></h5>
        <p><strong>Booking ID:</strong> <?= $booking['id']; ?></p>
        <p><strong>Check-in:</strong> <?= $booking['check_in']; ?> | <strong>Check-out:</strong> <?= $booking['check_out']; ?></p>
        <div class="price">₹<?= number_format($booking['total_price']); ?></div>
        <p><strong>Status:</strong> Paid</p>

        <!-- Invoice Button -->
        <a href="invoice.php?booking_id=<?= $booking['id']; ?>" class="btn btn-modern w-100">
            🧾 Download Invoice (PDF)
        </a>
    </div>
</div>
</body>
</html>