<?php
session_start();
require_once "../includes/config.php";

// Check admin login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle delete message
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    $conn->query("DELETE FROM contact_messages WHERE id = $deleteId");  // corrected table name here too
    header("Location: admin_messages.php");
    exit();
}

// Fetch all messages ordered by submitted_at descending
$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WonderNest - User Messages</title>
  <link rel="stylesheet" href="../css/adminDashboard.css" />
  <link rel="stylesheet" href="../css/index.css" />
  <style>
    .form-container {
      max-width: 900px;
      margin: 120px auto;
      padding: 40px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .form-container h2 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 20px;
      color: var(--dark-red);
    }

    .back-link {
      display: inline-block;
      margin-bottom: 15px;
      text-decoration: none;
      color: var(--burgundy);
      font-weight: bold;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    .message-list {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .message-card {
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 12px;
      background: #fafafa;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    }

    .message-card h3 {
      margin: 0 0 10px;
      font-size: 1.2rem;
      color: var(--burgundy);
    }

    .message-card p {
      margin: 5px 0;
    }

    .message-card .timestamp {
      font-size: 0.85rem;
      color: #666;
    }

    .delete-btn {
      display: inline-block;
      margin-top: 10px;
      padding: 6px 12px;
      background: var(--dark-red);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: background 0.3s ease;
    }

    .delete-btn:hover {
      background: #7b1e1e;
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
  <div class="form-container">
    <h2>User Messages</h2>

    <div class="message-list">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="message-card">
            <h3><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</h3>
            <p><strong>Subject:</strong> <?= htmlspecialchars($row['subject']) ?></p>
            <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
            <p class="timestamp"><strong>Sent on:</strong> <?= date("F j, Y, g:i a", strtotime($row['submitted_at'])) ?></p>
            <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No messages found.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
