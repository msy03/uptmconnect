<?php 
include 'includes/db.php';
$base = '';

$id = $_GET['id'];
$event = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id=$id"));
if (!$event) { echo "Event not found!"; exit(); }

$success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $email = mysqli_real_escape_string($conn, $_POST['student_email']);
    $sid = mysqli_real_escape_string($conn, $_POST['student_id']);
    mysqli_query($conn, "INSERT INTO registrations (student_name, student_email, student_id, event_id) VALUES ('$name','$email','$sid',$id)");
    $success = "Registration successful! See you at the event!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $event['title']; ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        nav { background: linear-gradient(90deg, #b71c1c, #1a237e); padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        nav .logo { color: white; font-size: 22px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        nav a:hover { color: #ffd700; }
        .container { max-width: 750px; margin: 40px auto; padding: 0 20px; }
        .event-box { background: white; border-radius: 10px; padding: 35px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .event-box h1 { color: #1a237e; margin-bottom: 15px; }
        .event-box p { color: #555; margin-bottom: 10px; font-size: 15px; }
        .category { background: #e8eaf6; color: #1a237e; padding: 4px 12px; border-radius: 20px; font-size: 13px; display: inline-block; margin-bottom: 15px; }
        .reg-box { background: white; border-radius: 10px; padding: 35px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
        .reg-box h2 { color: #1a237e; margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }
        button { width: 100%; padding: 12px; background: #1a237e; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .success { background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        footer { background: linear-gradient(90deg, #b71c1c, #1a237e); color: white; text-align: center; padding: 20px; margin-top: 40px; }
    </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="container">
    <div class="event-box">
        <span class="category"><?php echo $event['category']; ?></span>
        <h1><?php echo $event['title']; ?></h1>
        <p>📅 Date: <?php echo $event['date']; ?></p>
        <p>⏰ Time: <?php echo $event['time']; ?></p>
        <p>📍 Venue: <?php echo $event['venue']; ?></p>
        <p style="margin-top:15px;"><?php echo $event['description']; ?></p>
    </div>

    <div class="reg-box">
        <h2>Register for this Event</h2>
        <?php if ($success) echo '<div class="success">'.$success.'</div>'; ?>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="student_name" placeholder="Your full name" required>
            <label>Email</label>
            <input type="email" name="student_email" placeholder="Your email" required>
            <label>Student ID</label>
            <input type="text" name="student_id" placeholder="e.g. AM2508019894" required>
            <button type="submit">Register Now</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2026 UPTMconnect | Universiti Poly-Tech Malaysia</p>
</footer>
</body>
</html>