<?php
// Ensure your PHP code to fetch stats is correct and included here as per your previous code.

// Include the DB connection and fetch stats file
include 'DBConnector.php';
include 'fetch_stats.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" type="text/css" href="./styles.css" />
  <title>Analytics</title>
</head>
<body>

  <div class="sidebar regular">
    <img src="./images/logo.png" alt="Company Logo" class="logo" />

    <!-- Your Sidebar Links -->
    <a href="index.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M8 0L0 6h2v10h4V10h4v6h4V6h2L8 0z" />
      </svg>
      Dashboard
    </a>

    <a href="Members.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z" />
        <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
      </svg>
      Members
    </a>

    <a href="staff.html">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M6 2a2 2 0 0 1 4 0v1H6V2zM4 5V4a4 4 0 1 1 8 0v1h1a1 1 0 0 1 1 1v3H2V6a1 1 0 0 1 1-1h1z" />
        <path d="M2 9h12v5H2V9z" />
      </svg>
      Staff
    </a>

    <a class="active" href="Analytics.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M0 0h1v15h15v1H0V0z" />
        <path d="M2 13h2v-5H2v5zm3 0h2V6H5v7zm3 0h2V3H8v10zm3 0h2V9h-2v4z" />
      </svg>
      Analytics
    </a>
  </div>

  <div class="content">
    <div class="header">
      <h4 class="heading">Analytics Dashboard</h4>
      <h5 class="subheading">Key performance indicators for this month</h5>

      <!-- Stats Section -->
      <div class="flexContainerBig subheading">
        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>Total Members</h5>
            <h2 class="heading"><?php echo number_format($totalMembers); ?></h2> <!-- PHP for Total Members -->
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-users"></i>
            </div>
          </div>
        </div>

        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>New This Month</h5>
            <h2 class="heading"><?php echo number_format($newMembersThisMonth); ?></h2> <!-- PHP for New Members -->
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-user-plus"></i>
            </div>
          </div>
        </div>

        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>Attendance Rate</h5>
            <h2 class="heading"><?php echo number_format($attendanceRate, 2); ?>%</h2> <!-- PHP for Attendance Rate -->
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-chart-line"></i>
            </div>
          </div>
        </div>

        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>Monthly Revenue</h5>
            <h2 class="heading">$<?php echo number_format($monthlyRevenue, 2); ?></h2> <!-- PHP for Monthly Revenue -->
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-dollar-sign"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Line Chart for Member Data -->
      <canvas id="membersChart" width="400" height="200"></canvas>
    </div>
  </div>

  <script>
    // Ensure that the DOM is loaded before trying to access the canvas
    document.addEventListener("DOMContentLoaded", function() {
      // Dynamically pass PHP variables to JavaScript for the chart
      const memberData = {
        labels: <?php echo json_encode($monthLabels); ?>, // PHP array converted to JS array
        datasets: [{
          label: 'Number of Members per Month',
          data: <?php echo json_encode($monthlyMemberCounts); ?>, // PHP array converted to JS array
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          fill: true,  // To create an area chart, set to true
          tension: 0.4  // Smoothing the curve of the line
        }]
      };

      // Chart options
      const options = {
        responsive: true,
        scales: {
          x: {
            title: {
              display: true,
              text: 'Months'
            }
          },
          y: {
            title: {
              display: true,
              text: 'Number of Members'
            },
            beginAtZero: true
          }
        }
      };

      // Get the canvas context
      const ctx = document.getElementById('membersChart').getContext('2d');

      // Create the chart
      new Chart(ctx, {
        type: 'line',  // Line chart
        data: memberData,
        options: options
      });
    });
  </script>

  <script src="members.js"></script>
</body>
</html>
