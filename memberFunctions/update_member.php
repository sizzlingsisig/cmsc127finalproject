<?php
include "DBConnector.php";

if($_POST["Update"] == "update") {
    $member_id = $_POST['MemberID'];
    $name = $_POST['MemberName'];
    $membership_id = $_POST['MemberPlan'];
    $contact_info = $_POST['Contact_Info'];

    // Update the member details in the database
    $update_query = "UPDATE members SET member_name='$name', contact_info='$contact_info' WHERE member_ID='$member_id'";
    $conn->query($update_query);

    // Update the subscription details if necessary
    $update_subscription_query = "UPDATE subscribes SET membership_ID='$membership_id' WHERE member_ID='$member_id'";
    $conn->query($update_subscription_query);

    echo "<script>alert('Member details updated successfully!');</script>";
    header("Location: Members.php");
}else if($_POST["Update"] == "cancel") {
    header("Location: Members.php");
} else {
    echo "<script>alert('Invalid action!');</script>";
    header("Location: Members.php");
}
?>