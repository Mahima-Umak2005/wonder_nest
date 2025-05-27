<?php require_once "includes/config.php"; ?>

<h2>Available Hotels</h2>

<form method="get">
  <input type="text" name="search" placeholder="Search by location or name">
  <button type="submit">Search</button>
</form>

<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM hotels WHERE name LIKE '%$search%' OR location LIKE '%$search%'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()):
?>

<div style="border:1px solid #ccc; margin-bottom:10px; padding:10px;">
  <img src="images/<?= $row['image'] ?>" style="width:150px;">
  <h3><?= $row['name'] ?></h3>
  <p><?= $row['location'] ?></p>
  <p>₹<?= $row['price'] ?>/night | ⭐ <?= $row['rating'] ?></p>
  <a href="hotel_details.php?id=<?= $row['id'] ?>">View Details</a>
</div>

<?php endwhile; ?>
