<?php
$conn = new mysqli("localhost", "root", "", "pps");

if ($conn->connect_error) {
    die("Database not connected");
}
?>
