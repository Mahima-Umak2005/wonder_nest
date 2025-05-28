<?php
session_start();
require_once "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=my_bookings.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings with hotel info
$sql = "SELECT b.id, b.check_in, b.check_out, b.guests, b.total_price, b.created_at, h.name, h.location 
        FROM bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WonderNest - My Bookings</title>
  <link rel="stylesheet" href="css/adminDashboard.css">
    <link rel="stylesheet" href="css/index.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      max-width: 800px;
      margin: 40px auto;
      padding: 0 20px;
      color: #333;
      background-color: #fff;
    }

    h1 {
      color: #a94064;
      font-size: 2.5rem;
      margin-bottom: 20px;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
    }

    thead {
      background-color: #a94064;
      color: #fff;
      font-weight: bold;
    }

    tbody tr:nth-child(even) {
      background-color: #fafafa;
    }

    tbody tr:hover {
      background-color: #f1d4db;
    }

    .no-bookings {
      text-align: center;
      margin-top: 50px;
      font-size: 1.2rem;
      color: #555;
    }
  </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <div class="auth-buttons">
            <a href="dashboard.php" class="btn btn-login">Dashboard</a>
            <a href="my_bookings.php" class="btn btn-login">My Bookings</a>
            <a href="logout.php" class="btn btn-login">Logout</a>
        </div>
    </header>

  <h1>My Bookings</h1>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Hotel Name</th>
          <th>Location</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Guests</th>
          <th>Total Price (₹)</th>
          <th>Booked On</th>
        </tr>
      </thead>
      <tbody>
        <?php while($booking = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($booking['name']) ?></td>
            <td><?= htmlspecialchars($booking['location']) ?></td>
            <td><?= htmlspecialchars($booking['check_in']) ?></td>
            <td><?= htmlspecialchars($booking['check_out']) ?></td>
            <td><?= htmlspecialchars($booking['guests']) ?></td>
            <td><?= number_format($booking['total_price'], 2) ?></td>
            <td><?= date("d M Y, H:i", strtotime($booking['created_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="no-bookings">You have no bookings yet.</p>
  <?php endif; ?>

</body>
</html>
