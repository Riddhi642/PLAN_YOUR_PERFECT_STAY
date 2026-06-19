<?php
include "include/db.php";

if (isset($_POST['register'])) {

    $name     = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $role     = $_POST['role'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($password)) {
        $error = "All fields are required!";
    }
    elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error = "Enter valid 10-digit phone number!";
    }
    elseif ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {

        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email=?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        $checkUser = $conn->prepare("SELECT id FROM users WHERE username=?");
        $checkUser->bind_param("s", $username);
        $checkUser->execute();
        $checkUser->store_result();

        $checkPhone = $conn->prepare("SELECT id FROM users WHERE phone=?");
        $checkPhone->bind_param("s", $phone);
        $checkPhone->execute();
        $checkPhone->store_result();

        if ($checkEmail->num_rows > 0) {
            $error = "Email already registered!";
        } elseif ($checkUser->num_rows > 0) {
            $error = "Username already taken!";
        } elseif ($checkPhone->num_rows > 0) {
            $error = "Phone number already registered!";
        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = $conn->prepare(
                "INSERT INTO users (name, username, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)"
            );

            $sql->bind_param("ssssss", $name, $username, $email, $phone, $hashed_password, $role);

            if ($sql->execute()) {
                $success = "Account created successfully!";
            } else {
                $error = "Something went wrong!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register | Stayz</title>
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
    width: 420px;
    padding: 35px;
    border-radius: 20px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(15px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.7);
}

/* TITLE */
.auth-card h3{
    text-align:center;
    margin-bottom:20px;
}

/* INPUT */
.form-control{
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

/* SELECT */
select.form-control{
    color:#ccc;
}

/* BUTTON */
.btn-custom{
    height:50px;
    border-radius:10px;
    font-weight:600;
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    color:#fff;
}

.btn-custom:hover{
    transform:scale(1.03);
}

/* LINKS */
a{
    color:#00c6ff;
    text-decoration:none;
}

a:hover{
    text-decoration:underline;
}

/* ALERT */
.alert{
    border-radius:10px;
}

</style>
</head>

<body>

<div class="auth-card">

<h3>Create Account</h3>

<?php if (isset($success)) { ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php } ?>

<?php if (isset($error)) { ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php } ?>

<form method="POST">

<div class="mb-3">
    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
</div>

<div class="mb-3">
    <input type="text" name="username" class="form-control" placeholder="Username" required>
</div>

<div class="mb-3">
    <input type="email" name="email" class="form-control" placeholder="Email Address" required>
</div>

<div class="mb-3">
    <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
</div>

<div class="mb-3">
    <select name="role" class="form-control" required>
        <option value="">Register As</option>
        <option value="buyer">Buyer</option>
        <option value="seller">Seller</option>
    </select>
</div>

<div class="mb-3">
    <input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<div class="mb-3">
    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
</div>

<button type="submit" name="register" class="btn btn-custom w-100">
    Create Account
</button>

</form>

<p class="text-center mt-3">
    Already have an account? 
    <a href="login.php">Login</a>
</p>

</div>

</body>
</html>