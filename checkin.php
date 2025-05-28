<?php
$conn = new mysqli("localhost", "root", "", "gym");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$memberName = $_POST['member_name'] ?? '';

if ($memberName) {
  // Get member details, including membership type (optional for message)
  $stmt = $conn->prepare("
    SELECT m.member_ID, m.membership_status, mb.membership_type
    FROM members m
    LEFT JOIN subscribes s ON m.member_ID = s.member_ID
    LEFT JOIN membership mb ON s.membership_ID = mb.membership_ID
    WHERE m.member_name = ?
  ");
  $stmt->bind_param("s", $memberName);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    $memberId = $row['member_ID'];
    $status = strtolower($row['membership_status']);
    $membershipType = strtolower($row['membership_type'] ?? '');

    // Prevent check-in if cancelled
    if ($status === 'cancelled') {
      echo json_encode([
        "status" => "error",
        "message" => "Check-in denied. {$memberName}'s membership is cancelled."
      ]);
    } else {
      // Record attendance
      $stmt = $conn->prepare("INSERT INTO attendance (member_ID, attendance_date, check_in_time) VALUES (?, CURDATE(), CURTIME())");
      $stmt->bind_param("i", $memberId);
      $stmt->execute();

      // Update check-in count
      $conn->query("UPDATE members SET checkin_count = checkin_count + 1 WHERE member_ID = $memberId");

      // Success response
      echo json_encode([
        "status" => "success",
        "message" => "Check-in recorded for $memberName"
      ]);
    }
  } else {
    echo json_encode(["status" => "error", "message" => "Member not found."]);
  }
} else {
  echo json_encode(["status" => "error", "message" => "No member name provided."]);
}

$conn->close();
?>
