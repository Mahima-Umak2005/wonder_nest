<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- if styling is needed -->
    <style>
        body {
            font-family: Arial;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .dashboard {
            max-width: 800px;
            margin: auto;
        }
        .card {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .card a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?> 👋</h1>
    <p>Choose an option below to manage the system:</p>

    <div class="card"><a href="admin_add_hotel.php">➕ Add New Hotel</a></div>
    <div class="card"><a href="admin_manage_hotels.php">🏨 Manage Hotels</a></div>
    <div class="card"><a href="admin_view_bookings.php">📋 View Bookings</a></div>
    <div class="card"><a href="admin_manage_users.php">👤 Manage Users</a></div>
    <div class="card"><a href="admin_messages.php">📩 View Messages</a></div>
    <div class="card"><a href="admin_logout.php">🚪 Logout</a></div>
</div>

</body>
</html>
