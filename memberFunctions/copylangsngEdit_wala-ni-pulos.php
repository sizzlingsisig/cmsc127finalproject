        <?php
        if ($_POST["MemberID"] == $row['member_ID']) {
            echo"
            <tr>
              <td><input type='text' name='Name' value='{$row['member_name']}'></td>
              <td>
                <select name='Plan'>
                    <option value='" . $subscription['membership_ID'] . "' selected >" . $subscription['membership_type'] . "</option>
                    <?php
                        include 'allPlans.php';
                    ?>  
              </td>
              <td>" . $subscription["start_date"] . "</td>
              <td>" . $subscription["end_date"] . "</td>
              <td class='status Active'>" . $row["membership_status"] . "</td>
              <td><input type='text' name='Contact_Info' value='{$row['contact_info']}'></td>
              <td>
               <form action='update_member.php' method='post'>".
                    "<input type='text' style='display:none;' name='MemberID' value='".$row["member_ID"]."'>".
                    "<input type='text' style='display:none;' name='MembershipID' value=''>".
                    "<input type='text' style='display:none;' name='MemberPlan' value=''>".
                    "<input type='text' style='display:none;' name='MemberContactInfo' value=''>".
                    "<input type='text' style='display:none;' name='Update' value='update'>".
                    "<button class='action-btn save' title='Save'>
                        <i class='fas fa-save'></i>
                    </button>".
                "</form>
              </td>
            </tr>
            ";
        }
        ?>