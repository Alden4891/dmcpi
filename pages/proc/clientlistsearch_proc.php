<?php

  $delete_disabled = $_COOKIE['client_deletion']==1?'':'disabled';
	$search_criteria = (isset($_REQUEST['search_criteria'])?strtolower($_REQUEST['search_criteria']):'');
	$search_agent = (isset($_REQUEST['search_agent'])?strtolower($_REQUEST['search_agent']):'');
	$search_plan = (isset($_REQUEST['search_plan'])?strtolower($_REQUEST['search_plan']):'');
	include '../dbconnect.php';

  $sql="

                    SELECT
                      `members_account`.`Member_Code`          AS `Member_Code`
                      , CONCAT(`members_profile`.`Lname`,', ',`members_profile`.`Fname`,' ',SUBSTR(IFNULL(`members_profile`.`Mname`,''),1,1)) AS `Fullname`
                      , `agent_profile`.`initials`             AS `Agent`
          , `branch_details`.`Branch_Name`         AS `Branch_Name`
                      , `packages`.`Plan_Code`                 AS `Plan_Code`
                      , `members_account`.`Remarks`            AS `Remarks`
                      , `members_account`.`No_of_units`        AS `No_of_Units`
                      , `members_account`.`Insurance_Type`     AS `Insurance_Type`
                      , `members_account`.`Date_of_membership` AS `Date_of_Membership`
                      , `members_account`.`Account_Status`     AS `Account_Status`
                      , `members_account`.`Current_term`       AS `Current_Term`
                      , `members_profile`.`ENTRY_ID`           AS `ENTRY_ID`
                    FROM `members_account`
                        INNER JOIN `members_profile`
                         ON `members_account`.`Member_Code` = `members_profile`.`Member_Code`
                        LEFT JOIN agent_profile
                         ON `members_account`.AgentID = agent_profile.AgentID
                        LEFT JOIN packages
                         ON members_account.Plan_id = packages.Plan_id
                        LEFT JOIN branch_details
                         ON members_account.BranchManager = branch_details.Branch_ID
                    WHERE (
                        CONCAT(`members_profile`.`Lname`,', ',`members_profile`.`Fname`,', ',SUBSTR(ifnull(`members_profile`.`Mname`,''),1,1)) LIKE '%$search_criteria%' 
                        OR `members_account`.`Member_Code` LIKE '%$search_criteria%'
                        OR `members_account`.`Remarks` LIKE '%$search_criteria%'

                        ) 
                        AND `packages`.`Plan_Code` LIKE '%$search_plan%' 
                        AND `agent_profile`.`initials`  LIKE '%$search_agent%'

                    GROUP BY 
                      `members_account`.`Member_Code`, 
                      `Fullname`,
                      `agent_profile`.`Initials`,
                      `packages`.`Plan_Code`, 
                      `members_account`.`No_of_units`, 
                      `members_account`.`Insurance_Type`, 
                      `members_account`.`Date_of_membership`, 
                      `members_account`.`Account_Status`, 
                      `members_account`.`Current_term`, 
                      `members_profile`.`ENTRY_ID`
                    ORDER BY `members_profile`.`ENTRY_ID` DESC
                    LIMIT 0, 50
  ";

    echo $sql;

	$res = mysqli_query($con, $sql) or die(mysqli_error());
	$row_count = mysqli_num_rows($res);
	if ($row_count==0){
		echo "**failed**";
	}else{
		$table_rows = "";
		while ($r=mysqli_fetch_array($res,MYSQLI_ASSOC)) {

            $Member_Code = $r['Member_Code']; 
            $Fullname = $r['Fullname']; 
            $Branch_Name = $r['Branch_Name'];
            $Agent = $r['Agent']; 
            $Plan_Code = $r['Plan_Code']; 
            //$No_of_Units = $r['No_of_Units']; 
            $Account_Status = $r['Account_Status'];
            $Current_Term = $r['Current_Term'];
            $Date_of_Membership = $r['Date_of_Membership']; 
            $isLacking = ($r['Remarks']=='Lacking'?1:0); 
            $Remarks = $r['Remarks'];
            $row_colorclass = "";                                
            if ($Account_Status == "Overdue"){
                $row_colorclass = "warning";
            }elseif ($Account_Status == "Inactive"){
                $row_colorclass  = "danger";
            }else {
                $row_colorclass = "";
            }

            $payment_button_htm = "";
            if ($isLacking == 1){
                $row_colorclass  = "info";
                $payment_button_htm = "<a 
                        Member_Code=\"$Member_Code\"
                        id=btnViewPaymentDetails
                        path=\"?page=clientpaymentinfo&Member_Code=$Member_Code\" 
                        data-toggle=\"modal\" data-target=\".modal-updater-1\"
                        class=\"btn btn-success btn-circle btn-xs\"><i class=\"fa fa-money\"></i></a>";                                
            }else{
                $payment_button_htm = "<a href=\"?page=clientpaymentinfo&Member_Code=$Member_Code\" 
                        data-toggle=\"tooltip\" data-placement=\"left\" title=\"Open Payment Information\"
                        class=\"btn btn-success btn-circle btn-xs\"><i class=\"fa fa-money\"></i></a>";
            }


			$row_template = "
                                    <tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $Member_Code</td>
                                        <td>$Fullname</td>
                                        <td>$Branch_Name</td>
                                        <td>$Agent</td>
                                        <td>$Plan_Code</td>

                                        <td>

                                            $payment_button_htm
                                            
                                            <a href=\"#\" 
                                            link=\"fpdf/reports/r_policy.php?Member_Code=$Member_Code#view=FitH\" 
                                            target=_blank 
                                            title=\"View policy\"
                                            id=btn_policy_preview
                                            data-toggle=\"modal\" 
                                            data-target=\".preview_modal\"                                           
                                            class=\"btn btn-info btn-circle  btn-xs\"

                                            ><i class=\"glyphicon glyphicon-list-alt\"></i></a>

                                            <a href=\"?page=cliregistrationform&Member_Code=$Member_Code\" 
                                            data-toggle=\"tooltip\" data-placement=\"left\" title=\"Edit beneficiary's Basic Information\"         
                                            class=\"btn btn-warning btn-circle  btn-xs\"><i class=\"glyphicon glyphicon-edit\"></i></a>

                                            <a href=\"#\" 
                                            data-toggle=\"tooltip\" data-placement=\"left\" title=\"Delete Client Information\"
                                            class=\"btn btn-danger  btn-xs btn-circle $delete_disabled\"><i class=\"glyphicon glyphicon-remove\" id=delete_client membercode=$Member_Code></i></a>


                                        </td>
                                        <td>$Account_Status</td>
                                        <td>$Current_Term</td>
                                        <td>$Date_of_Membership</td>
                                        <td>$Remarks</td>

                                </tr>



			";

			$table_rows.=$row_template;

		}



		echo "**success**|$table_rows|$row_count";

		



	}

	mysqli_free_result($res);

    include '../dbclose.php';



?>