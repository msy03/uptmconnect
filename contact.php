<?php
include 'includes/db.php';
$base = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    mysqli_query($conn, "INSERT INTO messages (name, email, message) VALUES ('$name','$email','$message')");
    $success = "Message sent successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPTMconnect - Contact</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        nav {
            background: linear-gradient(90deg, #b71c1c, #1a237e); padding: 15px 30px;
            display: flex; justify-content: space-between; align-items: center;
        }
        nav .logo { color: white; font-size: 22px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        nav a:hover { color: #ffd700; }
        .page-header {
            background: linear-gradient(135deg, #b71c1c, #1a237e);
            color: white; text-align: center; padding: 40px;
        }
        .page-header h1 { font-size: 32px; }
        .container {
            max-width: 750px; margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        .info-box, .form-box {
            background: white; border-radius: 10px;
            padding: 30px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }
        h2 { color: #1a237e; margin-bottom: 20px; }
        .info-box p { color: #555; margin-bottom: 15px; font-size: 15px; line-height: 1.6; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input, textarea {
            width: 100%; padding: 10px;
            margin-bottom: 15px; border: 1px solid #ccc;
            border-radius: 5px; font-size: 14px; font-family: Arial;
        }
        textarea { height: 100px; resize: vertical; }
        button {
            width: 100%; padding: 12px;
            background: #1a237e; color: white;
            border: none; border-radius: 5px;
            font-size: 15px; cursor: pointer;
        }
        button:hover { background: #3949ab; }
        .success {
            background: #e8f5e9; color: #2e7d32;
            padding: 10px; border-radius: 5px;
            margin-bottom: 15px; text-align: center;
        }
        footer {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            text-align: center; padding: 20px; margin-top: 40px;
        }
    </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="page-header">
    <h1>Contact Us</h1>
    <p>Get in touch with the UPTMconnect team</p>
</div>

<div class="container">
    <!-- INFO -->
    <div class="info-box">
        <h2>Campus Information</h2>
        <p>📍 Universiti Poly-Tech Malaysia<br>
        Kuala Lumpur, Malaysia</p>
        <p>📞 +603-9206 9700</p>
        <p>✉️ enquiry@uptm.edu.my</p>
        <p>🕐 Office Hours:<br>
        Monday – Friday<br>
        8:00 AM – 5:00 PM</p>
    </div>

    <!-- FORM -->
    <div class="form-box">
        <h2>Send a Message</h2>
        <?php if (isset($_POST['send'])) echo '<div class="success">Message sent successfully!</div>'; ?>
        <form method="POST">
            <label>Your Name</label>
            <input type="text" name="name" placeholder="Full name" required>
            <label>Email</label>
            <input type="email" name="email" placeholder="Your email" required>
            <label>Message</label>
            <textarea name="message" placeholder="Write your message here..." required></textarea>
            <button type="submit" name="send">Send Message</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2026 UPTMconnect | Universiti Poly-Tech Malaysia</p>
</footer>
</body>
</html>