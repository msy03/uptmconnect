<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='admin'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin'] = $user['name'];
        header('Location: dashboard.php');
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-box {
            background: white; padding: 40px;
            border-radius: 10px; width: 350px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .login-box h2 {
            text-align: center; color: #1a237e;
            margin-bottom: 25px; font-size: 24px;
        }
        .login-box input {
            width: 100%; padding: 10px 15px;
            margin-bottom: 15px; border: 1px solid #ccc;
            border-radius: 5px; font-size: 14px;
        }
        .login-box button {
            width: 100%; padding: 12px;
            background: #1a237e; color: white;
            border: none; border-radius: 5px;
            font-size: 16px; cursor: pointer;
        }
        .login-box button:hover { background: #3949ab; }
        .error {
            background: #ffebee; color: #c62828;
            padding: 10px; border-radius: 5px;
            margin-bottom: 15px; font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>🎓 Admin Login</h2>
    <?php if (isset($error)) echo '<div class="error">'.$error.'</div>'; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
<div style="text-align:center; margin-top:15px; font-size:14px;">
    Need access? <a href="register.php" style="color:#1a237e;">Request Admin Account</a>
</div>    
</div>
</body>
</html>