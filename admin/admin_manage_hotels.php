<?php
session_start();
require_once "../includes/config.php";

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all hotels
$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Hotels</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Optional CSS -->
    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a.button {
            padding: 5px 10px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }
        a.button.delete {
            background: #e74c3c;
        }
    </style>
</head>
<body>

<h2>Manage Hotels</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Hotel Name</th>
        <th>Location</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["name"]) ?></td>
                <td><?= htmlspecialchars($row["location"]) ?></td>
                <td>₹<?= $row["price_per_night"] ?></td>
                <td>
                    <a class="button" href="admin_edit_hotel.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="button delete" href="admin_delete_hotel.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this hotel?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No hotels found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
