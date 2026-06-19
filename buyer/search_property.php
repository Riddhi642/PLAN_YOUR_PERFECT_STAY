<?php
include "../include/auth.php";
include "../include/db.php";

if($_SESSION['role'] !== 'buyer'){
    header("Location: ../login.php");
    exit();
}

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM properties 
                            WHERE location LIKE CONCAT('%', ?, '%') 
                            AND status='available'");
    $stmt->bind_param("s", $search);
} else {
    $stmt = $conn->prepare("SELECT * FROM properties WHERE status='available'");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Search Properties</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
}
.card{
    border-radius:20px;
}
</style>
</head>

<body>
<div class="container py-5">

<h3 class="text-white mb-4">Search Properties</h3>

<form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control"
               placeholder="Search by Location">
        <button class="btn btn-light">Search</button>
    </div>
</form>

<div class="row">
<?php while($row=$result->fetch_assoc()){ ?>
    <div class="col-md-4 mb-4">
        <div class="card shadow p-3">
            <h5><?= $row['title'] ?></h5>
            <p><b>Type:</b> <?= $row['property_type'] ?></p>
            <p><b>Location:</b> <?= $row['location'] ?></p>
            <p><b>Price:</b> ₹<?= $row['price'] ?> / day</p>

            <a href="book_property.php?id=<?= $row['id'] ?>"
               class="btn btn-primary w-100">
               Book Now
            </a>
        </div>
    </div>
<?php } ?>
</div>

</div>
</body>
</html>
