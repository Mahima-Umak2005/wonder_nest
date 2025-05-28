<?php
session_start();
require_once "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_query = $conn->query("SELECT name FROM users WHERE id = $user_id");
$user = $user_query->fetch_assoc();

$bookings = $conn->query("SELECT b.*, h.name AS hotel_name FROM bookings b JOIN hotels h ON b.hotel_id = h.id WHERE b.user_id = $user_id");
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchEscaped = $conn->real_escape_string($search);

$sql = "SELECT * FROM hotels WHERE name LIKE '%$searchEscaped%' OR location LIKE '%$searchEscaped%'";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderNest - Dashboard</title>
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/hotel_list.css">
</head>
<body>
    <!-- Header & Navigation -->
        <!-- Header -->
        <header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <div class="auth-buttons">
            <a href="#" class="btn btn-login">Dashboard</a>
            <a href="my_bookings.php" class="btn btn-login">My Bookings</a>
            <a href="logout.php" class="btn btn-login">Logout</a>
        </div>
    </header>

    
<form method="get" action="">
<h2>Available Hotels</h2>
  <input type="text" name="search" placeholder="Search by location or name" value="<?= htmlspecialchars($search) ?>" />
  <button type="submit">Search</button>
</form>

<?php if ($result && $result->num_rows > 0): ?>
  <div class="hotel-grid">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="hotel-card">
      <!-- <img src="../images/hotels/<?= htmlspecialchars($hotel['image']) ?>" alt="Hotel Image"> -->
        <img src="images/hotels/<?= htmlspecialchars($row['image']) ?>" class="hotel-image" alt="Hotel Image">
        <div class="hotel-content">
          <h3 class="hotel-name"><?= htmlspecialchars($row['name']) ?></h3>
          <p class="hotel-location"><?= htmlspecialchars($row['location']) ?></p>
          <p class="hotel-info">
            <span>₹<?= number_format($row['price']) ?>/night</span> | ⭐ <?= htmlspecialchars($row['rating']) ?>
          </p>
          <a href="hotel_details.php?id=<?= (int)$row['id'] ?>" class="hotel-link">View Details</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <p style="text-align:center; font-size:1.2rem; color: #777; margin-top: 40px;">No hotels found matching your search.</p>
<?php endif; ?>

  </body>
</html>