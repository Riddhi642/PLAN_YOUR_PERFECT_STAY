<?php
session_start();
include('../include/db.php');

$seller_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT b.*, p.title, u.name 
FROM bookings b
JOIN properties p ON b.property_id = p.id
JOIN users u ON b.user_id = u.id
WHERE p.seller_id = $seller_id
ORDER BY b.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
<div class="card shadow p-4">

<h3 class="mb-4">📩 Buyer Requests</h3>

<table class="table table-hover">
<thead class="table-dark">
<tr>
<th>Buyer</th>
<th>Property</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['title']; ?></td>

<td>
<?php if($row['status']=='pending') echo "<span class='badge bg-warning'>Pending</span>"; ?>
<?php if($row['status']=='approved') echo "<span class='badge bg-success'>Approved</span>"; ?>
<?php if($row['status']=='rejected') echo "<span class='badge bg-danger'>Rejected</span>"; ?>
</td>

<td>
<?php if($row['status']=='pending') { ?>
<a href="approve_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
<a href="reject_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
<?php } ?>
</td>

</tr>
<?php } ?>

</tbody>
</table>

</div>
</div>

</body>
</html>