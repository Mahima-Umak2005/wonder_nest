<?php
session_start();
require_once "../includes/config.php";

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all hotels
$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>WonderNest - Manage Hotels</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/adminDashboard.css">
  <link rel="stylesheet" href="../css/index.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdf7f5;
      margin: 0;
      padding: 40px;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    h2 {
      text-align: center;
      color: var(--burgundy, #8B0000);
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 1rem;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f9e6e6;
      color: var(--burgundy, #8B0000);
      text-align: left;
    }

    tr:nth-child(even) {
      background-color: #fdf2f2;
    }

    td {
      color: #333;
    }

    .action-buttons {
      display: flex;
      gap: 10px;
    }

    .button {
      padding: 8px 15px;
      background: var(--rose, #c94f7c);
      color: white;
      text-decoration: none;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: background 0.3s;
    }

    .button:hover {
      background: var(--dark-red, #7a1e1e);
    }

    .button.delete {
      background: #e74c3c;
    }

    .button.delete:hover {
      background: #c0392b;
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
  <div class="container">
   <h2>Manage Hotels</h2>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Hotel Name</th>
          <th>Location</th>
          <th>Price (₹)</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row["id"] ?></td>
              <td><?= htmlspecialchars($row["name"]) ?></td>
              <td><?= htmlspecialchars($row["location"]) ?></td>
              <td><?= number_format($row["price"], 2) ?></td>
              <td>
                <div class="action-buttons">
                  <a class="button" href="admin_edit_hotel.php?id=<?= $row['id'] ?>">Edit</a>
                  <a class="button delete" href="admin_delete_hotel.php?id=<?= $row['id'] ?>">Delete</a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" style="text-align:center; color: #888;">No hotels found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
