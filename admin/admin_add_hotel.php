<?php
session_start();
require_once "../includes/config.php";

// Check admin login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];

    // Image upload handling
    $target_dir = "../images/hotels/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . "." . $imageFileType;

    // Basic image validation
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        $error = "File is not an image.";
    } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {  // Max 5MB
        $error = "Sorry, your file is too large.";
    } elseif(!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if (!isset($error)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert hotel into database
            $stmt = $conn->prepare("INSERT INTO hotels (name, location, price, rating, description, image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdiss", $name, $location, $price, $rating, $description, basename($target_file));
            if ($stmt->execute()) {
                $success = "Hotel added successfully!";
            } else {
                $error = "Database error: Could not add hotel.";
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<h2>Add New Hotel</h2>
<a href="admin_dashboard.php">Back to Dashboard</a>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Hotel Name" required><br>
    <input type="text" name="location" placeholder="Location" required><br>
    <input type="number" step="0.01" name="price" placeholder="Price per night" required><br>
    <input type="number" step="0.1" min="0" max="5" name="rating" placeholder="Rating (0 to 5)" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="file" name="image" accept="image/*" required><br>
    <button type="submit">Add Hotel</button>
</form>
