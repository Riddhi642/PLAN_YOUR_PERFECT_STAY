<?php
session_start();
include('../include/db.php');

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

if (!isset($_GET['id']) || !isset($_GET['property_id'])) {
    exit("Invalid request");
}

$image_id = $_GET['id'];
$property_id = $_GET['property_id'];
$seller_id = $_SESSION['user_id'];

// Check property belongs to seller
$stmt = $conn->prepare("SELECT id FROM properties WHERE id=? AND seller_id=?");
$stmt->bind_param("ii", $property_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    exit("Unauthorized access");
}

// Get image filename
$stmt = $conn->prepare("SELECT image FROM property_images WHERE id=? AND property_id=?");
$stmt->bind_param("ii", $image_id, $property_id);
$stmt->execute();
$result = $stmt->get_result();
$image = $result->fetch_assoc();

if ($image) {

    $file_path = "../uploads/properties/" . $image['image'];

    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Delete from database
    $del = $conn->prepare("DELETE FROM property_images WHERE id=?");
    $del->bind_param("i", $image_id);
    $del->execute();
}

header("Location: edit_property.php?id=" . $property_id);
exit();
?>
