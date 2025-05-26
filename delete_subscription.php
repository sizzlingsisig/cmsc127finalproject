<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // change if needed
$password = "";     // change if needed
$dbname = "gym";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get subscription_ID from GET or POST
$subscription_ID = isset($_GET['subscription_ID']) ? (int) $_GET['subscription_ID'] : 0;

if ($subscription_ID > 0) {
    // Step 1: Get member_ID from the subscription
    $stmt = $conn->prepare("SELECT member_ID FROM subscribes WHERE subscription_ID = ?");
    $stmt->bind_param("i", $subscription_ID);
    $stmt->execute();
    $stmt->bind_result($member_ID);
    $stmt->fetch();
    $stmt->close();

    if ($member_ID) {
        // Step 2: Delete the subscription
        $stmt = $conn->prepare("DELETE FROM subscribes WHERE subscription_ID = ?");
        $stmt->bind_param("i", $subscription_ID);
        $deleteSuccess = $stmt->execute();
        $stmt->close();

        if ($deleteSuccess) {
            // Step 3: Update member's status to cancelled
            $stmt = $conn->prepare("UPDATE members SET membership_status = 'cancelled' WHERE member_ID = ?");
            $stmt->bind_param("i", $member_ID);
            if ($stmt->execute()) {
                echo "Subscription deleted and member status updated to 'cancelled'.";
            } else {
                echo "Subscription deleted but failed to update member status: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error deleting subscription.";
        }
    } else {
        echo "Subscription not found.";
    }
} else {
    echo "Invalid subscription ID.";
}

$conn->close();
?>
