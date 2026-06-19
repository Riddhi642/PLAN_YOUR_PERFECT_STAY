<?php
include('../include/db.php');

$id = $_GET['id'];

// Step 1: Delete bookings
$conn->query("DELETE FROM bookings WHERE property_id=$id");

// Step 2: Delete property images (optional but recommended)
$conn->query("DELETE FROM property_images WHERE property_id=$id");

// Step 3: Delete property
$conn->query("DELETE FROM properties WHERE id=$id");

echo "<script>
alert('Property deleted successfully!');
window.location='property_list.php';
</script>";
?>