<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: login.php'); exit(); }
include '../includes/db.php';

$event_id = $_GET['id'];
$event = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id=$event_id"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrations - <?php echo $event['title']; ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        nav {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            padding: 12px 30px;
            display: flex; justify-content: space-between; align-items: center;
        }
        nav .logo { display: flex; align-items: center; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        nav a:hover { color: #ffd700; }
        .container { padding: 30px; max-width: 1100px; margin: 0 auto; }
        h2 { color: #1a237e; margin-bottom: 5px; }
        .event-info {
            background: white; padding: 15px 20px;
            border-radius: 8px; margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 5px solid #b71c1c;
        }
        .event-info p { color: #555; font-size: 14px; margin-top: 5px; }
        .count {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            color: white; padding: 10px 20px;
            border-radius: 25px; display: inline-block;
            margin-bottom: 20px; font-size: 14px;
        }
        table {
            width: 100%; background: white;
            border-collapse: collapse;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-radius: 10px; overflow: hidden;
        }
        th {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            color: white; padding: 12px 15px; text-align: left;
        }
        td { padding: 12px 15px; border-bottom: 1px solid #eee; }
        tr:hover { background: #f5f5f5; }
        .back {
            display: inline-block; margin-bottom: 20px;
            background: #1a237e; color: white;
            padding: 8px 18px; border-radius: 5px;
            text-decoration: none; font-size: 14px;
        }
        .no-data {
            text-align: center; color: #888;
            padding: 40px; font-size: 16px;
        }
    </style>
</head>
<body>
<nav>
    <div class="logo" style="display:flex; align-items:center;">
        <img src="../images/logo.png" alt="UPTM Logo" style="height:60px; vertical-align:middle;">
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

    <div class="event-info">
        <h2><?php echo $event['title']; ?></h2>
        <p>📅 <?php echo $event['date']; ?> &nbsp; ⏰ <?php echo $event['time']; ?> &nbsp; 📍 <?php echo $event['venue']; ?></p>
    </div>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM registrations WHERE event_id=$event_id ORDER BY registered_at DESC");
    $count = mysqli_num_rows($result);
    echo '<div class="count">👥 Total Registrations: '.$count.'</div>';

    if ($count > 0) {
        echo '<table>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Student ID</th>
                <th>Registered At</th>
            </tr>';
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                <td>'.$i.'</td>
                <td>'.$row['student_name'].'</td>
                <td>'.$row['student_email'].'</td>
                <td>'.$row['student_id'].'</td>
                <td>'.$row['registered_at'].'</td>
            </tr>';
            $i++;
        }
        echo '</table>';
    } else {
        echo '<div class="no-data">No registrations yet for this event.</div>';
    }
    ?>
</div>
</body>
</html>