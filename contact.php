<?php
require_once "includes/config.php";

// Initialize variables to avoid undefined variable warning
$message_sent = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $message_sent = true;
        } else {
            $error_message = "❌ Failed to send message. Please try again.";
        }
    } else {
        $error_message = "❌ Database error: Unable to prepare statement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderNest - Contact Us</title>
    <link rel="stylesheet" href="css/contact.css">

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
            <a href="contact.php" class="active">Contact Us</a>
            <a href="about.php">About Us</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="contact-container">
            <!-- Contact Form -->
            <div class="contact-form-section">
                <h2 class="form-title">Send us a Message</h2>
                <p class="form-subtitle">Have questions about our luxury hotels? We'd love to hear from you!</p>
                
                <?php if ($message_sent): ?>
                    <div class="message success-message">
                        🎉 Thank you! Your message has been sent successfully. We'll get back to you within 24 hours.
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error_message)): ?>
                    <div class="message error-message">
                        ❌ <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p>Sending your message...</p>
                </div>

                <form class="contact-form" method="POST" action="" id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="name" class="form-input" placeholder="Your Name *" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-input" placeholder="Your Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <input type="tel" name="phone" class="form-input" placeholder="Phone Number (Optional)" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <select name="subject" class="form-select" required>
                                <option value="">Select Subject *</option>
                                <option value="general" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'general') ? 'selected' : ''; ?>>General Inquiry</option>
                                <option value="booking" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'booking') ? 'selected' : ''; ?>>Booking Assistance</option>
                                <option value="complaint" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'complaint') ? 'selected' : ''; ?>>Complaint</option>
                                <option value="feedback" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'feedback') ? 'selected' : ''; ?>>Feedback</option>
                                <option value="partnership" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'partnership') ? 'selected' : ''; ?>>Partnership</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" class="form-textarea" placeholder="Your Message" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-section">
                <h2 class="contact-info-title">Contact Information</h2>
                
                <div class="contact-cards">
                    <div class="contact-card">
                        <div class="contact-card-icon">📍</div>
                        <h3 class="contact-card-title">Visit Our Office</h3>
                        <div class="contact-card-content">
                            123 Luxury Avenue<br>
                            Premium District<br>
                            New York, NY 10001<br>
                            United States
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-icon">📞</div>
                        <h3 class="contact-card-title">Call Us</h3>
                        <div class="contact-card-content">
                            <strong>Main Office:</strong> <a href="tel:+1-555-LUXSTAY">+1 (555) LUXSTAY</a><br>
                            <strong>Reservations:</strong> <a href="tel:+1-555-BOOKING">+1 (555) BOOKING</a><br>
                            <strong>Emergency:</strong> <a href="tel:+1-555-HELP-NOW">+1 (555) HELP-NOW</a>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-icon">📧</div>
                        <h3 class="contact-card-title">Email Us</h3>
                        <div class="contact-card-content">
                            <strong>General:</strong> <a href="mailto:info@luxstay.com">info@luxstay.com</a><br>
                            <strong>Bookings:</strong> <a href="mailto:bookings@luxstay.com">bookings@luxstay.com</a><br>
                            <strong>Support:</strong> <a href="mailto:support@luxstay.com">support@luxstay.com</a>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-card-icon">🕒</div>
                        <h3 class="contact-card-title">Business Hours</h3>
                        <div class="contact-card-content">
                            <strong>Monday - Friday:</strong> 9:00 AM - 8:00 PM<br>
                            <strong>Saturday:</strong> 10:00 AM - 6:00 PM<br>
                            <strong>Sunday:</strong> 11:00 AM - 5:00 PM<br>
                            <em>24/7 Emergency Support Available</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
