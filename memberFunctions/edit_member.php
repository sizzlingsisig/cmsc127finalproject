<?php
include 'DBConnector.php';

$member_query = "SELECT * FROM members"; 
$member_result = $conn->query($member_query);

if ($member_result->num_rows > 0) {
    while($row = $member_result->fetch_assoc()) {
        $subscription_query = "SELECT * 
                                FROM membership m
                                JOIN subscribes s ON m.membership_ID = s.membership_ID
                                WHERE s.member_ID = " . $row["member_ID"] . ";";
        $subscription = $conn->query($subscription_query)->fetch_assoc(); // diri na ga problema if ang isa ka member may multiple subscriptions, karon lng ni kayohon ah pota na

        //var_dump($subscription);


        if ($_POST["MemberID"] == $row['member_ID'] && isset($_POST['action']) && $_POST['action'] == 'edit') {
            echo "
            <form action='update_member.php' method='post'>
                <tr>
                    <td><input type='text' name='MemberName' value='{$row['member_name']}'></td>
                    <td>
                        <select name='MemberPlan'>";
                            echo "<option value='{$subscription['membership_ID']}' selected>{$subscription['membership_type']}</option>";

                            include 'allPlans.php';

                        echo "</select>
                    </td>
                    <td>{$subscription['start_date']}</td>
                    <td>{$subscription['end_date']}</td>
                    <script>console.log('membership_STATUS: " . $row['membership_status'] . "');</script>
                    <td class='status Active'>" . $row["membership_status"] . "</td>
                    <td><input type='text' name='Contact_Info' value='{$row['contact_info']}'></td>
                    <td>
                        <input type='hidden' name='MemberID' value='{$_POST["MemberID"]}'>
                        <button class='action-btn save' title='Save' type='submit' name='Update' value='update'>
                            <i class='fas fa-save'></i>
                        </button>

                        <button class='action-btn cancel' title='Cancel' type='submit' name='Update' value='cancel'>
                            <i class='fas fa-times'></i>
                        </button>
                    </td>
                </tr>
            </form>
            ";
        } else if ($_POST["MemberID"] == $row['member_ID'] && isset($_POST['action']) && $_POST['action'] == 'renew' && $row['membership_status'] === 'cancelled') {
            echo "
            <form action='update_member.php' method='post'>
                <tr>
                    <td><input type='text' name='MemberName' value='{$row['member_name']}'></td>
                    <td>
                        <select name='MemberPlan'>";
                            echo "<option value='{$subscription['membership_ID']}' selected>{$subscription['membership_type']}</option>";

                            include 'allPlans.php';

                        echo "</select>
                    </td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <script>console.log('membership_STATUS: " . $row['membership_status'] . "');</script>
                    <td class='status Active'>" . $row["membership_status"] . "</td>
                    <td><input type='text' name='Contact_Info' value='{$row['contact_info']}'></td>
                    <td>
                        <input type='hidden' name='MemberID' value='{$_POST["MemberID"]}'>
                        <button class='action-btn save' title='Save' type='submit' name='Update' value='renew'>
                            <i class='fas fa-save'></i>
                        </button>

                        <button class='action-btn cancel' title='Cancel' type='submit' name='Update' value='cancel'>
                            <i class='fas fa-times'></i>
                        </button>
                    </td>
                </tr>
            </form>
            ";
        }else if ($row['membership_status'] != 'cancelled') {
            echo"
                <tr>                            
                <td>" . $row["member_name"] . "</td>    
                <td>" . $subscription["membership_type"] . "</td>
                <td>" . $subscription["start_date"] . "</td>
                <td>" . $subscription["end_date"] . "</td>
                <script>console.log('membership_STAT: " . $row['membership_status'] . "');</script>
                <td class='status Active'>" . $row["membership_status"] . "</td>
                <td>" . $row["contact_info"] . "</td>
                <td>" .
                    "<form action='delete_subscription.php' method='post' onsubmit=\"return confirm('Are you sure you want to cancel subscription for this member?')\">".
                        "<input type='text' style='display:none;' name='subscription_ID' value='".$subscription["subscription_ID"]."'>".
                        "<input type='text' style='display:none;' name='action' value='delete'>".
                        "<button type='submit' class='action-btn delete' title='Cancel Subscription'>
                            <i class='fas fa-cancel'></i>
                        </button>".
                    "</form>".
                    "<form action='Members.php' method='post'>".
                        "<input type='text' style='display:none;' name='MemberID' value='".$row["member_ID"]."'>".
                        "<input type='text' style='display:none;' name='action' value='edit'>".
                        "<button class='action-btn edit' title='Edit'>
                        <i class='fas fa-pen'></i>
                        </button>".
                    "</form>".
                "
                </td>
                </tr>
                ";
        }

    }

} else {
    echo "0 results";
}

?>