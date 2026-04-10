<?php
include '../includes/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' UNION SELECT * FROM admin_requests WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "This email is already registered or pending approval!";
    } else {
        mysqli_query($conn, "INSERT INTO admin_requests (name, email, password) VALUES ('$name','$email','$password')");
        $success = "Registration request submitted! Please wait for admin approval.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #b71c1c, #1a237e);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .box {
            background: white; padding: 40px;
            border-radius: 10px; width: 380px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .box h2 {
            text-align: center; color: #1a237e;
            margin-bottom: 25px; font-size: 22px;
        }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input {
            width: 100%; padding: 10px 15px;
            margin-bottom: 15px; border: 1px solid #ccc;
            border-radius: 5px; font-size: 14px;
        }
        button {
            width: 100%; padding: 12px;
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            color: white; border: none;
            border-radius: 5px; font-size: 16px; cursor: pointer;
        }
        .success {
            background: #e8f5e9; color: #2e7d32;
            padding: 10px; border-radius: 5px;
            margin-bottom: 15px; text-align: center; font-size: 14px;
        }
        .error {
            background: #ffebee; color: #c62828;
            padding: 10px; border-radius: 5px;
            margin-bottom: 15px; text-align: center; font-size: 14px;
        }
        .login-link {
            text-align: center; margin-top: 15px; font-size: 14px;
        }
        .login-link a { color: #1a237e; text-decoration: none; }
    </style>
</head>
<body>
<div class="box">
    <h2>🎓 Request Admin Access</h2>
    <?php if ($success) echo '<div class="success">'.$success.'</div>'; ?>
    <?php if ($error) echo '<div class="error">'.$error.'</div>'; ?>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Your full name" required>
        <label>Email</label>
        <input type="email" name="email" placeholder="Your email" required>
        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required>
        <label>Confirm Password</label>
        <input type="password" name="confirm" placeholder="Confirm password" required>
        <button type="submit">Submit Request</button>
    </form>
    <div class="login-link">
        Already have access? <a href="login.php">Login here</a>
    </div>
</div>
</body>
</html>