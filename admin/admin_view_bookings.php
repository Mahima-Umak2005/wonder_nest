<?php
session_start();
require_once "../includes/config.php";

// Optional: You can add admin authentication check here
// Example:
// if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
//     header("Location: login.php");
//     exit();
// }

$sql = "SELECT b.id, b.user_id, b.hotel_id, b.check_in, b.check_out, b.guests, b.total_price, b.created_at, h.name AS hotel_name 
        FROM bookings b 
        JOIN hotels h ON b.hotel_id = h.id 
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WonderNest - View Bookings</title>
  <link rel="stylesheet" href="../css/adminDashboard.css" />
  <link rel="stylesheet" href="../css/index.css" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      max-width: 900px;
      margin: 40px auto;
      padding: 0 20px;
      color: #333;
      background-color: #fff;
    }
    h2 {
      color: #a94064;
      font-size: 2rem;
      margin-bottom: 30px;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }
    thead {
      background-color: #a94064;
      color: white;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    tbody tr:hover {
      background-color: #f9e6ef;
    }
    .no-data {
      text-align: center;
      font-size: 1.1rem;
      color: #666;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <div class="auth-buttons">
            <a href="admin_dashboard.php" class="btn btn-login" >Dashboard</a>
            <a href="../logout.php" class="btn btn-login">Logout</a>
        </div>
    </header>
  <h2>All Bookings</h2>

  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Hotel</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Guests</th>
          <th>Total Price (₹)</th>
          <th>Booked At</th>
        </tr>
      </thead>
      <tbody>
        <?php while($booking = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($booking['id']) ?></td>
            <td><?= htmlspecialchars($booking['user_id']) ?></td>
            <td><?= htmlspecialchars($booking['hotel_name']) ?></td>
            <td><?= htmlspecialchars($booking['check_in']) ?></td>
            <td><?= htmlspecialchars($booking['check_out']) ?></td>
            <td><?= htmlspecialchars($booking['guests']) ?></td>
            <td><?= number_format($booking['total_price'], 2) ?></td>
            <td><?= htmlspecialchars($booking['created_at']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="no-data">No bookings found.</p>
  <?php endif; ?>

</body>
</html>
