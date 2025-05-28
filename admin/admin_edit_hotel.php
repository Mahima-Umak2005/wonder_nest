<?php
session_start();
require_once "../includes/config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_manage_hotels.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch hotel
$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();

if (!$hotel) {
    echo "Hotel not found!";
    exit();
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    $imageFilename = $hotel['image'];

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/hotels/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid() . "." . $imageFileType;

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $error = "File is not an image.";
        } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
            $error = "File too large. Max 5MB allowed.";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = "Only JPG, JPEG, PNG & GIF files allowed.";
        } else {
            $oldImage = $target_dir . $imageFilename;
            if (file_exists($oldImage)) unlink($oldImage);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $imageFilename = basename($target_file);
            } else {
                $error = "Failed to upload new image.";
            }
        }
    }

    if (empty($error)) {
        $updateStmt = $conn->prepare("UPDATE hotels SET name = ?, location = ?, price = ?, rating = ?, description = ?, image = ? WHERE id = ?");
        $updateStmt->bind_param("ssdissi", $name, $location, $price, $rating, $description, $imageFilename, $id);

        if ($updateStmt->execute()) {
            $success = "Hotel updated successfully!";
            $hotel = array_merge($hotel, [
                'name' => $name,
                'location' => $location,
                'price' => $price,
                'rating' => $rating,
                'description' => $description,
                'image' => $imageFilename
            ]);
        } else {
            $error = "Failed to update hotel.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>WonderNest - Edit Hotel</title>
    <link rel="stylesheet" href="../css/adminDashboard.css" />
    <link rel="stylesheet" href="../css/index.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        
        form {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 100%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }
        
        input, textarea, button {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        
        button {
            background: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 12px 20px;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #2980b9;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            width: 100%;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .msg {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            width: 100%;
            text-align: center;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }
            
            form {
                padding: 20px;
            }
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
    <div class="container">

        <?php if ($error): ?>
            <div class="msg error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="msg success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
        <h2>Edit Hotel</h2>
            <div class="form-group">
                <label>Hotel Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($hotel['name']) ?>">
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" required value="<?= htmlspecialchars($hotel['location']) ?>">
            </div>

            <div class="form-group">
                <label>Price per Night</label>
                <input type="number" step="0.01" name="price" required value="<?= htmlspecialchars($hotel['price']) ?>">
            </div>

            <div class="form-group">
                <label>Rating (0 to 5)</label>
                <input type="number" step="0.1" min="0" max="5" name="rating" required value="<?= htmlspecialchars($hotel['rating']) ?>">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"><?= htmlspecialchars($hotel['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Current Image</label><br>
                <img src="../images/hotels/<?= htmlspecialchars($hotel['image']) ?>" alt="Hotel Image">
            </div>

            <div class="form-group">
                <label>Change Image (optional)</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit">Update Hotel</button>
        </form>
    </div>
</body>
</html>