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

    <a class="active regular" href="index.html">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M8 0L0 6h2v10h4V10h4v6h4V6h2L8 0z" />
      </svg>
      Dashboard
    </a>

    <a href="members.html">
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

    <a href="analytics.html">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M0 0h1v15h15v1H0V0z" />
        <path d="M2 13h2v-5H2v5zm3 0h2V6H5v7zm3 0h2V3H8v10zm3 0h2V9h-2v4z" />
      </svg>
      Analytics
    </a>
  </div>

  <div class="content">
    <div class="header">
      <h4 class="heading">Dashboard Overview</h4>
      <h5 class="subheading">Welcome back, Admin</h5>

     <div class="flexContainerBig subheading">
  <div class="quickcontainer two-column">
    <div class="text-column">
      <h5>Total Members</h5>
      <h2 class="heading">1,234</h2>
    </div>
    <div class="icon-column">
      <div class="icon-circle">
        <i class="fas fa-users"></i>
      </div>
    </div>
  </div>

  <div class="quickcontainer two-column">
    <div class="text-column">
      <h5>Today's Check-ins</h5>
      <h2 class="heading">25</h2>
    </div>
    <div class="icon-column">
      <div class="icon-circle">
        <i class="fas fa-user-check"></i>
      </div>
    </div>
  </div>

  <div class="quickcontainer two-column">
    <div class="text-column">
      <h5>Revenue (monthly)</h5>
      <h2 class="heading">24,500</h2>
    </div>
    <div class="icon-column">
      <div class="icon-circle">
        <i class="fas fa-money-bill-wave"></i>
      </div>
    </div>
  </div>

  <div class="quickcontainer two-column">
    <div class="text-column">
      <h5>Active Staff</h5>
      <h2 class="heading">25</h2>
    </div>
    <div class="icon-column">
      <div class="icon-circle">
        <i class="fas fa-user-tie"></i>
      </div>
    </div>
  </div>
</div>


      <div class="flexContainerBig">
        <!-- Recent Members Card -->
        <div class="quickcontainer recent-members">
          <div class="header-row">
            <h4>Recent Members</h4>
            <button id="add-member-btn" class="add-member-btn">+ Add Member</button>
          </div>
          <table class="members-table" role="table" aria-label="Recent Members">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Membership</th>
                <th scope="col">Status</th>
                <th scope="col">Last Check-in</th>
              </tr>
            </thead>
            <tbody>
              <!-- Replace with php -->
            <?php
                include 'Members.php';
            ?>
              <tr>
                <td>Anthony Davis</td>
                <td>Standard</td>
                <td class="status Active">Active</td>
                <td>2025-05-20</td>
              </tr>
              <tr>
                <td>Austin Reaves</td>
                <td>Trial</td>
                <td class="status Inactive">Inactive</td>
                <td>2025-05-15</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flexColumn">
          <!-- Quick Check-in Card -->
          <div class="quickcontainer checkin-box">
            <h4>Quick Check-in</h4>
            <div class="checkin-input">
              <input id="member-search" type="text" placeholder="Search member..." aria-label="Search member" />
              <button id="checkin-btn" class="checkin-button">Check-in Member</button>
            </div>
          </div>

          <!-- Today's Staff Schedule Card -->
          <div class="quickcontainer staff-schedule">
            <h4>Top Active Members (month)</h4>
            <ul class="top-members-list">
              <li>
                <span class="member-name">LeBron James</span>
                <span class="activity-count">32 check-ins</span>
              </li>
              <li>
                <span class="member-name">Anthony Davis</span>
                <span class="activity-count">28 check-ins</span>
              </li>
              <li>
                <span class="member-name">Austin Reaves</span>
                <span class="activity-count">24 check-ins</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>