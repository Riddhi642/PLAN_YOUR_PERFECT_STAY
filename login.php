<?php
session_start();
include "include/db.php";

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role, status FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        if ($row['status'] == 'blocked') {
            $error = "Your account is blocked!";
        }
        elseif (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name']    = $row['name'];
            $_SESSION['role']    = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } 
            elseif ($row['role'] == 'seller') {
                header("Location: seller/dashboard.php");
            } 
            else {
                header("Location: buyer/dashboard.php");
            }
            exit;

        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "Account not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign In | Stayz</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* 🌙 DARK BACKGROUND */
body {
    font-family: 'Segoe UI', sans-serif;
    background: 
        linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)),
        url('assets/images/bg2.jpg');
    background-size: cover;
    background-position: center;
    height: 100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    color:#fff;
}

/* 🌟 CARD */
.auth-card {
    width: 400px;
    padding: 35px;
    border-radius: 20px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(15px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.7);
}

/* TITLE */
.auth-card h3 {
    text-align:center;
    margin-bottom:25px;
}

/* INPUT */
.form-control {
    height:50px;
    border-radius:10px;
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.2);
    color:#fff;
}

.form-control::placeholder{
    color:#ccc;
}

.form-control:focus{
    background: rgba(255,255,255,0.1);
    box-shadow:0 0 0 2px rgba(0,198,255,0.4);
    border:none;
    color:#fff;
}

/* BUTTON */
.btn-custom {
    height:50px;
    border-radius:10px;
    font-weight:600;
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    color:#fff;
    transition:0.3s;
}

.btn-custom:hover {
    transform:scale(1.03);
}

/* LINKS */
a {
    color:#00c6ff;
    text-decoration:none;
}

a:hover {
    text-decoration:underline;
}

/* ALERT */
.alert {
    border-radius:10px;
}

</style>
</head>

<body>

<div class="auth-card">

    <h3>Welcome Back 👋</h3>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <input type="email" name="email" class="form-control"
                   placeholder="Email Address" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="Password" required>
        </div>

        <button type="submit" name="login" class="btn btn-custom w-100">
            Sign In
        </button>

    </form>

    <p class="text-center mt-4 mb-1">
        Don’t have an account?
        <a href="register.php">Sign Up</a>
    </p>

    <p class="text-center">
        <a href="forgot_password.php">Forgot your password?</a>
    </p>

</div>

</body>
</html>