<?php
$success = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $position = $_POST['position'];
  $hireDate = $_POST['hire-date'];
  $contact = $_POST['contact'];

  // DB connection
  $conn = new mysqli("localhost", "root", "", "gym");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Insert into staff
  $stmt = $conn->prepare("INSERT INTO staff (staff_name, role, contact_info, hire_date) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $position, $contact, $hireDate);

  if ($stmt->execute()) {
    $success = true;
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Add Staff</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

  <!-- Sidebar -->
  <div class="sidebar regular" style="width: 220px; height: 100vh; background-color: #4a2a05; position: fixed; padding: 20px; box-sizing: border-box; color: white;">
    <img src="./images/logo.png" alt="Company Logo" class="logo" style="width: 100%; margin-bottom: 30px;" />
    <a class="regular" href="index.php" style="display: block; color: white; text-decoration: none; margin: 10px 0;"><i class="fas fa-home"></i> Dashboard</a>
    <a href="Members.php" style="display: block; color: white; text-decoration: none; margin: 10px 0;"><i class="fas fa-users"></i> Members</a>
    <a class="active regular" href="staff.php" style="display: block; color: #1abc9c; font-weight: bold; text-decoration: none; margin: 10px 0;"><i class="fas fa-user-tie"></i> Staff</a>
    <a href="analytics.html" style="display: block; color: white; text-decoration: none; margin: 10px 0;"><i class="fas fa-chart-bar"></i> Analytics</a>
  </div>

  <!-- Main Content -->
  <main class="main-content" style="margin-left: 240px; padding: 40px 20px; background-color: #fff; min-height: 100vh; box-sizing: border-box;">
    <h1 style="margin-bottom: 30px; color: #2c3e50;">Add Staff</h1>

    <?php if ($success): ?>
      <div id="success-alert" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; margin-bottom: 20px;">
        ✅ Staff member added successfully. Redirecting to Staff Overview...
      </div>
      <script>
        setTimeout(() => {
          window.location.href = "staff.php";
        }, 2000);
      </script>
    <?php endif; ?>

    <form class="staff-form" method="POST" action="addstaff.php" style="display: flex; flex-direction: column; max-width: 500px; background-color: #fefefe; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); gap: 15px;">
      <label for="name" style="font-weight: bold;">Name:</label>
      <input type="text" id="name" name="name" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;" />

      <label for="position" style="font-weight: bold;">Position:</label>
      <input type="text" id="position" name="position" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;" />

      <label for="contact" style="font-weight: bold;">Contact Info:</label>
      <input type="text" id="contact" name="contact" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;" />

      <label for="hire-date" style="font-weight: bold;">Hire Date:</label>
      <input type="date" id="hire-date" name="hire-date" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;" />

      <button type="submit" style="padding: 12px; background-color: #1abc9c; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
        Add Staff Member
      </button>
    </form>
  </main>

</body>
</html>
