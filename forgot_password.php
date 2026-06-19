<?php
include "include/db.php";

if (isset($_POST['reset'])) {

    $email = $_POST['email'];

    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $success = "Password reset link sent to your email (demo message).";
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Stayz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#f8f9fa; }
        .auth-card {
            max-width: 420px;
            margin: auto;
            margin-top: 80px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            background: #fff;
        }
        .form-control { height:48px; border-radius:8px; }
        .btn-primary { height:48px; border-radius:8px; }
    </style>
</head>

<body>

<div class="auth-card">
    <h3 class="text-center mb-3">Forgot Password</h3>

    <?php if (isset($success)) { ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php } ?>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Enter your registered email</label>
            <input type="email" name="email" class="form-control"
                   placeholder="your.email@example.com" required>
        </div>

        <button type="submit" name="reset" class="btn btn-primary w-100">
            Send Reset Link
        </button>
    </form>

    <p class="text-center mt-3">
        <a href="login.php" class="text-decoration-none">Back to Sign In</a>
    </p>
</div>

</body>
</html>
