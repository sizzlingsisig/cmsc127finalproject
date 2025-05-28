<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="./styles.css" />
  <title>Members</title>
  <style>
    .action-buttons {
  display: flex;
  gap: 10px;
  justify-content: center; /* Optional: center within the cell */
}

.action-buttons form {
  margin: 0; /* Remove default spacing */
}

  </style>
</head>
<body>

  <div class="sidebar regular">
    <img src="./images/logo.png" alt="Company Logo" class="logo" />

    <a href="../index.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M8 0L0 6h2v10h4V10h4v6h4V6h2L8 0z" />
      </svg>
      Dashboard
    </a>

    <a class="active" href="memberFunctions/Members.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z" />
        <path fill-rule="evenodd" d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
      </svg>
      Members
    </a>

    <a href="../staff.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M6 2a2 2 0 0 1 4 0v1H6V2zM4 5V4a4 4 0 1 1 8 0v1h1a1 1 0 0 1 1 1v3H2V6a1 1 0 0 1 1-1h1z" />
        <path d="M2 9h12v5H2V9z" />
      </svg>
      Staff
    </a>

    <a href="../analytics.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon" viewBox="0 0 16 16">
        <path d="M0 0h1v15h15v1H0V0z" />
        <path d="M2 13h2v-5H2v5zm3 0h2V6H5v7zm3 0h2V3H8v10zm3 0h2V9h-2v4z" />
      </svg>
      Analytics
    </a>
  </div>

  <div class="content">
    <div class="header">
      <h4 class="heading">Members Overview</h4>
      <h5 class="subheading">Welcome back, Admin</h5>

      <!-- Stats Section -->
      <div class="flexContainerBig subheading">
        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>Total Members</h5>
            <?php
                include 'total_members.php';
            ?>
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-users"></i>
            </div>
          </div>
        </div>

        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>Active Members</h5>
            <?php
                include 'active_members.php';
            ?>
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-user-check"></i>
            </div>
          </div>
        </div>

        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>New This Month</h5>
            <?php
                include 'month_new_members.php';
            ?>
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-user-plus"></i>
            </div>
          </div>
        </div>

        <div class="quickcontainer two-column">
          <div class="text-column">
            <h5>Expiring Soon</h5>
            <?php
                include 'expiring.php';
            ?>
          </div>
          <div class="icon-column">
            <div class="icon-circle">
              <i class="fas fa-user-clock"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Members Section -->
    <!-- Members Section -->
<div class="flexContainerBig">
  <div class="quickcontainer recent-members">

    <!-- Row 1: Search and Add Member -->
    <div class="filter-row" style="display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 15px;">
      <input type="text" id="search-members" placeholder="Search members..." class="search-bar" />
      <button id="add-member-btn" class="add-member-btn"><a href = "addmember.html">+ Add Member</a></button>
    </div>

    <!-- Row 2: Table -->
    <table class="members-table">
      <thead>
        <tr>
          <th><button class="sort-btn" data-column="0">Member</button></th>
          <th><button class="sort-btn" data-column="1">Plan</button></th>
          <th><button class="sort-btn" data-column="2">Start Date</button></th>
          <th><button class="sort-btn" data-column="3">End Date</button></th>
          <th><button class="sort-btn" data-column="4">Status</button></th>
          <th><button class="sort-btn" data-column="5">Contact Info</button></th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="members-list">
        <?php 
        if(isset($_POST["MemberID"]) && isset($_POST["action"])) {
            include 'edit_member.php';
        } else {
            include 'displayMembers.php';
        }
        ?>
        <!-- Add more members as needed -->
      </tbody>
    </table>
  </div>
</div>


    </div>
  </div>

  <script src="members.js"></script>
</body>
</html>
