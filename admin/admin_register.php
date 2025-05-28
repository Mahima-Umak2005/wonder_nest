<?php
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin_users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "Registered successfully. <a href='admin_login.php'>Login</a>";
    } else {
        echo "Error: " . $stmt->error;
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
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/index.css">
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

            <!-- Login Form -->
            <div class="form-container" >
            <form class="form" id="loginForm" method="post">
            <h3 class="form-title" id="loginTitle">Admin Registration</h3>
            <div class="form-group">
                <input type="text" name="name" class="form-input" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-input" placeholder="Email" name="email" required>
            </div>
    
            <div class="form-group">
                <div class="password-container">
                    <input type="password" class="form-input" placeholder="Password" required id="loginPassword" name="password">
                        <button type="button" class="password-toggle">👁️</button>
                </div>
            </div>
    
    <button type="submit" class="submit-btn">Register</button>
    
    <div class="form-footer">
        <p>Login here! <a href="admin_login.php" class="form-link">Login here</a></p>
        <p><a href="#" class="form-link">Forgot Password?</a></p>
    </div>
</form>

</body>
</html>
