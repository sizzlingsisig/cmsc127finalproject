<?php
include 'DBConnector.php';
var_dump($_POST['MemberID']);

$MemberID = $_POST['MemberID'];

$delete_query = "DELETE FROM subscribes WHERE member_ID='$MemberID'"; //not sure if magana kay naka string ang $MemberID
if ($conn->query($delete_query) === TRUE) {
    $delete_member_query = "DELETE FROM members WHERE member_ID='$MemberID'";
    if ($conn->query($delete_member_query) === TRUE) {
        echo "<script>alert('Member deleted successfully!');</script>";
        echo "delete php";
        header("Location: Members.php");
    } else {
        echo "<script>alert('Error deleting member: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>alert('Error deleting subscription: " . $conn->error . "');</script>";
}

?>