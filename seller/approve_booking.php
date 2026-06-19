<?php
include('../include/db.php');

$id = $_GET['id'];

$conn->query("UPDATE bookings SET status='approved' WHERE id=$id");

echo "<script>alert('Approved!'); window.location='seller_requests.php';</script>";
?>