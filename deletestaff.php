<?php
if (!isset($_GET['id'])) {
  header("Location: staff.php");
  exit;
}

$conn = new mysqli("localhost", "root", "", "gym");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$staffId = (int) $_GET['id'];

$stmt = $conn->prepare("DELETE FROM staff WHERE staff_ID = ?");
$stmt->bind_param("i", $staffId);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: staff.php");
exit;
