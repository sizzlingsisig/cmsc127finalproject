<?php
include "DBConnector.php";

$new_members = $conn->query("SELECT COUNT(*) as total FROM subscribes WHERE MONTH(start_date) = date('n') AND YEAR(start_date) = date('Y');")->fetch_assoc();
echo"<h2 class='heading'>" . $new_members['total'] . "</h2>";
?>