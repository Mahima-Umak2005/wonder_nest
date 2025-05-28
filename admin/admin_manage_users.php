<?php
session_start();
require_once "../includes/config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $deleteId");
    header("Location: admin_manage_users.php");
    exit();
}

$sql = "SELECT * FROM users ORDER BY id DESC";  // order by id since no timestamp column
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../css/adminDashboard.css">
  <link rel="stylesheet" href="../css/index.css">
  <title>WonderNest - Manage Users</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }
    .delete-btn {
      background: #c0392b;
      color: white;
      padding: 5px 10px;
      text-decoration: none;
      border-radius: 5px;
    }
    .delete-btn:hover {
      background: #922b21;
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
    <h2>Manage Users</h2>

    <?php if ($result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($user['id']) ?></td>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td>
                <a href="?delete=<?= $user['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No users found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
