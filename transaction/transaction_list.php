<?php
session_start();
include('../include/db.php');

$user_id = $_SESSION['user_id'];

$result = $conn->query("
SELECT p.title, t.amount, t.payment_status, t.payment_date
FROM transactions t
JOIN bookings b ON t.booking_id=b.id
JOIN properties p ON b.property_id=p.id
WHERE b.user_id=$user_id
ORDER BY t.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Transactions</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<h3>💳 My Transactions</h3>

<table class="table table-bordered mt-3">
<thead class="table-dark">
<tr>
<th>Property</th>
<th>Amount</th>
<th>Status</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['title']; ?></td>
<td>₹<?php echo $row['amount']; ?></td>
<td><span class="badge bg-success"><?php echo $row['payment_status']; ?></span></td>
<td><?php echo $row['payment_date']; ?></td>
</tr>
<?php } ?>

</tbody>
</table>

</div>
</body>
</html>