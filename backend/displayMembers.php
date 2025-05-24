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

        // var_dump($subscription);

        $sub_price = $subscription["price"];

        $total_paid = 0;
        $TP_query = "SELECT amount 
                    FROM payment
                    WHERE member_ID = " . $row["member_ID"] . ";" ;
        $payments = $conn->query($TP_query);
        
        while($paid = $payments->fetch_assoc()){
            $total_paid = $total_paid + $paid['amount'];
        }

        // $paid = $conn->query("SELECT SUM(amount) FROM $payments"); //Fatal error: Uncaught Error: Object of class mysqli_result could not be converted to string in C:\xampp\htdocs\127-final-project\members.php:30 Stack trace: #0 C:\xampp\htdocs\127-final-project\index.php(32): include() #1 {main} thrown in C:\xampp\htdocs\127-final-project\members.php on line 29


        $outstanding_balance = $sub_price - $total_paid;

        echo"
        <tr>
          <td>" . $row["member_name"] . "</td>
          <td>" . $subscription["membership_type"] . "</td>
          <td>" . $subscription["start_date"] . "</td>
          <td>" . $subscription["end_date"] . "</td>
          <td class='status Active'>" . $row["membership_status"] . "</td>
          <td>
           <button class='action-btn edit' title='Edit'>
             <i class='fas fa-pen'></i>
           </button>
           <button class='action-btn delete' title='Delete'>
             <i class='fas fa-trash'></i>
           </button>
          </td>
        </tr>
        ";
    }
} else {
    echo "0 results";
}

?>