<?php
include "../include/db.php";
include "../include/auth.php";

if ($_SESSION['role'] !== 'seller') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['add'])) {

    $seller_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO properties 
        (seller_id,title,price,location,description) 
        VALUES (?,?,?,?,?)");

    $stmt->bind_param("isdss",
        $seller_id,$title,$price,$location,$description);

    $stmt->execute();
    $success = "Property Added Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Property</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="card shadow p-4">

<h4>Add New Property</h4>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="POST">

<input type="text" name="title" class="form-control mb-3" placeholder="Property Title" required>

<input type="number" name="price" class="form-control mb-3" placeholder="Price" required>

<input type="text" name="location" class="form-control mb-3" placeholder="Location" required>

<textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>

<button type="submit" name="add" class="btn btn-primary">Add Property</button>
<a href="dashboard.php" class="btn btn-secondary">Back</a>

</form>
</div>
</div>

</body>
</html>
