<?php
session_start();
include('../include/db.php');

if (!isset($_SESSION['user_id'])) die("Please login first");

$user_id = $_SESSION['user_id'];

if (!isset($_POST['property_id'], $_POST['check_in'], $_POST['check_out'])) die("Invalid request");

$property_id = (int)$_POST['property_id'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];

$property = $conn->query("SELECT price FROM properties WHERE id=$property_id")->fetch_assoc();
if (!$property) die("Property not found");

$days = ceil((strtotime($check_out) - strtotime($check_in)) / (60*60*24));
if ($days <= 0) die("Check-out must be after Check-in");

$total_price = $days * $property['price'];

$stmt = $conn->prepare("INSERT INTO bookings (user_id, property_id, check_in, check_out, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("iissd", $user_id, $property_id, $check_in, $check_out, $total_price);
$stmt->execute();

$booking_id = $stmt->insert_id;
header("Location: payment.php?booking_id=$booking_id");
exit();
?>