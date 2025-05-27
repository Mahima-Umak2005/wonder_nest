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

// Fetch existing hotel data
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

    // Start with current image filename
    $imageFilename = $hotel['image'];

    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/hotels/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . uniqid() . "." . $imageFileType;

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $error = "File is not an image.";
        } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {
            $error = "Sorry, your file is too large.";
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            // Delete old image file
            $oldImage = $target_dir . $imageFilename;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            // Upload new image
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $imageFilename = basename($target_file);
            } else {
                $error = "Error uploading new image.";
            }
        }
    }

    if (empty($error)) {
        $updateStmt = $conn->prepare("UPDATE hotels SET name = ?, location = ?, price = ?, rating = ?, description = ?, image = ? WHERE id = ?");
        $updateStmt->bind_param("ssdissi", $name, $location, $price, $rating, $description, $imageFilename, $id);

        if ($updateStmt->execute()) {
            $success = "Hotel updated successfully!";
            // Refresh hotel data to show updated info
            $hotel['name'] = $name;
            $hotel['location'] = $location;
            $hotel['price'] = $price;
            $hotel['rating'] = $rating;
            $hotel['description'] = $description;
            $hotel['image'] = $imageFilename;
        } else {
            $error = "Database error: Could not update hotel.";
        }
    }
}
?>

<h2>Edit Hotel</h2>
<a href="admin_manage_hotels.php">Back to Manage Hotels</a>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Hotel Name" required value="<?= htmlspecialchars($hotel['name']) ?>"><br>
    <input type="text" name="location" placeholder="Location" required value="<?= htmlspecialchars($hotel['location']) ?>"><br>
    <input type="number" step="0.01" name="price" placeholder="Price per night" required value="<?= $hotel['price'] ?>"><br>
    <input type="number" step="0.1" min="0" max="5" name="rating" placeholder="Rating (0 to 5)" required value="<?= $hotel['rating'] ?>"><br>
    <textarea name="description" placeholder="Description"><?= htmlspecialchars($hotel['description']) ?></textarea><br>

    <p>Current Image:</p>
    <img src="../images/hotels/<?= htmlspecialchars($hotel['image']) ?>" width="150" alt="Hotel Image"><br><br>

    <label>Change Image (optional):</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">Update Hotel</button>
</form>
