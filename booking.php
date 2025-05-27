<?php
session_start();
require_once "includes/config.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$hotel_id = $_POST['hotel_id'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$guests = $_POST['guests'];

$stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, check_in, check_out, guests) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissi", $user_id, $hotel_id, $check_in, $check_out, $guests);

if ($stmt->execute()) {
  echo "Booking successful! <a href='dashboard.php'>Go to Dashboard</a>";
} else {
  echo "Booking failed. Try again.";
}
?>
