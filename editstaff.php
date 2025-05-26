<?php
$conn = new mysqli("localhost", "root", "", "gym");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$staffId = $_GET['id'] ?? null;
$staff = null;

if ($staffId) {
  $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_ID = ?");
  $stmt->bind_param("i", $staffId);
  $stmt->execute();
  $result = $stmt->get_result();
  $staff = $result->fetch_assoc();
  $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['staff_name'];
  $role = $_POST['role'];
  $contact = $_POST['contact_info'];
  $status = $_POST['status'];
  $id = $_POST['staff_ID'];

  $stmt = $conn->prepare("UPDATE staff SET staff_name = ?, role = ?, contact_info = ?, status = ? WHERE staff_ID = ?");
  $stmt->bind_param("ssssi", $name, $role, $contact, $status, $id);
  $stmt->execute();

  header("Location: staff.php");
  exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Staff</title>
  <link rel="stylesheet" href="./styles.css">
</head>
<body>
  <div class="content">
    <h2>Edit Staff Member</h2>
    <?php if ($staff): ?>
    <form method="post" action="editstaff.php">
      <input type="hidden" name="staff_ID" value="<?= $staff['staff_ID'] ?>">
      <label>Name:</label>
      <input type="text" name="staff_name" value="<?= htmlspecialchars($staff['staff_name']) ?>" required><br>

      <label>Role:</label>
      <input type="text" name="role" value="<?= htmlspecialchars($staff['role']) ?>"><br>

      <label>Contact Info:</label>
      <input type="text" name="contact_info" value="<?= htmlspecialchars($staff['contact_info']) ?>"><br>

      <label>Status:</label>
      <select name="status">
        <option value="active" <?= $staff['status'] === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="on-leave" <?= $staff['status'] === 'on-leave' ? 'selected' : '' ?>>On Leave</option>
      </select><br>

      <button type="submit">Save Changes</button>
    </form>
    <?php else: ?>
      <p>Staff member not found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
