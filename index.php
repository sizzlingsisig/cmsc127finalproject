<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="./styles.css" />
  <title>Dashboard</title>
</head>
<body>

<div class="sidebar regular">
  <img src="./images/logo.png" alt="Company Logo" class="logo" />
  <a class="active regular" href="index.php"><i class="fas fa-home icon"></i> Dashboard</a>
  <a href="memberFunctions/Members.php"><i class="fas fa-users icon"></i> Members</a>
  <a href="staff.php"><i class="fas fa-user-tie icon"></i> Staff</a>
  <a href="analytics.php"><i class="fas fa-chart-bar icon"></i> Analytics</a>
</div>

<div class="content">
  <div class="header">
    <h4 class="heading">Dashboard Overview</h4>
    <h5 class="subheading">Welcome back, Admin</h5>

    <?php
    $conn = new mysqli("localhost", "root", "", "gym");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $totalMembers = $conn->query("SELECT COUNT(*) AS total FROM members where membership_status = 'active'")->fetch_assoc()['total'];
    $checkinsToday = $conn->query("SELECT COUNT(*) AS today FROM attendance WHERE attendance_date = CURDATE()")->fetch_assoc()['today'];
    $revenue = $conn->query("SELECT SUM(amount) AS revenue FROM payment WHERE payment_date BETWEEN CURDATE() - INTERVAL DAYOFMONTH(CURDATE())-1 DAY AND LAST_DAY(CURDATE())")->fetch_assoc()['revenue'] ?? 0;
    $activeStaff = $conn->query("SELECT COUNT(*) AS active FROM staff WHERE status = 'active'")->fetch_assoc()['active'];

    $conn->close();
    ?>

    <div class="flexContainerBig subheading">
      <div class="quickcontainer two-column"><div class="text-column"><h5>Total Members</h5><h2 class="heading"><?= $totalMembers ?></h2></div><div class="icon-column"><div class="icon-circle"><i class="fas fa-users"></i></div></div></div>
      <div class="quickcontainer two-column"><div class="text-column"><h5>Today's Check-ins</h5><h2 class="heading"><?= $checkinsToday ?></h2></div><div class="icon-column"><div class="icon-circle"><i class="fas fa-user-check"></i></div></div></div>
      <div class="quickcontainer two-column"><div class="text-column"><h5>Revenue (monthly)</h5><h2 class="heading">₱<?= number_format($revenue, 2) ?></h2></div><div class="icon-column"><div class="icon-circle"><i class="fas fa-money-bill-wave"></i></div></div></div>
      <div class="quickcontainer two-column"><div class="text-column"><h5>Active Staff</h5><h2 class="heading"><?= $activeStaff ?></h2></div><div class="icon-column"><div class="icon-circle"><i class="fas fa-user-tie"></i></div></div></div>
    </div>

    <div class="flexContainerBig">
      <!-- Recent Members -->
      <div class="quickcontainer recent-members">
        <div class="header-row" style="display: flex; justify-content: space-between; align-items: center;">
          <h4>Recent Check-ins</h4>
          <div style="position: relative;">
            <button onclick="toggleDropdown(this)" style="background-color: white; color: black; padding: 8px 14px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;">
              + Membership ▾
            </button>
            <div class="dropdown-menu" style="display: none; position: absolute; right: 0; background-color: white; color: black; box-shadow: 0px 2px 6px rgba(0,0,0,0.15); padding: 8px 0; min-width: 140px; border-radius: 5px; z-index: 1000;">
              
              <button onclick="window.location.href='addmember.html'" style="background: none; border: none; padding: 10px 16px; width: 100%; text-align: left; color: black; cursor: pointer;" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='white'">
                Add Member
              </button>

              <button onclick="filterMembers('walk-in')" style="background: none; border: none; padding: 10px 16px; width: 100%; text-align: left; color: black; cursor: pointer;" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='white'">
                Walk-in
              </button>

              <button onclick="filterMembers('weekly')" style="background: none; border: none; padding: 10px 16px; width: 100%; text-align: left; color: black; cursor: pointer;" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='white'">
                Weekly
              </button>

              <button onclick="filterMembers('monthly')" style="background: none; border: none; padding: 10px 16px; width: 100%; text-align: left; color: black; cursor: pointer;" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='white'">
                Monthly
              </button>

              <button onclick="filterMembers('all')" style="background: none; border: none; padding: 10px 16px; width: 100%; text-align: left; color: black; cursor: pointer;" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor='white'">
                Show All
              </button>
            </div>
          </div>

        </div>

        <table class="members-table" role="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Membership</th>
              <th>Status</th>
              <th>Last Check-in</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $conn = new mysqli("localhost", "root", "", "gym");
          if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

         $filter = $_GET['filter'] ?? null;
        $sql = "
          SELECT m.member_name, m.membership_status, mb.membership_type, MAX(a.attendance_date) AS last_checkin
          FROM members m
          LEFT JOIN subscribes s ON m.member_ID = s.member_ID
          LEFT JOIN membership mb ON s.membership_ID = mb.membership_ID
          LEFT JOIN attendance a ON m.member_ID = a.member_ID
        ";

        // Handle filters correctly
        if ($filter === 'weekly' || $filter === 'monthly' || $filter === 'walk-in') {
          $sql .= " WHERE mb.membership_type = '" . $conn->real_escape_string($filter) . "'";
        }

        // Add grouping and ordering
        $sql .= " GROUP BY m.member_ID ORDER BY last_checkin DESC LIMIT 5;";

        $result = $conn->query($sql);


          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $status = ucfirst($row['membership_status']);
              $last = $row['last_checkin'] ?? 'N/A';
              $membership = $row['membership_type'] ?? 'N/A';
              echo "<tr>
                      <td>{$row['member_name']}</td>
                      <td>{$membership}</td>
                      <td class='status {$status}'>{$row['membership_status']}</td>
                      <td>{$last}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No recent members found.</td></tr>";
          }

          $conn->close();
          ?>
          </tbody>
        </table>
      </div>

      <!-- Right Column -->
      <div class="flexColumn">
        <!-- ✅ UPDATED: Check-in Box -->
        <div class="quickcontainer checkin-box">
          <h4>Quick Check-in</h4>
          <div class="checkin-input">
            <input list="members" id="member-search" type="text" placeholder="Search member..." aria-label="Search member" />
            <datalist id="members">
              <?php
              $conn = new mysqli("localhost", "root", "", "gym");
              $res = $conn->query("SELECT member_name FROM members ORDER BY member_name ASC");
              while ($row = $res->fetch_assoc()) {
                echo "<option value=\"" . htmlspecialchars($row['member_name']) . "\">";
              }
              $conn->close();
              ?>
            </datalist>
            <button id="checkin-btn" class="checkin-button">Check-in Member</button>
          </div>
        </div>

        <div class="quickcontainer staff-schedule">
          <h4>Top Active Members (month)</h4>
          <ul class="top-members-list">
            <?php
            $conn = new mysqli("localhost", "root", "", "gym");
            if ($conn->connect_error) {
              echo "<li>Error loading top members.</li>";
            } else {
              $query = "
                SELECT m.member_name, COUNT(a.attendance_ID) AS checkin_count
                FROM attendance a
                JOIN members m ON a.member_ID = m.member_ID
                WHERE MONTH(a.attendance_date) = MONTH(CURDATE()) AND YEAR(a.attendance_date) = YEAR(CURDATE())
                GROUP BY m.member_ID
                ORDER BY checkin_count DESC
                LIMIT 3
              ";

              $result = $conn->query($query);
              if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $name = htmlspecialchars($row['member_name']);
                  $count = $row['checkin_count'];
                  echo "<li><span class='member-name'>{$name}</span><span class='activity-count'>{$count} check-ins</span></li>";
                }
              } else {
                echo "<li><span class='member-name'>No check-ins this month.</span></li>";
              }

              $conn->close();
            }
            ?>
          </ul>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="checkin.js"></script>
<script src="filtermembers.js"></script>
</body>
</html>
