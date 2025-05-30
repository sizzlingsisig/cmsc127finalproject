<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Member - Darkshine Gym</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 220px;
      height: 100%;
      background-color: #422100;
      color: white;
      padding: 20px;
    }
    .sidebar img {
      width: 100px;
      margin-bottom: 10px;
    }
    .sidebar h2 {
      margin: 0;
      font-size: 18px;
    }
    .nav {
      margin-top: 30px;
    }
    .nav a {
      display: block;
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 8px;
      color: white;
      text-decoration: none;
      transition: background 0.2s;
    }
    .nav a:hover,
    .nav a.active {
      background-color: #5c3d0a;
    }

    /* Header */
    .header {
      margin-left: 220px;
      height: 60px;
      background-color: #fff;
      border-bottom: 1px solid #ddd;
      display: flex;
      align-items: center;
      padding: 0 30px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    /* Main Content */
    .main-content {
      margin-left: 220px;
      padding: 30px;
    }

    /* Form Styles */
    .form-container {
      background-color: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      max-width: 700px;
    }

    label {
      display: block;
      margin-bottom: 6px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    button {
      background-color: #28a745;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div style="text-align: center; margin-bottom: 30px;">
      <img src="./images/logo.png" alt="Darkshine Gym" />
      <h2>DARKSHINE GYM</h2>
    </div>
    <div class="nav">
      <a href="index.html">Dashboard</a>
      <a href="members.html" class="active">Members</a>
      <a href="staff.html">Staff</a>
      <a href="analytics.html">Analytics</a>
    </div>
  </div>

  <!-- Header -->
  <div class="header">
    <h1 style="font-size: 20px; margin: 0;">Add Member</h1>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="form-container">
      <form>
        <!-- Membership Type -->
        <label>Membership Type</label>
        <select required>
          <option disabled selected>Select a membership type</option>
          <option>Walk-in</option>
          <option>Weekly</option>
          <option>Monthly</option>
          <option>Yearly</option>
        </select>

        <!-- Name -->
        <label>Full Name</label>
        <input type="text" placeholder="Enter full name" required />

        <!-- Address -->
        <label>Address</label>
        <input type="text" placeholder="Enter address" required />

        <!-- Contact -->
        <label>Contact Number</label>
        <input type="tel" placeholder="Enter contact number" required />

        <!-- Email -->
        <label>Email Address</label>
        <input type="email" placeholder="Enter email" required />

        <!-- DOB -->
        <label>Date of Birth</label>
        <input type="date" required />

        <!-- Gender -->
        <label>Gender</label>
        <select required>
          <option disabled selected>Select gender</option>
          <option>Male</option>
          <option>Female</option>
          <option>Non-binary</option>
        </select>

        <!-- Submit -->
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

</body>
</html>
