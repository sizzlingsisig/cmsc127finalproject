<?php
include "DBConnector.php";

$total_members = $conn->query("SELECT COUNT(*) as total FROM members;")->fetch_assoc();
echo"<h2 class='heading'>" . $total_members['total'] . "</h2>";
?>