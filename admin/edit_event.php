<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

$id = $_GET['id'];
$event = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);

    mysqli_query($conn, "UPDATE events SET title='$title', description='$description', 
    category='$category', date='$date', time='$time', venue='$venue' WHERE id=$id");
    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
 nav {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            padding: 12px 30px;
            display: flex; justify-content: space-between; align-items:
                center;
            }        nav .logo { color: white; font-size: 20px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        .container { max-width: 650px; margin: 40px auto; background: white; padding: 35px; border-radius: 10px; box-shadow: 0 3px 15px rgba(0,0,0,0.1); }
        h2 { color: #1a237e; margin-bottom: 25px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: bold; font-size: 14px; }
        input, textarea, select { width: 100%; padding: 10px 12px; margin-bottom: 18px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; font-family: Arial; }
        textarea { height: 100px; resize: vertical; }
        button { width: 100%; padding: 12px; background: #1a237e; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .back { display: inline-block; margin-bottom: 20px; color: #1a237e; text-decoration: none; }
    </style>
</head>
<body>
<nav>
    <div class="logo" style="display:flex; align-items:center;">
        <img src="../images/logo.png" alt="UPTM Logo" style="height:45px; vertical-align:middle;">
        <span style="color:white; font-size:18px; font-weight:bold; margin-left:10px;">UPTMconnect Admin</span>
            </div>
            <div>
                <a href="../index.php">View Site</a>
                <a href="dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
    </div>
</nav>        

<div class="container">
    <a href="dashboard.php" class="back">← Back</a>
    <h2>Edit Event</h2>
    <form method="POST">
        <label>Event Title</label>
        <input type="text" name="title" value="<?php echo $event['title']; ?>" required>
        <label>Category</label>
        <select name="category" required>
            <option value="Academic" <?php if($event['category']=='Academic') echo 'selected'; ?>>Academic</option>
            <option value="Sports" <?php if($event['category']=='Sports') echo 'selected'; ?>>Sports</option>
            <option value="Cultural" <?php if($event['category']=='Cultural') echo 'selected'; ?>>Cultural</option>
            <option value="Workshop" <?php if($event['category']=='Workshop') echo 'selected'; ?>>Workshop</option>
        </select>
        <label>Description</label>
        <textarea name="description"><?php echo $event['description']; ?></textarea>
        <label>Date</label>
        <input type="date" name="date" value="<?php echo $event['date']; ?>" required>
        <label>Time</label>
        <input type="time" name="time" value="<?php echo $event['time']; ?>" required>
        <label>Venue</label>
        <input type="text" name="venue" value="<?php echo $event['venue']; ?>" required>
        <button type="submit">Update Event</button>
    </form>
</div>
</body>
</html>