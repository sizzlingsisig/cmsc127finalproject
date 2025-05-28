<?php
include "DBConnector.php";

$active_members = $conn->query("SELECT COUNT(*) as total FROM members WHERE membership_status = 'active';")->fetch_assoc();
echo"<h2 class='heading'>" . $active_members['total'] . "</h2>";


?>