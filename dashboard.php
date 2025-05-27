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
?>

<h2>Welcome, <?= $user['name'] ?>!</h2>
<a href="logout.php">Logout</a>

<h3>Your Bookings</h3>
<table border="1">
  <tr>
    <th>Hotel</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Guests</th>
  </tr>
  <?php while ($row = $bookings->fetch_assoc()): ?>
    <tr>
      <td><?= $row['hotel_name'] ?></td>
      <td><?= $row['check_in'] ?></td>
      <td><?= $row['check_out'] ?></td>
      <td><?= $row['guests'] ?></td>
    </tr>
  <?php endwhile; ?>
</table>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Dashboard</title>
    <link rel="stylesheet" href="css/userDashboard.css">
</head>
<body>
    <!-- Header & Navigation -->
    <header class="header">
        <nav class="nav-container">
            <div class="logo-section">
                <div class="logo">L</div>
                <div class="brand-name">LuxStay</div>
            </div>

            <div class="menu-toggle" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul class="nav-menu" id="navMenu">
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span>🏠</span> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('view-hotels')">
                        <span>🏨</span> View Hotels
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('book-hotel')">
                        <span>📅</span> Book a Hotel
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('my-bookings')">
                        <span>📋</span> My Bookings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('contact')">
                        <span>📞</span> Contact
                    </a>
                </li> -->
                <li class="nav-item">
                  <a href="#">Dashboard</a>
                  <a href="admin_manage_hotel.php">View Hotels</a>
                </li>
            </ul>

            <div class="user-profile">
                <div class="profile-info">
                    <div class="welcome-text">Welcome back,</div>
                    <div class="user-name" id="userName"> <?= $user['name'] ?>!</div>
                </div>
                <div class="profile-avatar" onclick="toggleProfileMenu()">JD</div>
                <a href="#" class="logout-btn" ><a href="logout.php">Logout</a></a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Dashboard Section -->
        <section class="page-section active" id="dashboard">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Welcome to Your Dashboard</h1>
                <p class="dashboard-subtitle">Manage your bookings and explore luxury accommodations</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bookings">📅</div>
                    <div class="stat-number">5</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon hotels">🏨</div>
                    <div class="stat-number">12</div>
                    <div class="stat-label">Hotels Visited</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon spent">💰</div>
                    <div class="stat-number">$2,450</div>
                    <div class="stat-label">Total Spent</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon reviews">⭐</div>
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Avg Rating</div>
                </div>
            </div>

            <div class="recent-section">
                <h2 class="section-title">
                    <span>📋</span> Recent Bookings
                </h2>
                
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="hotel-name">Grand Palace Hotel</div>
                        <div class="booking-status status-confirmed">Confirmed</div>
                    </div>
                    <div class="booking-details">
                        <div><strong>Check-in:</strong> Dec 15, 2024</div>
                        <div><strong>Check-out:</strong> Dec 18, 2024</div>
                        <div><strong>Guests:</strong> 2 Adults</div>
                        <div><strong>Room:</strong> Deluxe Suite</div>
                    </div>
                </div>

                <div class="booking-card">
                    <div class="booking-header">
                        <div class="hotel-name">Ocean View Resort</div>
                        <div class="booking-status status-pending">Pending</div>
                    </div>
                    <div class="booking-details">
                        <div><strong>Check-in:</strong> Jan 10, 2025</div>
                        <div><strong>Check-out:</strong> Jan 14, 2025</div>
                        <div><strong>Guests:</strong> 1 Adult</div>
                        <div><strong>Room:</strong> Ocean Suite</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <div class="action-card" onclick="showSection('view-hotels')">
                    <div class="action-icon">🔍</div>
                    <div class="action-title">Browse Hotels</div>
                    <div class="action-description">Explore our collection of luxury hotels worldwide</div>
                </div>
                <div class="action-card" onclick="showSection('book-hotel')">
                    <div class="action-icon">📅</div>
                    <div class="action-title">New Booking</div>
                    <div class="action-description">Reserve your next perfect getaway</div>
                </div>
                <div class="action-card" onclick="showSection('my-bookings')">
                    <div class="action-icon">📋</div>
                    <div class="action-title">Manage Bookings</div>
                    <div class="action-description">View and modify your reservations</div>
                </div>
            </div>
        </section>

        <!-- View Hotels Section -->
        <section class="page-section" id="view-hotels">
            <div class="page-header">
                <h1 class="page-title">Luxury Hotels</h1>
                <p class="page-subtitle">Discover extraordinary accommodations around the world</p>
            </div>

            <div class="hotel-grid">
                <div class="hotel-card">
                    <div class="hotel-image">🏨</div>
                    <div class="hotel-info">
                        <h3 class="hotel-title">Grand Palace Hotel</h3>
                        <p class="hotel-location">📍 New York, USA</p>
                        <div class="hotel-price">$299/night</div>
                        <button class="btn btn-primary" onclick="bookHotel('Grand Palace Hotel')">Book Now</button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image">🏖️</div>
                    <div class="hotel-info">
                        <h3 class="hotel-title">Ocean View Resort</h3>
                        <p class="hotel-location">📍 Maldives</p>
                        <div class="hotel-price">$599/night</div>
                        <button class="btn btn-primary" onclick="bookHotel('Ocean View Resort')">Book Now</button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image">🏔️</div>
                    <div class="hotel-info">
                        <h3 class="hotel-title">Mountain Lodge</h3>
                        <p class="hotel-location">📍 Swiss Alps</p>
                        <div class="hotel-price">$450/night</div>
                        <button class="btn btn-primary" onclick="bookHotel('Mountain Lodge')">Book Now</button>
                    </div>
                </div>

                <div class="hotel-card">
                    <div class="hotel-image">🌆</div>
                    <div class="hotel-info">
                        <h3 class="hotel-title">City Center Luxury</h3>
                        <p class="hotel-location">📍 London, UK</p>
                        <div class="hotel-price">$399/night</div>
                        <button class="