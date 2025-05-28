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

    $target_dir = "../images/hotels/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
$imageFileType = strtolower($extension);

    $target_file = $target_dir . uniqid() . "." . $imageFileType;

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        $error = "File is not an image.";
    } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
        $error = "Sorry, your file is too large.";
    } elseif(!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }

    if (!isset($error)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO hotels (name, location, price, rating, description, image) VALUES (?, ?, ?, ?, ?, ?)");
            $imageName = basename($target_file);
            $stmt->bind_param("ssddss", $name, $location, $price, $rating, $description, $imageName);

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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>WonderNest - Add Hotel</title>
  <link rel="stylesheet" href="../css/adminDashboard.css">
    <link rel="stylesheet" href="../css/index.css">
  <style>
    .form-container {
      max-width: 700px;
      margin: 120px auto;
      padding: 40px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .form-container h2 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 20px;
      color: var(--dark-red);
    }

    .form-container form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .form-container input,
    .form-container textarea {
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border 0.3s ease;
    }

    .form-container input:focus,
    .form-container textarea:focus {
      border-color: var(--rose);
      outline: none;
    }

    .form-container textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-container button {
      background: var(--burgundy);
      color: white;
      padding: 12px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .form-container button:hover {
      background: var(--dark-red);
    }

    .message {
      text-align: center;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 8px;
      font-weight: bold;
    }

    .message.success {
      background: #d4edda;
      color: #155724;
    }

    .message.error {
      background: #f8d7da;
      color: #721c24;
    }

    .back-link {
      display: inline-block;
      margin-bottom: 15px;
      text-decoration: none;
      color: var(--burgundy);
      font-weight: bold;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
<header class="header">
        <div class="logo-section">
            <div class="logo">W</div>
            <h1 class="title">WonderNest</h1>
        </div>
        
        <div class="auth-buttons">
            <a href="admin_dashboard.php" class="btn btn-login">Dashboard</a>
            <a href="../logout.php" class="btn btn-login">Logout</a>
        </div>
    </header>
  <div class="form-container">
    <h2>Add New Hotel</h2>

    <?php if (isset($error)) echo "<div class='message error'>{$error}</div>"; ?>
    <?php if (isset($success)) echo "<div class='message success'>{$success}</div>"; ?>

    <form method="post" enctype="multipart/form-data">
      <input type="text" name="name" placeholder="Hotel Name" required />
      <input type="text" name="location" placeholder="Location" required />
      <input type="number" step="0.01" name="price" placeholder="Price per night" required />
      <input type="number" step="0.1" min="0" max="5" name="rating" placeholder="Rating (0 to 5)" required />
      <textarea name="description" placeholder="Description"></textarea>
      <input type="file" name="image" accept="image/*" required />
      <button type="submit">Add Hotel</button>
    </form>
  </div>
</body>
</html>
