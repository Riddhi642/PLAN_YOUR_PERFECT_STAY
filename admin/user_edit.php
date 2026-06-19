<?php
include "auth.php";
include "../include/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch user
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if(!$user){
    echo "<h3 class='text-center mt-5'>User Not Found</h3>";
    exit();
}

// Update logic
if(isset($_POST['update'])){
    $role = $_POST['role'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE users SET role=?, status=? WHERE id=?");
    $stmt->bind_param("ssi", $role, $status, $id);
    $stmt->execute();

    echo "<script>
    alert('User Updated Successfully!');
    window.location='manage_users.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f4f6f9;
    font-family: 'Segoe UI', sans-serif;
}

.page-card {
    border-radius: 15px;
    background: white;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.btn-modern {
    border-radius: 25px;
    font-weight: 500;
}
</style>
</head>

<body>

<div class="container py-5">

<div class="card page-card p-4">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">👤 Edit User</h4>
    <a href="users.php" class="btn btn-secondary btn-modern">← Back</a>
</div>

<form method="post">

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Role</label>
<select name="role" class="form-select" required>
    <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
    <option value="seller" <?php if($user['role']=='seller') echo 'selected'; ?>>Seller</option>
    <option value="buyer" <?php if($user['role']=='buyer') echo 'selected'; ?>>Buyer</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Status</label>
<select name="status" class="form-select" required>
    <option value="active" <?php if($user['status']=='active') echo 'selected'; ?>>Active</option>
    <option value="blocked" <?php if($user['status']=='blocked') echo 'selected'; ?>>Blocked</option>
</select>
</div>

</div>

<button type="submit" name="update" class="btn btn-primary btn-modern px-4">
    Update User
</button>

</form>

</div>

</div>

</body>
</html>