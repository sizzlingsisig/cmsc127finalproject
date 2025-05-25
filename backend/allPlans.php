<?php
include "DBConnector.php";

$plans = $conn->query("SELECT membership_type FROM membership");

if ($plans->num_rows > 0) {
    while ($row = $plans->fetch_assoc()) {
        echo "<option value='" . $row['membership_ID'] . "'>" . $row['membership_type'] . "</option>";
    }
} else {
    echo "<option value=''>No plans available</option>";
}
?>