<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include '../includes/db.php';

// DELETE event
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM events WHERE id=$id");
    header('Location: dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
        nav a:hover { color: #ffd700; }
        .container { padding: 30px; max-width: 1100px; margin: 0 auto; }
        h2 { color: #1a237e; margin-bottom: 20px; }
        .btn-add {
            background: #1a237e; color: white;
            padding: 10px 20px; border-radius: 5px;
            text-decoration: none; display: inline-block;
            margin-bottom: 20px;
        }
        table {
            width: 100%; background: white;
            border-collapse: collapse;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-radius: 10px; overflow: hidden;
        }
        th {
            background: #1a237e; color: white;
            padding: 12px 15px; text-align: left;
        }
        td { padding: 12px 15px; border-bottom: 1px solid #eee; }
        tr:hover { background: #f5f5f5; }
        .btn-edit {
            background: #ffd700; color: #1a237e;
            padding: 5px 12px; border-radius: 4px;
            text-decoration: none; font-size: 13px;
            margin-right: 5px;
        }
        .btn-delete {
            background: #c62828; color: white;
            padding: 5px 12px; border-radius: 4px;
            text-decoration: none; font-size: 13px;
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
    <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
    <a href="add_event.php" class="btn-add">+ Add New Event</a>

    <table>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Venue</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM events ORDER BY date ASC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                    <td>'.$row['title'].'</td>
                    <td>'.$row['category'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['venue'].'</td>
                    <td>
                        <a href="view_registrations.php?id='.$row['id'].'" style="background:#1a237e;color:white;padding:5px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-right:5px;">Registrations</a>
                        <a href="dashboard.php?delete='.$row['id'].'" class="btn-delete" onclick="return confirm(\'Delete this event?\')">Delete</a>
                    </td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="5" style="text-align:center;color:#888;">No events yet. Add one!</td></tr>';
        }
        ?>
    </table>
<!-- PENDING ADMIN REQUESTS -->
<h2 style="margin-top:40px; color:#b71c1c;">Pending Admin Requests</h2>
<?php
$requests = mysqli_query($conn, "SELECT * FROM admin_requests WHERE status='pending'");
if (mysqli_num_rows($requests) > 0) {
    echo '<table style="width:100%;margin-top:15px;background:white;border-collapse:collapse;border-radius:10px;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,0.1);">
    <tr style="background:linear-gradient(90deg,#b71c1c,#1a237e);color:white;">
        <th style="padding:12px 15px;text-align:left;">Name</th>
        <th style="padding:12px 15px;text-align:left;">Email</th>
        <th style="padding:12px 15px;text-align:left;">Requested</th>
        <th style="padding:12px 15px;text-align:left;">Action</th>
    </tr>';
    while ($req = mysqli_fetch_assoc($requests)) {
        echo '<tr>
            <td style="padding:12px 15px;border-bottom:1px solid #eee;">'.$req['name'].'</td>
            <td style="padding:12px 15px;border-bottom:1px solid #eee;">'.$req['email'].'</td>
            <td style="padding:12px 15px;border-bottom:1px solid #eee;">'.$req['created_at'].'</td>
            <td style="padding:12px 15px;border-bottom:1px solid #eee;">
                <a href="approve_admin.php?id='.$req['id'].'&action=approve" 
                   style="background:#2e7d32;color:white;padding:5px 12px;border-radius:4px;text-decoration:none;font-size:13px;margin-right:5px;">Approve</a>
                <a href="approve_admin.php?id='.$req['id'].'&action=reject" 
                   style="background:#c62828;color:white;padding:5px 12px;border-radius:4px;text-decoration:none;font-size:13px;">Reject</a>
            </td>
        </tr>';
    }
    echo '</table>';
} else {
    echo '<p style="color:#888;margin-top:10px;">No pending requests.</p>';
}
?>
</div>
</body>
</html>