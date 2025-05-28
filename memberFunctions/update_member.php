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
}
else if($_POST["Update"] == "renew") {
    $member_id = $_POST['MemberID'];
    $membership_id = (int) $_POST['MemberPlan'];
    $dateNow = date('Y-m-d');
    $staff_id = 1; // default nlng ah
    $payment_type = 'cash'; // default mn
    $amount = 0.00;
    
    if ($membership_id == 1) {
        $endDate = date('Y-m-d', strtotime($dateNow . ' + 1 month')); // Basic plan
        $amount = 500.00; // Example price
    } else if ($membership_id == 2) {
        $endDate = date('Y-m-d', strtotime($dateNow . ' + 7 days')); // Trial or weekly
        $amount = 200.00; // Example price
    } else {
        echo "<script>alert('Invalid membership plan selected!');</script>";
        header("Location: Members.php");
        exit();
    }

    // Update the member's status to active and renew the subscription
    $update_query = "UPDATE members SET membership_status='active' WHERE member_ID='$member_id'";
    $conn->query($update_query);

    // Insert a new subscription record or update existing one
    $insert_subscription_query = "INSERT INTO subscribes (member_ID, membership_ID, purchase_date, start_date, end_date) VALUES ('$member_id', '$membership_id', '$dateNow', '$dateNow', '$endDate') ON DUPLICATE KEY UPDATE membership_ID='$membership_id'";
    $conn->query($insert_subscription_query);

    // Insert into payment table
    $insert_payment_query = "INSERT INTO payment (member_ID, staff_ID, membership_ID, amount, payment_date, payment_type)
        VALUES ('$member_id', '$staff_id', '$membership_id', '$amount', '$dateNow', '$payment_type')";
    $conn->query($insert_payment_query);

    echo "<script>alert('Subscription renewed successfully!');</script>";
    header("Location: Members.php");
}
else if($_POST["Update"] == "cancel") {
    header("Location: Members.php");
} else {
    echo "<script>alert('Invalid action!');</script>";
    header("Location: Members.php");
}
?>