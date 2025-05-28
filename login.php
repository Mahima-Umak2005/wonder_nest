<?php
session_start();
require_once "includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    
    if ($stmt->num_rows == 1) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $user_id;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "User not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderNest - Login & Register</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/adminDashboard.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="contact.php">Contact Us</a>
            <a href="about.php">About Us</a>
        </nav>
    </header>
    


    <!-- Main Container -->
    <div class="container">
        <div class="auth-container">
            <!-- User Type Selection -->
            <div class="user-type-selection">
                <h2 class="user-type-title">Choose Login Type</h2>
                <div class="user-type-buttons">
                    <button class="user-type-btn active">
                        <a href="login.php" style="text-decoration: none;">User Login</a>
                    </button>
                    <button class="user-type-btn">
                        <a href="admin/admin_login.php" style="text-decoration: none;">Admin Login</a>
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
    <h3 class="form-title" id="loginTitle">User Login</h3>
    
    <div class="form-group">
        <input type="email" class="form-input" placeholder="Email" required id="loginEmail" name="email">
    </div>
    
    <div class="form-group">
        <div class="password-container">
            <input type="password" class="form-input" placeholder="Password" required id="loginPassword" name="password">
            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">👁️</button>
        </div>
    </div>
    
    <button type="submit" class="submit-btn">Sign In</button>
    
    <div class="form-footer">
        <p>Don't have an account? <a href="register.php" class="form-link">Register here</a></p>
        <p><a href="#" class="form-link">Forgot Password?</a></p>
    </div>
</form>

</body>
</html>