<?php
// Database connection settings
$host = 'localhost';
$db   = 'gym';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$member_name      = isset($_POST['member_name']) ? trim($_POST['member_name']) : '';
$contact_info     = isset($_POST['contact_info']) ? trim($_POST['contact_info']) : '';
$membership_type  = isset($_POST['membership_type']) ? strtolower(trim($_POST['membership_type'])) : '';

// Validate input
if ($member_name === '' || $contact_info === '' || $membership_type === '') {
    die("Missing required fields.");
}

// Step 1: Insert member
$insertMemberSql = "INSERT INTO members (member_name, contact_info) VALUES (?, ?)";
$stmt = $conn->prepare($insertMemberSql);
$stmt->bind_param("ss", $member_name, $contact_info);
if (!$stmt->execute()) {
    die("Error inserting member: " . $stmt->error);
}
$member_id = $stmt->insert_id;
$stmt->close();

// Step 2: Get membership info (or insert default if not exists)
$getMembershipSql = "SELECT membership_ID, price, duration FROM membership WHERE membership_type = ?";
$stmt = $conn->prepare($getMembershipSql);
$stmt->bind_param("s", $membership_type);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Insert default membership
    $default_price = 100.00;
    $default_duration = 1;

    $insertMembershipSql = "INSERT INTO membership (membership_type, price, duration) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertMembershipSql);
    $insertStmt->bind_param("sdi", $membership_type, $default_price, $default_duration);
    if (!$insertStmt->execute()) {
        die("Error inserting new membership type: " . $insertStmt->error);
    }

    $membership_id = $insertStmt->insert_id;
    $price = $default_price;
    $duration = $default_duration;
    $insertStmt->close();
} else {
    $row = $result->fetch_assoc();
    $membership_id = $row['membership_ID'];
    $price = $row['price'];
    $duration = $row['duration'];
}
$stmt->close();

// Step 3: Insert into subscribes table
$start_date = date('Y-m-d');
$end_date = date('Y-m-d', strtotime("+$duration days"));
$purchase_date = $start_date;

$insertSubSql = "INSERT INTO subscribes (member_ID, membership_ID, purchase_date, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertSubSql);
$stmt->bind_param("iisss", $member_id, $membership_id, $purchase_date, $start_date, $end_date);
if (!$stmt->execute()) {
    die("Error inserting subscription: " . $stmt->error);
}
$stmt->close();

// ✅ Step 4: Insert payment record
$staff_id = 1; // Assuming default staff ID for now; adjust as needed
$payment_type = 'cash'; // You may customize this if payment method is selectable

$insertPaymentSql = "INSERT INTO payment (member_ID, staff_ID, membership_ID, amount, payment_date, payment_type)
                     VALUES (?, ?, ?, ?, CURDATE(), ?)";
$stmt = $conn->prepare($insertPaymentSql);
$stmt->bind_param("iiids", $member_id, $staff_id, $membership_id, $price, $payment_type);
if (!$stmt->execute()) {
    die("Error inserting payment: " . $stmt->error);
}
$stmt->close();

$conn->close();

// Redirect back
header("Location: Members.php?added=1");
exit();
?>
