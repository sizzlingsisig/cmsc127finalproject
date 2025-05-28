<?php
// Include the fetch stats file
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
  <style>
    .chart-buttons {
      display: flex;
      gap: 15px;
      margin: 20px 0;
      justify-content: center;
      flex-wrap: wrap;
    }
    
    .chart-btn {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      background: #e2e8f0;
      color: #64748b;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .chart-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      background: #cbd5e1;
      color: #475569;
    }
    
    .chart-btn.active {
      background: #0891b2;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 16px rgba(8, 145, 178, 0.3);
    }
    
    .chart-btn.active:hover {
      background: #0e7490;
    }
    
    .chart-container {
      margin: 30px 0;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      height: 500px; /* Fixed height for consistency */
    }
    
    #analyticsChart {
      max-width: 100%;
      height: 400px !important; /* Set specific height */
    }
    
    .chart-title {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      font-size: 24px;
      font-weight: 600;
    }
  </style>
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
            <h2 class="heading"><?php echo number_format($totalMembers); ?></h2>
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
            <h2 class="heading"><?php echo number_format($newMembersThisMonth); ?></h2>
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
            <h2 class="heading"><?php echo number_format($attendanceRate, 2); ?>%</h2>
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
            <h2 class="heading">$<?php echo number_format($monthlyRevenue, 2); ?></h2>
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-dollar-sign"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart Buttons -->
      <div class="chart-buttons">
        <button class="chart-btn active" onclick="showChart('members')" id="membersBtn">
          <i class="fas fa-users"></i>
          Members Chart
        </button>
        <button class="chart-btn" onclick="showChart('attendance')" id="attendanceBtn">
          <i class="fas fa-chart-line"></i>
          Attendance Chart
        </button>
        <button class="chart-btn" onclick="showChart('revenue')" id="revenueBtn">
          <i class="fas fa-dollar-sign"></i>
          Revenue Chart
        </button>
      </div>

      <!-- Chart Container -->
      <div class="chart-container">
        <h3 class="chart-title" id="chartTitle">Members per Month</h3>
        <canvas id="analyticsChart"></canvas>
      </div>
    </div>
  </div>

  <script>
    let currentChart = null;
    let currentChartType = 'members';

    // Chart data from PHP
    const chartData = {
      labels: <?php echo json_encode($monthLabels); ?>,
      members: <?php echo json_encode($monthlyMemberCounts); ?>,
      attendance: <?php echo json_encode($monthlyAttendanceCounts); ?>,
      revenue: <?php echo json_encode($monthlyRevenueCounts); ?>
    };

    // Chart configurations
    const chartConfigs = {
      members: {
        title: 'Members per Month',
        label: 'Number of Members',
        data: chartData.members,
        backgroundColor: [
          '#0891b2', '#06b6d4', '#22d3ee', '#67e8f9', '#a7f3d0', '#86efac'
        ],
        borderColor: '#ffffff',
        yAxisTitle: 'Number of Members'
      },
      attendance: {
        title: 'Attendance per Month',
        label: 'Number of Attendees',
        data: chartData.attendance,
        backgroundColor: [
          '#ef4444', '#f97316', '#f59e0b', '#eab308', '#84cc16', '#22c55e'
        ],
        borderColor: '#ffffff',
        yAxisTitle: 'Number of Attendees'
      },
      revenue: {
        title: 'Revenue per Month',
        label: 'Revenue ($)',
        data: chartData.revenue,
        backgroundColor: [
          '#3b82f6', '#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899'
        ],
        borderColor: '#ffffff',
        yAxisTitle: 'Revenue ($)'
      }
    };

    function showChart(type) {
      // Update active button
      document.querySelectorAll('.chart-btn').forEach(btn => btn.classList.remove('active'));
      document.getElementById(type + 'Btn').classList.add('active');

      // Update chart title
      document.getElementById('chartTitle').textContent = chartConfigs[type].title;

      // Destroy existing chart
      if (currentChart) {
        currentChart.destroy();
      }

      // Create new chart
      const ctx = document.getElementById('analyticsChart').getContext('2d');
      const config = chartConfigs[type];

      currentChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: chartData.labels,
          datasets: [{
            label: config.label,
            data: config.data,
            borderColor: config.borderColor,
            backgroundColor: config.backgroundColor,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#FF5733',
            pointBorderColor: '#0000', 
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // Allow custom sizing
          plugins: {
            legend: {
              display: true,
              position: 'top'
            }
          },
          scales: {
            x: {
              title: {
                display: true,
                text: 'Months',
                font: {
                  size: 14,
                  weight: 'bold'
                }
              },
              grid: {
                color: 'rgba(0, 0, 0, 0.1)'
              }
            },
            y: {
              title: {
                display: true,
                text: config.yAxisTitle,
                font: {
                  size: 14,
                  weight: 'bold'
                }
              },
              beginAtZero: true,
              grid: {
                color: 'rgba(0, 0, 0, 0.1)'
              }
            }
          },
          interaction: {
            intersect: false,
            mode: 'index'
          }
        }
      });

      currentChartType = type;
    }

    // Initialize the page
    document.addEventListener("DOMContentLoaded", function() {
      // Show default chart (members)
      showChart('members');
    });
  </script>

</body>
</html>