<?php
include "DBConnector.php";
echo"<script>console.log('inside include berfore: " . $row['membership_status'] . "');</script>";
$plans = $conn->query("SELECT membership_ID, membership_type FROM membership");

if ($plans->num_rows > 0) {
    while ($plan = $plans->fetch_assoc()) {
        // echo gettype($row['membership_ID']);
        // echo "<script>console.log('membership_ID: " . $row['membership_ID'] . "');</script>";
        if ($subscription['membership_ID'] == $plan['membership_ID']) {
            continue;
        }
        echo "<option value='" . $plan['membership_ID'] . "'>" . $plan['membership_type'] . "</option>";
    }
} else {
    echo "<option value=''>No plans available</option>";
}
echo "<script>console.log('inside include after: " . $row['membership_status'] . "');</script>";
?>