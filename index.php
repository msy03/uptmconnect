<?php 
include 'includes/db.php'; 
$base = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPTMconnect - Home</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }

        /* NAVBAR */
        nav {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo { color: white; font-size: 22px; font-weight: bold; }
        nav a {
            color: white; text-decoration: none;
            margin-left: 20px; font-size: 15px;
        }
        nav a:hover { color: #ffd700; }

        /* HERO BANNER */
        .hero {
            background: linear-gradient(135deg, #b71c1c, #1a237e);
            color: white;
            text-align: center;
            padding: 80px 20px;
        }
        .hero h1 { font-size: 42px; margin-bottom: 15px; }
        .hero p { font-size: 18px; margin-bottom: 30px; }
        .hero a {
            background: #ffd700;
            color: #1a237e;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        /* EVENTS SECTION */
        .section { padding: 50px 30px; }
        .section h2 {
            text-align: center;
            color: #1a237e;
            font-size: 28px;
            margin-bottom: 30px;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .event-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .event-card h3 { color: #1a237e; margin-bottom: 10px; }
        .event-card p { color: #555; font-size: 14px; margin-bottom: 5px; }
        .event-card a {
            display: inline-block;
            margin-top: 10px;
            background: #1a237e;
            color: white;
            padding: 8px 18px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        /* FOOTER */
        footer {
            background: linear-gradient(90deg, #b71c1c, #1a237e);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<?php include 'includes/navbar.php'; ?>
<!-- HERO -->
<div class="hero">
    <h1>Welcome to UPTMconnect</h1>
    <p>Your one-stop centre for UPTM campus events and activities</p>
    <a href="events.php">Browse Events</a>
</div>

<!-- UPCOMING EVENTS -->
<div class="section">
    <h2>Upcoming Events</h2>
    <div class="events-grid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM events ORDER BY date ASC LIMIT 3");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="event-card">
                    <h3>'.$row['title'].'</h3>
                    <p>📅 '.$row['date'].'</p>
                    <p>📍 '.$row['venue'].'</p>
                    <p>'.$row['description'].'</p>
                    <a href="event_details.php?id='.$row['id'].'">View Details</a>
                </div>';
            }
        } else {
            echo '<p style="text-align:center; color:#888;">No upcoming events yet. Check back soon!</p>';
        }
        ?>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2026 UPTMconnect | Universiti Poly-Tech Malaysia</p>
</footer>

</body>
</html>