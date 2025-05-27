<?php
session_start();
require_once "includes/config.php";

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

// Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=hotel_details.php?id=$hotel_id");
    exit();
}

$user_id = $_SESSION['user_id'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = intval($_POST['guests']);

    // Basic validation: check dates
    if (strtotime($check_in) >= strtotime($check_out)) {
        $error = "Check-out date must be after check-in date.";
    } elseif ($guests < 1) {
        $error = "Number of guests must be at least 1.";
    } else {
        // Calculate number of nights
        $diff = strtotime($check_out) - strtotime($check_in);
        $nights = ceil($diff / (60 * 60 * 24));

        $total_price = $nights * $hotel['price'];

        // Insert booking
        $insert = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, check_in, check_out, guests, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("iissid", $user_id, $hotel_id, $check_in, $check_out, $guests, $total_price);

        if ($insert->execute()) {
            $success = "Booking successful! Total price: ₹" . number_format($total_price, 2);
        } else {
            $error = "Database error: Could not complete booking.";
        }
    }
}
?>

<h2><?= htmlspecialchars($hotel['name']) ?></h2>
<img src="images/hotels/<?= htmlspecialchars($hotel['image']) ?>" width="300" alt="Hotel Image">
<p><strong>Location:</strong> <?= htmlspecialchars($hotel['location']) ?></p>
<p><strong>Price per night:</strong> ₹<?= number_format($hotel['price'], 2) ?></p>
<p><strong>Rating:</strong> ⭐ <?= number_format($hotel['rating'], 1) ?></p>
<p><?= nl2br(htmlspecialchars($hotel['description'])) ?></p>

<h3>Book This Hotel</h3>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label>Check-in Date:</label><br>
    <input type="date" name="check_in" required><br><br>

    <label>Check-out Date:</label><br>
    <input type="date" name="check_out" required><br><br>

    <label>Number of Guests:</label><br>
    <input type="number" name="guests" min="1" value="1" required><br><br>

    <button type="submit">Book Now</button>
</form>
