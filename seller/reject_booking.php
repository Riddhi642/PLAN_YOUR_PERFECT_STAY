<?php
include('../include/db.php');

$id = $_GET['id'];

$conn->query("UPDATE bookings SET status='rejected' WHERE id=$id");

echo "<script>alert('Rejected!'); window.location='seller_requests.php';</script>";
?>