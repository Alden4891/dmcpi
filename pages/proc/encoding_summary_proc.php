<?php
    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:'');
    $selectedMonth = (isset($_REQUEST['selectedMonth'])?$_REQUEST['selectedMonth']:'');
    $encoder_id = (isset($_REQUEST['encoder_id'])?$_REQUEST['encoder_id']:'');
	$selectedEncSessionID = (isset($_REQUEST['selectedEncSessionID'])?$_REQUEST['selectedEncSessionID']:'');

    include '../dbconnect.php';
 

 
	$sql = "
		SELECT
		    `users`.`user_id`
		    , `users`.`fullname`
		    , `installment_ledger`.`orno`
		    , `installment_ledger`.`ordate`
		    , SUM(`installment_ledger`.`Amt_Due`) AS `Amount`
		    , `installment_ledger`.`date_encoded`
		    , `branch_details`.`Branch_Name`
		FROM
		    `dmcpi1_dmcsm`.`installment_ledger`
		    INNER JOIN `dmcpi1_dmcsm`.`users` 
		        ON (`installment_ledger`.`encoded_by` = `users`.`user_id`)
		    INNER JOIN `dmcpi1_dmcsm`.`members_account` 
		        ON (`installment_ledger`.`Member_Code` = `members_account`.`Member_Code`)
		    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
		        ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
		WHERE 
			`installment_ledger`.`encoded_by` =$encoder_id and 
			`installment_ledger`.enc_session_id=$selectedEncSessionID
		GROUP BY `users`.`user_id`, `users`.`fullname`, `installment_ledger`.`orno`, `installment_ledger`.`ordate`, `installment_ledger`.`date_encoded`, `branch_details`.`Branch_Name`
		ORDER BY `installment_ledger`.`encoded_by` DESC;
	";

//echo "$sql";

	$res_data=mysqli_query($con,$sql);
	$cnt=0;
	while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
		$fullname = $r['fullname'];
		$orno = $r['orno'];
		$ordate = $r['ordate'];
		$Amount = $r['Amount'];
		$date_encoded = $r['date_encoded'];
		$Branch_Name = $r['Branch_Name'];
		$cnt+=1;
	    echo  "
	        <tr id=sharelistdata>
	            <td class=\"even gradeC\"> $cnt</td>
	            <td>$orno</td>
	            <td>$ordate</td>
	           
	            <td><div class='pull-right'>$Amount</div></td>
	            <td>$date_encoded</td>
	            <td>$Branch_Name</td>

	        </tr>

	    ";

	}


    mysqli_free_result($res_data);
    include '../dbclose.php';


?>

