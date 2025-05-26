<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="./styles.css" />
  <style>
    .page-btn.disabled {
      color: #aaa;
      cursor: not-allowed;
      pointer-events: none;
    }
    .pagination {
      margin-top: 20px;
      text-align: center;
    }
    .page-btn {
      display: inline-block;
      padding: 8px 16px;
      margin: 0 5px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
    }
    .page-btn:hover:not(.disabled) {
      background-color: #0056b3;
    }

    .add-button {
      margin-top: 10px;
      display: inline-block;
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
    .add-button:hover {
      background-color: #218838;
    }
  </style>
  <title>Staff</title>
</head>
<body>

<div class="sidebar regular">
  <img src="./images/logo.png" alt="Company Logo" class="logo" />
  <a href="index.php"><i class="fas fa-home icon"></i> Dashboard</a>
  <a href="Members.php"><i class="fas fa-users icon"></i> Members</a>
  <a class="active" href="staff.php"><i class="fas fa-user-tie icon"></i> Staff</a>
  <a href="analytics.html"><i class="fas fa-chart-bar icon"></i> Analytics</a>
</div>

<div class="content">
  <div class="header">
    <h4 class="heading">Staff Overview</h4>
    <h5 class="subheading">Manage your staff team effectively</h5>

    <!-- ✅ Add Staff Button -->
    <a href="addstaff.php" class="add-button">
      <i class="fas fa-user-plus"></i> Add Staff
    </a>

    <?php
    $conn = new mysqli("localhost", "root", "", "gym");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Counts
    $totalStaffQuery = "SELECT COUNT(*) AS total FROM staff";
    $activeStaffQuery = "SELECT COUNT(*) AS active FROM staff WHERE status = 'active'";
    $onLeaveQuery = "SELECT COUNT(*) AS on_leave FROM staff WHERE status = 'on-leave'";
    $newHiresQuery = "SELECT COUNT(*) AS new_hires FROM staff WHERE hire_date >= CURDATE() - INTERVAL 30 DAY";

    $totalStaff = $activeStaff = $onLeave = $newHires = 0;

    if ($res = $conn->query($totalStaffQuery)) $totalStaff = $res->fetch_assoc()['total'];
    if ($res = $conn->query($activeStaffQuery)) $activeStaff = $res->fetch_assoc()['active'];
    if ($res = $conn->query($onLeaveQuery)) $onLeave = $res->fetch_assoc()['on_leave'];
    if ($res = $conn->query($newHiresQuery)) $newHires = $res->fetch_assoc()['new_hires'];
    ?>

    <div class="flexContainerBig subheading">
      <div class="quickcontainer two-column">
        <div class="text-column"><h5>Total Staff</h5><h2 class="heading"><?= $totalStaff ?></h2></div>
        <div class="icon-column"><div class="icon-circle"><i class="fas fa-user-tie"></i></div></div>
      </div>
      <div class="quickcontainer two-column">
        <div class="text-column"><h5>Active Staff</h5><h2 class="heading"><?= $activeStaff ?></h2></div>
        <div class="icon-column"><div class="icon-circle"><i class="fas fa-user-check"></i></div></div>
      </div>
      <div class="quickcontainer two-column">
        <div class="text-column"><h5>On Leave</h5><h2 class="heading"><?= $onLeave ?></h2></div>
        <div class="icon-column"><div class="icon-circle"><i class="fas fa-user-clock"></i></div></div>
      </div>
      <div class="quickcontainer two-column">
        <div class="text-column"><h5>New Hires</h5><h2 class="heading"><?= $newHires ?></h2></div>
        <div class="icon-column"><div class="icon-circle"><i class="fas fa-user-plus"></i></div></div>
      </div>
    </div>

    <!-- Staff Table -->
    <table class="members-table">
      <thead>
        <tr>
          <th><button class="sort-btn" data-column="0">Name</button></th>
          <th><button class="sort-btn" data-column="1">Position</button></th>
          <th><button class="sort-btn" data-column="2">Hire Date</button></th>
          <th><button class="sort-btn" data-column="3">Status</button></th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="staff-list">
        <?php
        // Pagination logic
        $limit = 10;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $result = $conn->query("SELECT * FROM staff ORDER BY hire_date DESC LIMIT $limit OFFSET $offset");

        $totalResult = $conn->query("SELECT COUNT(*) AS total FROM staff");
        $totalRows = $totalResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRows / $limit);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $staffName = htmlspecialchars($row['staff_name']);
            $role = htmlspecialchars($row['role']);
            $hireDate = date("M j, Y", strtotime($row['hire_date']));
            $status = htmlspecialchars($row['status']);

            echo "<tr>
              <td>{$staffName}</td>
              <td>{$role}</td>
              <td>{$hireDate}</td>
              <td class='status {$status}'>{$status}</td>
              <td>
                <a href='editstaff.php?id={$row['staff_ID']}' class='action-btn edit' title='Edit'><i class='fas fa-pen'></i></a>
                <button class='action-btn delete' onclick='confirmDelete({$row['staff_ID']}, \"{$staffName}\")' title='Delete'><i class='fas fa-trash'></i></button>
              </td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No staff found.</td></tr>";
        }

        $conn->close();
        ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a class="page-btn" href="?page=<?= $page - 1 ?>">&laquo; Previous</a>
      <?php else: ?>
        <span class="page-btn disabled">&laquo; Previous</span>
      <?php endif; ?>

      <span id="page-number">Page <?= $page ?> of <?= $totalPages ?></span>

      <?php if ($page < $totalPages): ?>
        <a class="page-btn" href="?page=<?= $page + 1 ?>">Next &raquo;</a>
      <?php else: ?>
        <span class="page-btn disabled">Next &raquo;</span>
      <?php endif; ?>
    </div>

  </div>
</div>

<script src="members.js"></script>

<script>
function confirmDelete(id, name) {
  if (confirm(`Do you want to delete "${name}" as staff?`)) {
    window.location.href = `deletestaff.php?id=${id}`;
  }
}
</script>

</body>
</html>
