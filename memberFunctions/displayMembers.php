<?php
include 'DBConnector.php';

$member_query = "SELECT * FROM members";
$member_result = $conn->query($member_query);

if ($member_result->num_rows > 0) {
    while($row = $member_result->fetch_assoc()) {
        $subscription_query = "SELECT * 
                                FROM membership m
                                JOIN subscribes s ON m.membership_ID = s.membership_ID
                                WHERE s.member_ID = " . $row["member_ID"] . ";" ;
        $subscription = $conn->query($subscription_query)->fetch_assoc(); // diri na ga problema if ang isa ka member may multiple subscriptions, karon lng ni kayohon ah pota na
        //var_dump($subscription);

        $memType = isset($subscription["membership_type"]) ? $subscription["membership_type"] : "N/A";
        $startDate = isset($subscription["start_date"]) ? $subscription["start_date"] : "N/A";
        $endDate = isset($subscription["end_date"]) ? $subscription["end_date"] : "N/A";
        $subscription_ID = isset($subscription['subscription_ID']) ? (int) $subscription['subscription_ID'] : 0;
echo "
<tr>
  <td>" . $row["member_name"] . "</td>
  <td>" . $memType . "</td>
  <td>" . $startDate . "</td>
  <td>" . $endDate . "</td>
  <td class='status Active'>" . $row["membership_status"] . "</td>
  <td>" . $row["contact_info"] . "</td>
  <td>
    <div class='action-buttons'>
      <form action='delete_subscription.php' method='post' onsubmit=\"return confirm('Are you sure you want to cancel subscription for this member?')\">
        <input type='hidden' name='subscription_ID' value='" . $subscription_ID . "'>
        <input type='hidden' name='action' value='delete'>
        <button type='submit' class='action-btn delete' title='Cancel Subscription'>
          <i class='fas fa-times'></i>
        </button>
      </form>

      <form action='Members.php' method='post'>
        <input type='hidden' name='MemberID' value='" . $row["member_ID"] . "'>
        <input type='hidden' name='action' value='edit'>
        <button type='submit' class='action-btn edit' title='Edit'>
          <i class='fas fa-pen'></i>
        </button>
      </form>
    </div>
  </td>
</tr>
";

    }
} else {
    echo "0 results";
}

?>