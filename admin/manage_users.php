<?php
include "auth.php";
include "../include/db.php";

$result = $conn->query("SELECT id, name, email, role, status FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users | Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (IMPORTANT) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>body{
    background:#f4f6f9;
}
.badge {
    color: #000 !important;
}

.sidebar{
    width:240px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:linear-gradient(180deg,#0f172a,#020617);
    padding-top:20px;
}

.sidebar .logo{
    color:white;
    text-align:center;
    margin-bottom:30px;
    font-weight:600;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 20px;
    color:#cbd5f5;
    text-decoration:none;
    font-size:15px;
}

.sidebar a i{
    font-size:18px;
}

.sidebar a:hover{
    background:#1e293b;
    color:white;
}

.sidebar .logout{
    color:#f87171;
}

.main-content{
    margin-left:240px;
    padding:25px;
}

    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include "sidebar.php"; ?>

       <div class="main-content">


            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="bi bi-people"></i> Users Management</h3>
            </div>

            <div class="card">
                <div class="card-body">

                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['email'] ?></td>

                                <td>
                                    <?php if($row['role']=='admin'){ ?>
                                        <span class="badge badge-admin">Admin</span>
                                    <?php } elseif($row['role']=='seller'){ ?>
                                        <span class="badge badge-seller">Seller</span>
                                    <?php } else { ?>
                                        <span class="badge badge-buyer">Buyer</span>
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php if($row['status']=='active'){ ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Blocked</span>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <a href="user_edit.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-warning">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <a href="user_delete.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this user?')">
                                       <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
