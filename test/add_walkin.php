<?php
// add_walkin.php

$conn = new mysqli("localhost", "username", "password", "gym");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$visitor_name = $_POST['visitor_name'] ?? '';
$contact_info = $_POST['contact_info'] ?? null;
$visit_date = $_POST['visit_date'] ?? date('Y-m-d');
$check_in_time = $_POST['check_in_time'] ?? date('H:i:s');
$payment_type = $_POST['payment_type'] ?? 'cash';

// Basic validation
if (!$visitor_name) {
    die("Visitor name is required.");
}

// Start transaction
$conn->begin_transaction();

try {
    // 1. Insert new walk-in
    $stmt = $conn->prepare("INSERT INTO walk_in (visitor_name, contact_info, visit_date, check_in_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $visitor_name, $contact_info, $visit_date, $check_in_time);
    $stmt->execute();
    $walk_in_id = $conn->insert_id;
    $stmt->close();

    // 2. Insert payment for walk-in
    // Define payment amount for walk-in, e.g. 100.00
    $amount = 100.00;
    $staff_id = 1; // Adjust as needed

    $stmt = $conn->prepare("INSERT INTO payment (walk_in_ID, staff_ID, amount, payment_date, payment_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iidss", $walk_in_id, $staff_id, $amount, $visit_date, $payment_type);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    echo "Walk-in visitor added and payment recorded successfully.";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
