<?php
include "auth.php";
include "../include/db.php";

$msg = "";

/* UPDATE SETTINGS */
if (isset($_POST['save'])) {

    $site_name = $conn->real_escape_string($_POST['site_name']);

    $updateSettings = $conn->query(
        "UPDATE settings SET site_name='$site_name' WHERE id=1"
    );

    // Update password only if entered
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query(
            "UPDATE admin SET password='$password' WHERE id=1"
        );
    }

    $msg = $updateSettings ? "Settings updated successfully!" : "Something went wrong!";
}

/* FETCH SETTINGS */
$settings = $conn->query("SELECT * FROM settings WHERE id=1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Settings | Admin</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
}

/* SAME SIDEBAR CSS AS manage_users.php */
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

/* SAME CONTENT STYLE */
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

        <!-- PAGE HEADER (same style) -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-gear"></i> Admin Settings</h3>
        </div>

        <!-- MESSAGE -->
        <?php if($msg){ ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php } ?>

        <!-- CARD (same as users page) -->
        <div class="card">
            <div class="card-body">

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Website Name</label>
                        <input type="text"
                               name="site_name"
                               class="form-control"
                               value="<?= $settings['site_name'] ?? '' ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Change Admin Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Leave blank to keep current password">
                    </div>

                    <button type="submit" name="save" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Settings
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>
</div>

</body>
</html>
