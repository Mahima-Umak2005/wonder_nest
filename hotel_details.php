<?php
session_start();
require_once "includes/config.php";

// Redirect if hotel ID not set
if (!isset($_GET['id'])) {
    header("Location: hotel_list.php");
    exit();
}

$hotel_id = intval($_GET['id']);

// Fetch hotel details
$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();

if (!$hotel) {
    echo "Hotel not found.";
    exit();
}

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=hotel_details.php?id=$hotel_id");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = intval($_POST['guests']);

    if (strtotime($check_in) >= strtotime($check_out)) {
        $error = "Check-out date must be after check-in date.";
    } elseif ($guests < 1) {
        $error = "Number of guests must be at least 1.";
    } else {
        $nights = ceil((strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24));
        $total_price = $nights * $hotel['price'];

        // Insert into bookings table
        $insert = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, check_in, check_out, guests, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("iissid", $user_id, $hotel_id, $check_in, $check_out, $guests, $total_price);

        if ($insert->execute()) {
            $success = "Hotel Booked Successfully! Total Price: ₹" . number_format($total_price, 2);
        } else {
            $error = "Database error: Could not complete booking.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WonderNest - <?= htmlspecialchars($hotel['name']) ?> - Details</title>
  <link rel="stylesheet" href="css/hotel_details.css" />
  <link rel="stylesheet" href="css/adminDashboard.css">
  <link rel="stylesheet" href="css/index.css">
  
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
  <h2><?= htmlspecialchars($hotel['name']) ?></h2>

  <img src="images/hotels/<?= htmlspecialchars($hotel['image']) ?>" alt="Hotel Image">

  <p><strong>Location:</strong> <?= htmlspecialchars($hotel['location']) ?></p>
  <p><strong>Price per night:</strong> ₹<?= number_format($hotel['price'], 2) ?></p>
  <p><strong>Rating:</strong> ⭐ <?= number_format($hotel['rating'], 1) ?></p>
  <p><?= nl2br(htmlspecialchars($hotel['description'])) ?></p>

  <h3>Book This Hotel</h3>

  <?php if ($error) echo "<p class='error'>$error</p>"; ?>
  <?php if ($success) echo "<p class='success'>$success</p>"; ?>

  <form method="post">
      <label>Check-in Date:</label>
      <input type="date" name="check_in" required>

      <label>Check-out Date:</label>
      <input type="date" name="check_out" required>

      <label>Number of Guests:</label>
      <input type="number" name="guests" min="1" value="1" required>

      <button type="submit">Book Now</button>
  </form>

</body>
</html>
