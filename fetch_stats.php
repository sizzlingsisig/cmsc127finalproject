<?php
// Include the DB connection
include './memberFunctions/DBConnector.php';

// Initialize variables to avoid potential undefined errors
$totalMembers = 0;
$newMembersThisMonth = 0;
$attendanceRate = 0;
$monthlyRevenue = 0;
$monthLabels = [];
$monthlyMemberCounts = [];
$monthlyAttendanceCounts = [];
$monthlyRevenueCounts = [];

// Fetching total members
$totalMembersQuery = "SELECT COUNT(*) AS total_members FROM members WHERE membership_status = 'active'";
$totalMembersResult = $conn->query($totalMembersQuery);

if ($totalMembersResult) {
    $totalMembersData = $totalMembersResult->fetch_assoc();
    $totalMembers = $totalMembersData['total_members'];
} else {
    error_log("Error fetching total members: " . $conn->error);
}

// Fetching new members this month (based on payment_date)
$newMembersQuery = "SELECT COUNT(DISTINCT m.member_ID) AS new_members_this_month
                     FROM members m
                     INNER JOIN payment p ON m.member_ID = p.member_ID
                     WHERE m.membership_status = 'active'
                     AND MONTH(p.payment_date) = MONTH(CURRENT_DATE)";
$newMembersResult = $conn->query($newMembersQuery);

if ($newMembersResult) {
    $newMembersData = $newMembersResult->fetch_assoc();
    $newMembersThisMonth = $newMembersData['new_members_this_month'];
} else {
    error_log("Error fetching new members this month: " . $conn->error);
}

// Fetching attendance rate
$attendanceRateQuery = "SELECT (COUNT(DISTINCT member_ID) / (SELECT COUNT(*) FROM members WHERE membership_status = 'active')) * 100 AS attendance_rate
                         FROM attendance
                         WHERE MONTH(attendance_date) = MONTH(CURRENT_DATE)";
$attendanceRateResult = $conn->query($attendanceRateQuery);

if ($attendanceRateResult) {
    $attendanceRateData = $attendanceRateResult->fetch_assoc();
    $attendanceRate = $attendanceRateData['attendance_rate'];
} else {
    error_log("Error fetching attendance rate: " . $conn->error);
}

// Fetching monthly revenue
$monthlyRevenueQuery = "SELECT SUM(amount) AS monthly_revenue FROM payment WHERE MONTH(payment_date) = MONTH(CURRENT_DATE)";
$monthlyRevenueResult = $conn->query($monthlyRevenueQuery);

if ($monthlyRevenueResult) {
    $monthlyRevenueData = $monthlyRevenueResult->fetch_assoc();
    $monthlyRevenue = $monthlyRevenueData['monthly_revenue'];
} else {
    error_log("Error fetching monthly revenue: " . $conn->error);
}

// Fetching monthly member counts for chart (dynamic data)
$monthlyMemberQuery = "SELECT MONTH(p.payment_date) AS month, COUNT(DISTINCT m.member_ID) AS member_count
                       FROM payment p
                       INNER JOIN members m ON p.member_ID = m.member_ID
                       WHERE m.membership_status = 'active'
                       GROUP BY MONTH(p.payment_date)
                       ORDER BY MONTH(p.payment_date)";
$monthlyMemberResult = $conn->query($monthlyMemberQuery);

if ($monthlyMemberResult) {
    while ($row = $monthlyMemberResult->fetch_assoc()) {
        $monthName = date('F', mktime(0, 0, 0, $row['month'], 10));
        $monthLabels[] = $monthName;
        $monthlyMemberCounts[] = (int)$row['member_count'];
    }
} else {
    error_log("Error fetching monthly member counts: " . $conn->error);
}

// Fetching monthly attendance counts
$monthlyAttendanceQuery = "SELECT MONTH(attendance_date) AS month, COUNT(DISTINCT member_ID) AS attendance_count
                          FROM attendance
                          GROUP BY MONTH(attendance_date)
                          ORDER BY MONTH(attendance_date)";
$monthlyAttendanceResult = $conn->query($monthlyAttendanceQuery);

if ($monthlyAttendanceResult) {
    while ($row = $monthlyAttendanceResult->fetch_assoc()) {
        $monthlyAttendanceCounts[] = (int)$row['attendance_count'];
    }
} else {
    error_log("Error fetching monthly attendance counts: " . $conn->error);
}

// Fetching monthly revenue counts
$monthlyRevenueChartQuery = "SELECT MONTH(payment_date) AS month, SUM(amount) AS revenue
                            FROM payment
                            GROUP BY MONTH(payment_date)
                            ORDER BY MONTH(payment_date)";
$monthlyRevenueChartResult = $conn->query($monthlyRevenueChartQuery);

if ($monthlyRevenueChartResult) {
    while ($row = $monthlyRevenueChartResult->fetch_assoc()) {
        $monthlyRevenueCounts[] = (float)$row['revenue'];
    }
} else {
    error_log("Error fetching monthly revenue counts: " . $conn->error);
}
?>