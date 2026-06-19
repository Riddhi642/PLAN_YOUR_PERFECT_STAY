<?php
include "../include/auth.php";
include "../include/db.php";

if($_SESSION['role'] !== 'buyer'){
    header("Location: ../login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
SELECT b.*, p.title 
FROM bookings b
JOIN properties p ON b.property_id=p.id
WHERE b.user_id=?
");
$stmt->bind_param("i",$buyer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
}
.card{
    border-radius:20px;
}
.badge{
    padding:6px 12px;
    border-radius:20px;
}
</style>
</head>

<body>
<div class="container py-5">

<div class="card shadow p-4">
<h4 class="mb-4">My Bookings</h4>

<table class="table text-center">
<tr>
    <th>Property</th>
    <th>Check In</th>
    <th>Check Out</th>
    <th>Status</th>
</tr>

<?php while($row=$result->fetch_assoc()){ ?>
<tr>
    <td><?= $row['title'] ?></td>
    <td><?= $row['check_in'] ?></td>
    <td><?= $row['check_out'] ?></td>
    <td>
        <?php if($row['status']=="pending"){ ?>
            <span class="badge bg-warning text-dark">Pending</span>
        <?php } elseif($row['status']=="approved"){ ?>
            <span class="badge bg-success">Approved</span>
        <?php } else { ?>
            <span class="badge bg-danger">Rejected</span>
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>
</body>
</html>
