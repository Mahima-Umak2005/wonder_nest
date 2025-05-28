<?php
session_start();
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Search by email since you're registering using email
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['name']; // or $username
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderNest - Login & Register</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/adminDashboard.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <nav class="nav">
            <a href="../index.php">Home</a>
            <!-- <a href="hotel_list.php">Hotel List</a> -->
            <a href="../contact.php">Contact Us</a>
            <a href="../about.php">About Us</a>
        </nav>
    </header>


    <!-- Main Container -->
    <div class="container">
        <div class="auth-container">
            <!-- User Type Selection -->
            <div class="user-type-selection">
                <h2 class="user-type-title">Choose Login Type</h2>
                <div class="user-type-buttons">
                    <button class="user-type-btn">
                        <a href="../login.php" style="text-decoration: none;">User Login</a>
                    </button>
                    <button class="user-type-btn active">
                        <a href="#" style="text-decoration: none;">Admin Login</a>
                    </button>
                </div>
            </div>
            <!-- Loading Animation -->
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p>Processing...</p>
            </div>

            <!-- Login Form -->
            <div class="form-container" >
            <form class="form" id="loginForm" method="post">
    <h3 class="form-title" id="loginTitle">Admin Login</h3>
    
    <div class="form-group">
        <input type="text" class="form-input" placeholder="Email" name="username" required>
    </div>
    
    <div class="form-group">
        <div class="password-container">
            <input type="password" class="form-input" placeholder="Password" required id="loginPassword" name="password">
            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">👁️</button>
        </div>
    </div>
    
    <button type="submit" class="submit-btn">Login</button>
    
    <div class="form-footer">
        <p>Don't have an account? <a href="admin_register.php" class="form-link">Register here</a></p>
        <p><a href="#" class="form-link">Forgot Password?</a></p>
    </div>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>
</body>
</html>