<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);

    mysqli_query($conn, "INSERT INTO events (title, description, category, date, time, venue) 
    VALUES ('$title','$description','$category','$date','$time','$venue')");

    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        nav {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            padding: 12px 30px;
            display: flex; justify-content: space-between; align-items:
                center;
            }
        nav .logo { color: white; font-size: 20px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        .container {
            max-width: 650px; margin: 40px auto;
            background: white; padding: 35px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }
        h2 { color: #1a237e; margin-bottom: 25px; }
        label {
            display: block; margin-bottom: 5px;
            color: #333; font-weight: bold; font-size: 14px;
        }
        input, textarea, select {
            width: 100%; padding: 10px 12px;
            margin-bottom: 18px; border: 1px solid #ccc;
            border-radius: 5px; font-size: 14px;
            font-family: Arial;
        }
        textarea { height: 100px; resize: vertical; }
        button {
            width: 100%; padding: 12px;
            background: #1a237e; color: white;
            border: none; border-radius: 5px;
            font-size: 16px; cursor: pointer;
        }
        button:hover { background: #3949ab; }
        .back {
            display: inline-block; margin-bottom: 20px;
            color: #1a237e; text-decoration: none;
        }
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
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
    <h2>Add New Event</h2>
    <form method="POST">
        <label>Event Title</label>
        <input type="text" name="title" placeholder="e.g. Hari Sukan UPTM 2026" required>

        <label>Category</label>
        <select name="category" required>
            <option value="">-- Select Category --</option>
            <option value="Academic">Academic</option>
            <option value="Sports">Sports</option>
            <option value="Cultural">Cultural</option>
            <option value="Workshop">Workshop</option>
        </select>

        <label>Description</label>
        <textarea name="description" placeholder="Describe the event..." required></textarea>

        <label>Date</label>
        <input type="date" name="date" required>

        <label>Time</label>
        <input type="time" name="time" required>

        <label>Venue</label>
        <input type="text" name="venue" placeholder="e.g. Dewan Utama UPTM" required>

        <button type="submit">Add Event</button>
    </form>
</div>
</body>
</html>