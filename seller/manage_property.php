<?php
include "../include/db.php";
include "../include/auth.php";

$seller_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM properties WHERE seller_id=$seller_id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Properties</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<h4>My Properties</h4>

<table class="table table-bordered shadow">
<tr>
<th>Title</th>
<th>Price</th>
<th>Location</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row=$result->fetch_assoc()){ ?>
<tr>
<td><?= $row['title'] ?></td>
<td><?= $row['price'] ?></td>
<td><?= $row['location'] ?></td>
<td><?= $row['status'] ?></td>
<td>
<a href="edit_property.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete_property.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
<?php } ?>

</table>

<a href="dashboard.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
