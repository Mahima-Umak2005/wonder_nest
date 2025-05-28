<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderNest - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminDashboard.css">
    <link rel="stylesheet" href="../css/index.css">
    
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
            <a href="../logout.php" class="btn btn-login">Logout</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Admin Dashboard</h1>
            <p class="dashboard-subtitle">Manage your hotel booking platform with comprehensive administrative tools</p>
        </div>

        
        
        <!-- Admin Actions -->
        <div class="admin-actions" >
            <a href="admin_add_hotel.php" style="text-decoration: none;">
            <div class="action-card" onclick="navigateTo('add-hotel')">
                <div class="action-icon add-hotel">➕</div>
                <div class="action-title">Add New Hotel</div>
                <div class="action-description">Register new luxury hotels and accommodations to expand your platform</div>
                <div class="action-count">Add Property</div>
            </div>
            </a>
            <a href="admin_manage_hotels.php" style="text-decoration: none;">            
                <div class="action-card" onclick="navigateTo('manage-hotels')">
                <div class="action-icon manage-hotels">🏨</div>
                <div class="action-title">Manage Hotels</div>
                <div class="action-description">Edit hotel information, pricing, availability and manage property details</div>
                <div class="action-count">156 Hotels</div>
            </div></a>
            
            <a href="admin_view_bookings.php" style="text-decoration: none;"><div class="action-card" onclick="navigateTo('view-bookings')">
                <div class="action-icon view-bookings">📋</div>
                <div class="action-title">View Bookings</div>
                <div class="action-description">Monitor all reservations, check-ins, check-outs and booking statuses</div>
                <div class="action-count">2,847 Bookings</div>
            </div></a>
            <a href="hotel_list.php" style="text-decoration: none;"><div class="action-card" onclick="navigateTo('hotel-list')">
                <div class="action-icon manage-users">🏩</div>
                <div class="action-title">Hotel List</div>
                <div class="action-description">View the list of registered hotels with their details, including name, location, price, and rating</div>
                <div class="action-count">112 Hotels</div>
            </div></a>
            <a href="admin_manage_users.php" style="text-decoration: none;"><div class="action-card" onclick="navigateTo('manage-users')">
                <div class="action-icon manage-users">👥</div>
                <div class="action-title">Manage Users</div>
                <div class="action-description">Oversee user accounts, profiles, permissions and customer support</div>
                <div class="action-count">1,234 Users</div>
            </div></a>
            <a href="admin_messages.php" style="text-decoration: none;"><div class="action-card" onclick="navigateTo('view-messages')">
                <div class="action-icon view-messages">💬</div>
                <div class="action-title">View Messages</div>
                <div class="action-description">Review customer inquiries, support tickets and communication</div>
                <div class="action-count">47 New</div>
            </div></a>
        </div>
    </main>
</body>