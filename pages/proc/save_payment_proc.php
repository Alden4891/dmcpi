<?php
	$arr_amount = $_POST['pay_amount'];
	$arr_month = $_POST['pay_month'];
	$arr_year = $_POST['pay_year'];
	$user_id = (isset($_REQUEST['userid'])?$_REQUEST['userid']:'0');
	$Member_Code = $_POST['member_code'];
	

	$arr_ornumber = $_POST['pay_orno'];
	$arr_ordate = $_POST['pay_ordate'];

	$lpInstallmentNo = $_POST['lpInstallmentNo'];
	$lpbrinstallmentno = $_POST['lpbrinstallmentno'];
	$br_period_covered = "";
	
	// if ($arr_month[0]==$arr_month[count($arr_month)-1]){
	// 	$br_period_covered=$arr_month[0].' '.($arr_year[0]-2000);
	// }else{
	// 	$br_period_covered=$arr_month[0].' '.($arr_year[0]-2000)."-".$arr_month[count($arr_month)-1].' '.($arr_year[count($arr_year)-1]-2000); // JAN 18-MAY 19
	// }
	
	$units = $_POST['units']; 		 // from members account (number of payment per period)
	$term = 0; 			 			// number of years; increament every 12 months starting from 1

	//get total amount ------------------------------------------------------------------------------------------
	$tot_amount = 0 ;
	$next_installment_no = 0;
	$next_br_installment_no = $lpbrinstallmentno+1;

	$csv_orno = "'-5'";
	for ($i=0; $i < count($arr_amount) ; $i++) { 
		$amount = $arr_amount[$i];
		$month = $arr_month[$i];
		$year = $arr_year[$i];
		$tot_amount+=$amount;
		$csv_orno.=",'".$arr_ornumber[$i]."'";
	}

	include '../dbconnect.php';
	
	//get encoding session id ---------------------------------------------------------------------------------
	//note: negative value means late encoding 
	$active_session_id = 0;
	$res_session_id = mysqli_query($con,"SELECT IF (date_end < NOW(),ID*-1,ID) AS session_id FROM tbl_activities WHERE isactive=1;");
	if (mysqli_num_rows($res_session_id) > 0) {
		$row_session = mysqli_fetch_row($res_session_id);
		$active_session_id = $row_session[0];
	}

	//check if OR exists --------------------------------------------------------------------------------------
	$res_or = mysqli_query($con,"SELECT COUNT(*) AS cnt, Member_Code FROM mcpr_ledger  WHERE orno in ($csv_orno) GROUP BY Member_Code;");
	$r=mysqli_fetch_array($res_or,MYSQLI_ASSOC);
    if ($r['cnt'] > 0) {
    	echo "**exists**|".$r['Member_Code'];
    	mysqli_free_result($res_or);
    	include '../dbclose.php';
    	return;
    } 

    //get the installment number ---------------------------------------------------------------------------------
	$res_account = mysqli_query($con,"SELECT date_of_membership FROM members_account WHERE member_code = '$Member_Code';");
	$r=mysqli_fetch_array($res_account,MYSQLI_ASSOC);
	$registration_date = $r['date_of_membership'];
	$date_year = date('Y',  strtotime($registration_date));
	$date_month = date('m',  strtotime($registration_date));

	$first_payment_date = $arr_year[0].'-'.$arr_month[0].'-1';
	$diff = ((date('Y', strtotime($first_payment_date)) - date('Y', strtotime($registration_date))) * 12) + (date('m', strtotime($first_payment_date)) - date('m', strtotime($registration_date)));
	$lpInstallmentNo = $diff;

	//INSTALLMENT LEDGER -----------------------------------------------------------------------------------------------------------
	$installment_ledger_insert = "
	INSERT INTO installment_ledger (`Installment_no_pc`,`Member_Code`,`Installment_No`,`Period_Covered`,`Period_No`,`Period_Year`,`Amt_Due`,`Units`,`Term`,`Br_period_covered`,`Br_installment_no`,`Br_Amt`,`PRdate`,`PRno`,`ORdate`,`ORno`,`date_encoded`,`encoded_by`,`enc_session_id`) VALUES ";
	$installment_ledger_rows = "";
	$term=0;

	$Installment_no_pc = "";
	// if (($lpInstallmentNo+1)==(($lpInstallmentNo)+count($arr_amount))){
	// 	$Installment_no_pc = $lpInstallmentNo+1;
	// }else{
	// 	$Installment_no_pc = ($lpInstallmentNo+1).'-'.(($lpInstallmentNo)+count($arr_amount));
	// }

	$last_orno = "";
	for ($i=0; $i < count($arr_amount) ; $i++) { 
		$amount = $arr_amount[$i];
		$month = $arr_month[$i];
		$year = $arr_year[$i];

		$orno = $arr_ornumber[$i];
		$ordate = $arr_ordate[$i];

		$next_installment_no = $lpInstallmentNo + $i +1;
		$Period_No = date('m', strtotime($month));
		$Period_Covered = "$month";
		$term = ceil($next_installment_no / 12);
		$row = "('$Installment_no_pc','$Member_Code','$next_installment_no','$Period_Covered','$Period_No','$year','$amount','$units','$term','$br_period_covered','$next_br_installment_no','$tot_amount','$ordate','$orno','$ordate','$orno',CURRENT_DATE(),'$user_id','$active_session_id')";
		$installment_ledger_rows .= $row . ($i==count($arr_amount)-1?';':',');
	}
	$Last_InstallmentNo = $next_installment_no;
	$installment_ledger_insert .= $installment_ledger_rows;
	mysqli_query($con, "$installment_ledger_insert");
	$mysql_affected = mysqli_affected_rows($con);

	//UPDATING LEDGER ------------------------------------------------------------

	$arr_ornumber_unique = array_unique($arr_ornumber);

	foreach ($arr_ornumber_unique as $i_ornumber) {
		mysqli_query($con, "call sp_update_installement_ledger_brs($i_ornumber);");
	}



	//

	//UPDATE ACCOUNT----------------------------------------------------------------------------------------

	$overDueDate = date('Y-m-d', strtotime("+$Last_InstallmentNo months", strtotime("$date_year-$date_month-16")));
	$deactivationDate = date('Y-m-d', strtotime("+".($Last_InstallmentNo+1)." months", strtotime("$date_year-$date_month-16")));
	mysqli_query($con, "
		UPDATE	members_account
		SET 
		   Account_Status = 'Active',
		   Current_term='$term',
		   Overduedate='$overDueDate',
		   DeactivationDate='$deactivationDate'
		WHERE Member_Code = '$Member_Code' ;
	");	

	//Update deactivationDate & overDueDate for MCPR
	mysqli_query($con,"
		UPDATE installment_ledger
			SET 
			DueDate = '$overDueDate',
			DeactivationDate = '$deactivationDate'
		WHERE ORno in ($csv_orno)
	");

	mysqli_free_result($res_account);

	//insert audir trail
	if ($mysql_affected>0){

        $activity = "Member_Code: $Member_Code  - Payment encoded with OR# $csv_orno";
        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','PAYMENT',$user_id,NOW())");  

		echo "**success**";
	}else{
		echo "**failed**";
	}
	include '../dbclose.php';

	//$pay_amount = implode(",",$arr_amount);
	



?>