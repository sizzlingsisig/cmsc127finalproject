<?php
// add_member.php

$conn = new mysqli("localhost", "root", "", "gym");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$member_name = $_POST['member_name'] ?? '';
$contact_info = $_POST['contact_info'] ?? '';
$membership_type = $_POST['membership_type'] ?? ''; // 'weekly', 'monthly', or 'yearly'
$payment_type = $_POST['payment_type'] ?? 'cash'; // 'cash', 'gcash', 'bdo'

// Basic validation
if (!$member_name || !$contact_info || !$membership_type) {
    die("Missing required fields.");
}

// Start transaction
$conn->begin_transaction();

try {
    // 1. Insert new member
    $stmt = $conn->prepare("INSERT INTO members (member_name, contact_info, membership_status) VALUES (?, ?, 'active')");
    $stmt->bind_param("ss", $member_name, $contact_info);
    $stmt->execute();
    $member_id = $conn->insert_id;
    $stmt->close();

    // 2. Get membership ID and price based on membership_type
    $stmt = $conn->prepare("SELECT membership_ID, price, duration FROM membership WHERE membership_type = ?");
    $stmt->bind_param("s", $membership_type);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Invalid membership type.");
    }
    $membership = $result->fetch_assoc();
    $stmt->close();

    $membership_id = $membership['membership_ID'];
    $price = $membership['price'];
    $duration = $membership['duration'];

  
    // Dates for subscription
    $purchase_date = date('Y-m-d');
    $start_date = $purchase_date;
    $end_date = date('Y-m-d', strtotime("+$duration days"));

    // 3. Insert subscription
    $stmt = $conn->prepare("INSERT INTO subscribes (member_ID, membership_ID, purchase_date, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $member_id, $membership_id, $purchase_date, $start_date, $end_date);
    $stmt->execute();
    $stmt->close();

    // 4. Insert payment
    $staff_id = 1; // adjust as needed
    $stmt = $conn->prepare("INSERT INTO payment (member_ID, staff_ID, membership_ID, amount, payment_date, payment_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidss", $member_id, $staff_id, $membership_id, $price, $purchase_date, $payment_type);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo "Member added successfully with subscription and payment.";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
