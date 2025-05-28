<?php
include 'DBConnector.php';

$cd = $conn->query("SELECT CURDATE() as cd")->fetch_assoc();
$current_date = $cd["cd"];
// var_dump($current_date);

$near_expiryDate = $conn->query("SELECT '$current_date' - INTERVAL 7 DAY AS result;")->fetch_assoc();
$week_before = $near_expiryDate["result"];
// var_dump($week_before);

// sala ni gali pro karon namn kapoy na pota ni
$new_members = $conn->query("SELECT COUNT(*) as total FROM subscribes WHERE end_date >= '$week_before';")->fetch_assoc();

echo"<h2 class='heading'>" . $new_members['total'] . "</h2>";
?>