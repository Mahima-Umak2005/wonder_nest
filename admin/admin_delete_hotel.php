<?php
require_once "../includes/config.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM hotels WHERE id = $id");
}
header("Location: admin_manage_hotels.php");
exit();
?>
