<?php 
include 'includes/db.php'; 
$base = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPTMconnect - Events</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        .filter-bar {
            background: white; padding: 15px 30px;
            display: flex; gap: 15px; align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .filter-bar select, .filter-bar input {
            padding: 8px 12px; border: 1px solid #ccc;
            border-radius: 5px; font-size: 14px;
        }
        .filter-bar button {
            background: #1a237e; color: white;
            border: none; padding: 8px 20px;
            border-radius: 5px; cursor: pointer;
        }
        .section { padding: 40px 30px; }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px; max-width: 1100px; margin: 0 auto;
        }
        .event-card {
            background: white; border-radius: 10px;
            padding: 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .event-card .category {
            background: #e8eaf6; color: #1a237e;
            padding: 3px 10px; border-radius: 20px;
            font-size: 12px; display: inline-block; margin-bottom: 10px;
        }
        .event-card h3 { color: #1a237e; margin-bottom: 10px; }
        .event-card p { color: #555; font-size: 14px; margin-bottom: 5px; }
        .event-card a {
            display: inline-block; margin-top: 10px;
            background: #1a237e; color: white;
            padding: 8px 18px; border-radius: 5px;
            text-decoration: none; font-size: 14px;
        }
        footer {
            background: linear-gradient(90deg, #b71c1c, #1a237e); color: white;
            text-align: center; padding: 20px; margin-top: 40px;
        }
    </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>
<div class="page-header">
    <h1>Campus Events</h1>
    <p>Browse and register for UPTM events</p>
</div>

<div class="filter-bar">
    <form method="GET" style="display:flex; gap:10px;">
        <select name="category">
            <option value="">All Categories</option>
            <option value="Academic">Academic</option>
            <option value="Sports">Sports</option>
            <option value="Cultural">Cultural</option>
            <option value="Workshop">Workshop</option>
        </select>
        <input type="date" name="date">
        <button type="submit">Filter</button>
    </form>
</div>

<div class="section">
    <div class="events-grid">
        <?php
        $where = "WHERE 1=1";
        if (!empty($_GET['category'])) {
            $cat = mysqli_real_escape_string($conn, $_GET['category']);
            $where .= " AND category='$cat'";
        }
        if (!empty($_GET['date'])) {
            $date = mysqli_real_escape_string($conn, $_GET['date']);
            $where .= " AND date='$date'";
        }
        $result = mysqli_query($conn, "SELECT * FROM events $where ORDER BY date ASC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="event-card">
                    <span class="category">'.$row['category'].'</span>
                    <h3>'.$row['title'].'</h3>
                    <p>📅 '.$row['date'].' at '.$row['time'].'</p>
                    <p>📍 '.$row['venue'].'</p>
                    <p>'.$row['description'].'</p>
                    <a href="event_details.php?id='.$row['id'].'">View & Register</a>
                </div>';
            }
        } else {
            echo '<p style="text-align:center;color:#888;grid-column:1/-1">No events found.</p>';
        }
        ?>
    </div>
</div>

<footer>
    <p>&copy; 2026 UPTMconnect | Universiti Poly-Tech Malaysia</p>
</footer>
</body>
</html>