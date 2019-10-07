<?php
$user_id = (isset($_REQUEST['userid'])?$_REQUEST['userid']:'0');
$uniqid = (isset($_REQUEST['uniqid'])?$_REQUEST['uniqid']:'0');
$number_of_payment = (isset($_REQUEST['number_of_payment'])?$_REQUEST['number_of_payment']:'1');
$aamembercode = (isset($_REQUEST['aamembercode'])?$_REQUEST['aamembercode']:'');
$aafirstname = (isset($_REQUEST['aafirstname'])?$_REQUEST['aafirstname']:'');
$aamiddlename = (isset($_REQUEST['aamiddlename'])?$_REQUEST['aamiddlename']:'');
$aasurname = (isset($_REQUEST['aasurname'])?$_REQUEST['aasurname']:'');
$aasex = (isset($_REQUEST['aasex'])?$_REQUEST['aasex']:'');
$aacivilstatus = (isset($_REQUEST['aacivilstatus'])?$_REQUEST['aacivilstatus']:'');
$aapurok = (isset($_REQUEST['aapurok'])?$_REQUEST['aapurok']:'');
$aavalidid = (isset($_REQUEST['aavalidid'])?$_REQUEST['aavalidid']:'');
$aabirthdate = (isset($_REQUEST['aabirthdate'])?$_REQUEST['aabirthdate']:'');
$aaage = (isset($_REQUEST['aaage'])?$_REQUEST['aaage']:'');
$aabithplace = (isset($_REQUEST['aabithplace'])?$_REQUEST['aabithplace']:'');
$aaoccupation = (isset($_REQUEST['aaoccupation'])?$_REQUEST['aaoccupation']:'');
$aareligion = (isset($_REQUEST['aareligion'])?$_REQUEST['aareligion']:'');
$aapayorname = (isset($_REQUEST['aapayorname'])?$_REQUEST['aapayorname']:'');
$aapayorage = (isset($_REQUEST['aapayorage'])?$_REQUEST['aapayorage']:'');
$aapayorrelation = (isset($_REQUEST['aapayorrelation'])?$_REQUEST['aapayorrelation']:'');
$aapayorcontactno = (isset($_REQUEST['aapayorcontactno'])?$_REQUEST['aapayorcontactno']:'');
$aapayorpurok = (isset($_REQUEST['aapayorpurok'])?$_REQUEST['aapayorpurok']:'');
$aamembercontactno = (isset($_REQUEST['aamembercontactno'])?$_REQUEST['aamembercontactno']:'');
$aabenename = (isset($_REQUEST['aabenename'])?$_REQUEST['aabenename']:'');
$aabenebirthdate = (isset($_REQUEST['aabenebirthdate'])?$_REQUEST['aabenebirthdate']:'');
$aabeneage = (isset($_REQUEST['aabeneage'])?$_REQUEST['aabeneage']:'');
$aabenerelation = (isset($_REQUEST['aabenerelation'])?$_REQUEST['aabenerelation']:'');
$aabenecivilstatus = (isset($_REQUEST['aabenecivilstatus'])?$_REQUEST['aabenecivilstatus']:'');
$aabenecontactno = (isset($_REQUEST['aabenecontactno'])?$_REQUEST['aabenecontactno']:'');
$aadepname1 = (isset($_REQUEST['aadepname1'])?$_REQUEST['aadepname1']:'');
$aadepbirthdate1 = (isset($_REQUEST['aadepbirthdate1'])?$_REQUEST['aadepbirthdate1']:'');
$aadepage1 = (isset($_REQUEST['aadepage1'])?$_REQUEST['aadepage1']:'');
$aadeprelationship1 = (isset($_REQUEST['aadeprelationship1'])?$_REQUEST['aadeprelationship1']:'');
$aadepcivilstatus1 = (isset($_REQUEST['aadepcivilstatus1'])?$_REQUEST['aadepcivilstatus1']:'');
$aadepname2 = (isset($_REQUEST['aadepname2'])?$_REQUEST['aadepname2']:'');
$aadepbirthdate2 = (isset($_REQUEST['aadepbirthdate2'])?$_REQUEST['aadepbirthdate2']:'');
$aadepage2 = (isset($_REQUEST['aadepage2'])?$_REQUEST['aadepage2']:'');
$aadeprelationship2 = (isset($_REQUEST['aadeprelationship2'])?$_REQUEST['aadeprelationship2']:'');
$aadepcivilstatus2 = (isset($_REQUEST['aadepcivilstatus2'])?$_REQUEST['aadepcivilstatus2']:'');
$aadepname3 = (isset($_REQUEST['aadepname3'])?$_REQUEST['aadepname3']:'');
$aadepbirthdate3 = (isset($_REQUEST['aadepbirthdate3'])?$_REQUEST['aadepbirthdate3']:'');
$aadepage3 = (isset($_REQUEST['aadepage3'])?$_REQUEST['aadepage3']:'');
$aadeprelationship3 = (isset($_REQUEST['aadeprelationship3'])?$_REQUEST['aadeprelationship3']:'');
$aadepcivilstatus3 = (isset($_REQUEST['aadepcivilstatus3'])?$_REQUEST['aadepcivilstatus3']:'');
$aadepname4 = (isset($_REQUEST['aadepname4'])?$_REQUEST['aadepname4']:'');
$aadepbirthdate4 = (isset($_REQUEST['aadepbirthdate4'])?$_REQUEST['aadepbirthdate4']:'');
$aadepage4 = (isset($_REQUEST['aadepage4'])?$_REQUEST['aadepage4']:'');
$aadeprelationship4 = (isset($_REQUEST['aadeprelationship4'])?$_REQUEST['aadeprelationship4']:'');
$aadepcivilstatus4 = (isset($_REQUEST['aadepcivilstatus4'])?$_REQUEST['aadepcivilstatus4']:'');
$aaplantype = (isset($_REQUEST['aaplantype'])?$_REQUEST['aaplantype']:'');
$aaunits = (isset($_REQUEST['aaunits'])?$_REQUEST['aaunits']:'');
$aaagent = (isset($_REQUEST['aaagent'])?$_REQUEST['aaagent']:'');
$aainsurance = (isset($_REQUEST['aainsurance'])?$_REQUEST['aainsurance']:'');
$aamembershipdate = (isset($_REQUEST['aamembershipdate'])?$_REQUEST['aamembershipdate']:'');
$aaao = (isset($_REQUEST['aaao'])?$_REQUEST['aaao']:'');
$aabranchmanager = (isset($_REQUEST['aabranchmanager'])?$_REQUEST['aabranchmanager']:'');
$aaprdate = (isset($_REQUEST['aaordate'])?$_REQUEST['aaordate']:'');
$aaprno = (isset($_REQUEST['aaornumber'])?$_REQUEST['aaornumber']:'');
$aaordate = (isset($_REQUEST['aaordate'])?$_REQUEST['aaordate']:'');
$aaornumber = (isset($_REQUEST['aaornumber'])?$_REQUEST['aaornumber']:'');
$aaamount = (isset($_REQUEST['aaamount'])?$_REQUEST['aaamount']:'');
$aatotalamount = (isset($_REQUEST['aatotalamount'])?$_REQUEST['aatotalamount']:'');

$ps_orno = (isset($_REQUEST['ps_orno'])?$_REQUEST['ps_orno']:'');
$ps_ordate = (isset($_REQUEST['ps_ordate'])?$_REQUEST['ps_ordate']:'');
$ps_amount = (isset($_REQUEST['ps_amount'])?$_REQUEST['ps_amount']:'');

//replace invalid characters
$aafirstname =str_replace("'","`",$aafirstname );
$aamiddlename =str_replace("'","`",$aamiddlename );
$aasurname =str_replace("'","`",$aasurname );
$aapurok =str_replace("'","`",$aapurok );
$aabithplace =str_replace("'","`",$aabithplace );
$aaoccupation =str_replace("'","`",$aaoccupation );
$aareligion =str_replace("'","`",$aareligion );
$aapayorname =str_replace("'","`",$aapayorname );
$aapayorrelation =str_replace("'","`",$aapayorrelation );
$aapayorcontactno =str_replace("'","`",$aapayorcontactno );
$aapayorpurok =str_replace("'","`",$aapayorpurok );
$aamembercontactno =str_replace("'","`",$aamembercontactno );
$aabenename =str_replace("'","`",$aabenename );
$aabenerelation =str_replace("'","`",$aabenerelation );
$aabenecontactno =str_replace("'","`",$aabenecontactno );
$aadepname1 =str_replace("'","`",$aadepname1 );
$aadeprelationship1 =str_replace("'","`",$aadeprelationship1 );
$aadepname2 =str_replace("'","`",$aadepname2 );
$aadeprelationship2 =str_replace("'","`",$aadeprelationship2 );
$aadepcivilstatus2 =str_replace("'","`",$aadepcivilstatus2 );
$aadepname3 =str_replace("'","`",$aadepname3 );
$aadeprelationship3 =str_replace("'","`",$aadeprelationship3 );
$aadepcivilstatus3 =str_replace("'","`",$aadepcivilstatus3 );
$aadepname4 =str_replace("'","`",$aadepname4 );
$aadeprelationship4 =str_replace("'","`",$aadeprelationship4 );



$save_successful = 0;
$sql = "";
include "../dbconnect.php";
//get branch code

$res_branch_code = mysqli_query($con, "SELECT  CONCAT(LEFT(BRANCH_NAME,1),Branch_ID) AS Branch_Code FROM branch_details WHERE branch_id=$aabranchmanager;") or die('ERROR');

$Branch_Code = mysqli_fetch_array($res_branch_code, MYSQLI_ASSOC)['Branch_Code'];

mysqli_free_result($res_branch_code);

//update command here

if ($aamembercode!=''){
	$res = mysqli_query($con, "SELECT COUNT(*) FROM members_profile WHERE Member_Code = '$aamembercode'") or die('ERROR');
	if (mysqli_num_rows($res)>0){

	//update: prifle
		$res_profile = mysqli_query($con, "
			UPDATE members_profile
				SET 
				`Fname`		='$aafirstname',
				`Mname`		='$aamiddlename',
				`Lname`='$aasurname',
				`Nname`='$aamiddlename',
				`Sex`='$aasex',
				`Status`='$aacivilstatus',
				`Address`='$aapurok',
				`IDno`='$aavalidid',
				`Bdate`='$aabirthdate',
				`Age`='$aaage',
				`Bplace`='$aabithplace',
				`Occupation`='$aaoccupation',
				`Religion`='$aareligion',
				`Pname`='$aapayorname',
				`Page`='$aapayorage',
				`Prelation`	='$aapayorrelation',
				`Pcontactno`='$aapayorcontactno',
				`CAddress`	='$aapayorpurok',
				`Mcontactno`='$aamembercontactno',
				`Bname`		='$aabenename',
				`Bbdate`	='$aabenebirthdate',
				`Bage`		='$aabeneage',
				`Brelation`	='$aabenerelation',
				`Bstatus`	='$aabenecivilstatus',
				`Bcontactno`='$aabenecontactno',
				`Dname1`='$aadepname1',
				`Dbdate1`='$aadepbirthdate1',
				`Dage1`='$aadepage1',
				`Drelation1`='$aadeprelationship1',
				`Dstatus1`='$aadepcivilstatus1',
				`Dname2`='$aadepname2',
				`Dbdate2`='$aadepbirthdate2',
				`Dage2`='$aadepage2',
				`Drelation2`='$aadeprelationship2',
				`Dstatus2`='$aadepcivilstatus2',
				`Dname3`='$aadepname3',
				`Dbdate3`='$aadepbirthdate3',
				`Dage3`='$aadepage3',
				`Drelation3`='$aadeprelationship3',
				`Dstatus3`='$aadepcivilstatus3',
				`Dname4`='$aadepname4',
				`Dbdate4`='$aadepbirthdate4',
				`Dage4`='$aadepage4',
				`Drelation4`='$aadeprelationship4',
				`Dstatus4`='$aadepcivilstatus4'
			WHERE Member_Code = '$aamembercode';
		") or die(mysqli_error());


		//updat: account
		$res_account = mysqli_query($con, "
			UPDATE members_account
			SET
				`Plan_id`='$aaplantype',
				`No_of_units`='$aaunits',
				`AgentID`='$aaagent',
				`Insurance_Type`='$aainsurance',
				`Date_of_membership`='$aamembershipdate',
				`PRdate`='$aaordate',
				`PRno`='$aaprno',
				`ORdate`='$aaordate',
				`ORno`='$aaornumber',
				`Amount`='$aaamount',
				`AO`='$aaao',
				`BranchManager`='$aabranchmanager' 
			WHERE `Member_Code`='$aamembercode';
		") or die(mysqli_error());




# start: installment ledger update ---------------------------------------------------------------------------------------------------

	$date_year = date('Y',  strtotime($aamembershipdate));
	$date_month = date('m',  strtotime($aamembershipdate));
	$overDueDate = date('Y-m-d', strtotime("+".(($number_of_payment-1)+1)." months", strtotime("$date_year-$date_month-16")));
	$deactivationDate = date('Y-m-d', strtotime("+".(($number_of_payment-1)+2)." months", strtotime("$date_year-$date_month-16")));
	$overDueDate2 = '';//date('Y-m-d', strtotime("+1 months", strtotime("$date_year-$date_month-15")));
	$deactivationDate2 = '';//date('Y-m-d', strtotime("+2 months", strtotime("$date_year-$date_month-15")));

	//able to update only if the member does't made his/her 2nd payment yet,. 
	$second_payment = $con->query("SELECT COUNT(Member_Code) as 'second_payment' FROM installment_ledger WHERE Member_Code = '$aamembercode' AND Br_Installment_No = 2")->fetch_object()->second_payment;
	if ($second_payment==0) {
		$sql_Installment_ledger_row = "";
		$sql_Installment_ledger_rows= "";
		$Installment_no_pc = "";

		if ($number_of_payment==1){
			$Br_period_covered = date('M y', strtotime($aamembershipdate));			
			$Installment_no_pc = "1";

		}else{
			$Br_period_covered = date('M y', strtotime($aamembershipdate)).'-'.date('M y', strtotime("+".($number_of_payment-1)." month",strtotime($aamembershipdate)));
			$Installment_no_pc = "1-$number_of_payment";
		}

		mysqli_query($con,"DELETE FROM installment_ledger WHERE Member_Code = '$aamembercode' AND Br_installment_no in (0,1);");
		for ($i=0; $i < $number_of_payment ; $i++) { 
			$Installment_No = ($i+1);

			$Period_Covered = date('M', strtotime("+$i month",strtotime($aamembershipdate)));
			$Period_No = date('m', strtotime("+$i month",strtotime($aamembershipdate)));
			$Period_Year = date('Y', strtotime("+$i month",strtotime($aamembershipdate)));
			$overDueDate2 = date('Y-m-d', strtotime("+".($i+1)." months", strtotime("$date_year-$date_month-15")));
			$deactivationDate2 = date('Y-m-d', strtotime("+".($i+2)." months", strtotime("$date_year-$date_month-15")));

			$sql_Installment_ledger_row = "(
			'$Installment_no_pc',
			'$aamembercode',
			'$Installment_No',
			'$Period_Covered',
			'$Period_No',
			'$Period_Year',
			'$aaamount',
			'$aaunits',
			'1',
			'$Br_period_covered',
			'1',
			'$aatotalamount',
			'$aaprdate',
			'$aaprno',
			'$aaordate',
			'$aaornumber',
			'',
			'',
			'$aaprdate',
			'$overDueDate2',
			'$deactivationDate2'
			)";

			$sql_Installment_ledger_rows.="$sql_Installment_ledger_row".($number_of_payment-$i==1?'':',');
		}

		$sql_Installment_ledger_sleeves = "";
		if ($ps_amount > 0) {
			$sql_Installment_ledger_sleeves = "(
				'0',
				'$aamembercode',
				'0',
				'',
				'0',
				'0',
				'$ps_amount',
				'0',
				'1',
				'',
				'',
				'$ps_amount',
				'$ps_ordate',
				'$ps_orno',
				'$ps_ordate',
				'$ps_orno',
				'',
				'',
				now(),
				'$user_id',
				null,
				null

			),";			
		}


		$sql_Installment_ledger = "
			INSERT INTO installment_ledger	(
			`Installment_no_pc`,
			`Member_Code`,
			`Installment_No`,
			`Period_Covered`,
			`Period_No`,
			`Period_Year`,
			`Amt_Due`,
			`Units`,
			`Term`,
			`Br_period_covered`,
			`Br_installment_no`,
			`Br_Amt`,
			`PRdate`,
			`PRno`,
			`ORdate`,
			`ORno`,
			`Remarks`,
			`Insurance_Remarks`,
			`date_encoded`,
			`encoded_by`,
			`DueDate`,
			`DeactivationDate`
			) 
			VALUES $sql_Installment_ledger_sleeves	$sql_Installment_ledger_rows; 
		";

		//echo "SQL: [$sql_Installment_ledger]";
		mysqli_query($con,$sql_Installment_ledger);
	}


# end: installment ledger ---------------------------------------------------------------------------------------------------

    	$activity = "Updated client`s basic information (Member_Code: $aamembercode)";
    	mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity',REGISTRATION',$user_id,NOW())");  	
   		echo "**success**";
	}else{
		echo "**failed**";
	}	
}else{
	//insert command here
	$new_member_code = ''; //<Branch CODE 2><VERSION AS '2'><USER id 2><entry 6> ; E.G. data(branch_code:RO;  version:2; id:2; entry id:1234) = R0+2+01+001234 = R0201001234
	//$Branch_Code = $_COOKIE['branch_ids'];
	$user_id = $_COOKIE['user_id'];
	$version = '02';

	$res_newentryid  = mysqli_query($con, 'SELECT IFNULL(MAX(entry_id),0)+1 AS new_entry FROM members_profile');
	$res_newentryid_row = mysqli_fetch_array($res_newentryid, MYSQLI_ASSOC);
	$new_member_code = $Branch_Code.$version.$user_id.sprintf('%06d', $res_newentryid_row['new_entry']);

	mysqli_free_result($res_newentryid);	

	//default values for new members
	$Installment_No = 1;
	$term=1;
	$Br_Amt=$aatotalamount;
	$Period_Year = 0;//date('Y', strtotime($aamembershipdate));
	$Period_Covered ='';// date('M', strtotime($aamembershipdate));
	$Period_No = 0;//date('m', strtotime($aamembershipdate));
	$Br_period_covered = '';//date('M', strtotime($aamembershipdate));
	$unit=1;
	$Br_installment_no=1;
	$status = 'Active';

	// $uniqid = uniqid();
	//INSERT IGNORE INTO clients

	$sql_members_profile="
		INSERT IGNORE INTO members_profile
		(
		`uid`
		,`Fname`
		,`Mname`
		,`Lname`
		,`Nname`
		,`Sex`
		,`Status`
		,`Address`
		,`IDno`
		,`Bdate`
		,`Age`
		,`Bplace`
		,`Occupation`
		,`Religion`
		,`Pname`
		,`Page`
		,`Prelation`
		,`Pcontactno`
		,`CAddress`
		,`Mcontactno`
		,`Bname`
		,`Bbdate`
		,`Bage`
		,`Brelation`
		,`Bstatus`
		,`Bcontactno`
		,`Dname1`
		,`Dbdate1`
		,`Dage1`
		,`Drelation1`
		,`Dstatus1`
		,`Dname2`
		,`Dbdate2`
		,`Dage2`
		,`Drelation2`
		,`Dstatus2`
		,`Dname3`
		,`Dbdate3`
		,`Dage3`
		,`Drelation3`
		,`Dstatus3`
		,`Dname4`
		,`Dbdate4`
		,`Dage4`
		,`Drelation4`
		,`Dstatus4`
		,`Member_Code`
		) 
		values 
		(
		'$uniqid'
		,'$aafirstname'
		,'$aamiddlename'
		,'$aasurname'
		,'$aamiddlename'
		,'$aasex'
		,'$aacivilstatus'
		,'$aapurok'
		,'$aavalidid'
		,'$aabirthdate'
		,'$aaage'
		,'$aabithplace'
		,'$aaoccupation'
		,'$aareligion'
		,'$aapayorname'
		,'$aapayorage'
		,'$aapayorrelation'
		,'$aapayorcontactno'
		,'$aapayorpurok'		
		,'$aamembercontactno'
		,'$aabenename'
		,'$aabenebirthdate'
		,'$aabeneage'
		,'$aabenerelation'
		,'$aabenecivilstatus'
		,'$aabenecontactno'
		,'$aadepname1'
		,'$aadepbirthdate1'
		,'$aadepage1'
		,'$aadeprelationship1'
		,'$aadepcivilstatus1'
		,'$aadepname2'
		,'$aadepbirthdate2'
		,'$aadepage2'
		,'$aadeprelationship2'
		,'$aadepcivilstatus2'
		,'$aadepname3'
		,'$aadepbirthdate3'
		,'$aadepage3'
		,'$aadeprelationship3'
		,'$aadepcivilstatus3'
		,'$aadepname4'
		,'$aadepbirthdate4'
		,'$aadepage4'
		,'$aadeprelationship4'
		,'$aadepcivilstatus4'
		,'$new_member_code'
		);
	";		

	$date_year = date('Y',  strtotime($aamembershipdate));
	$date_month = date('m',  strtotime($aamembershipdate));
	$overDueDate = date('Y-m-d', strtotime("+".(($number_of_payment-1)+1)." months", strtotime("$date_year-$date_month-16")));
	$deactivationDate = date('Y-m-d', strtotime("+".(($number_of_payment-1)+2)." months", strtotime("$date_year-$date_month-16")));
	$overDueDate2 = '';//date('Y-m-d', strtotime("+1 months", strtotime("$date_year-$date_month-15")));
	$deactivationDate2 = '';//date('Y-m-d', strtotime("+2 months", strtotime("$date_year-$date_month-15")));
	$sql_members_account = "
		INSERT INTO members_account	(
			`Plan_ID`,
			`No_of_units`,
			`AgentID`,
			`Insurance_Type`,
			`Date_of_membership`,
			`Current_term`,
			`Account_Status`,
			`PRdate`,
			`PRno`,
			`ORdate`,
			`ORno`,
			`Amount`,
			`AO`,
			`BranchManager`,
			`Member_Code`,
				`Overduedate`,
				`DeactivationDate`
			) 
		VALUES 	(
			'$aaplantype',
			'$aaunits',
			'$aaagent',
			'$aainsurance',
			'$aamembershipdate',
			'$term',
			'$status',
			'$aaprdate',
			'$aaprno',
			'$aaordate',
			'$aaornumber',
			'$aaamount',
			'$aaao',
			'$aabranchmanager',
			'$new_member_code',
			'$overDueDate',
			'$deactivationDate'
		); 
	";


# start: installment ledger ---------------------------------------------------------------------------------------------------
	$sql_Installment_ledger_row = "";
	$sql_Installment_ledger_rows= "";
	$Installment_no_pc = "";

	if ($number_of_payment==1){
		$Br_period_covered = date('M y', strtotime($aamembershipdate));			
		$Installment_no_pc = "1";

	}else{
		$Br_period_covered = date('M y', strtotime($aamembershipdate)).'-'.date('M y', strtotime("+".($number_of_payment-1)." month",strtotime($aamembershipdate)));
		$Installment_no_pc = "1-$number_of_payment";
	}


	for ($i=0; $i < $number_of_payment ; $i++) { 
		$Installment_No = ($i+1);

		$Period_Covered = date('M', strtotime("+$i month",strtotime($aamembershipdate)));
		$Period_No = date('m', strtotime("+$i month",strtotime($aamembershipdate)));
		$Period_Year = date('Y', strtotime("+$i month",strtotime($aamembershipdate)));
		$overDueDate2 = date('Y-m-d', strtotime("+".($i+1)." months", strtotime("$date_year-$date_month-15")));
		$deactivationDate2 = date('Y-m-d', strtotime("+".($i+2)." months", strtotime("$date_year-$date_month-15")));

		$sql_Installment_ledger_row = "(
		'$Installment_no_pc',
		'$new_member_code',
		'$Installment_No',
		'$Period_Covered',
		'$Period_No',
		'$Period_Year',
		'$aaamount',
		'$unit',
		'$term',
		'$Br_period_covered',
		'$Br_installment_no',
		'$aatotalamount',
		'$aaprdate',
		'$aaprno',
		'$aaordate',
		'$aaornumber',
		'',
		'',
		 current_date(),
		'$user_id',
		'$overDueDate2',
		'$deactivationDate2'
		)";


		$sql_Installment_ledger_rows.="$sql_Installment_ledger_row".($number_of_payment-$i==1?'':',');
	}

	$sql_Installment_ledger_sleeves = "";
	if ($ps_amount > 0) {
		$sql_Installment_ledger_sleeves = "(
			'0',
			'$new_member_code',
			'0',
			'',
			'0',
			'0',
			'$ps_amount',
			'0',
			'1',
			'',
			'',
			'$ps_amount',
			'$ps_ordate',
			'$ps_orno',
			'$ps_ordate',
			'$ps_orno',
			'',
			'',
			current_date(),
			'$user_id',
			null,
			null

		),";			}



	$sql_Installment_ledger = "
		INSERT INTO installment_ledger	(
		`Installment_no_pc`,
		`Member_Code`,
		`Installment_No`,
		`Period_Covered`,
		`Period_No`,
		`Period_Year`,
		`Amt_Due`,
		`Units`,
		`Term`,
		`Br_period_covered`,
		`Br_installment_no`,
		`Br_Amt`,
		`PRdate`,
		`PRno`,
		`ORdate`,
		`ORno`,
		`Remarks`,
		`Insurance_Remarks`,
		`date_encoded`,
		`encoded_by`,
		`DueDate`,
		`DeactivationDate`
		) 
		VALUES 	$sql_Installment_ledger_sleeves $sql_Installment_ledger_rows; 
	";

	//echo "SQL: [$sql_Installment_ledger]";
# end: installment ledger ---------------------------------------------------------------------------------------------------

	
	$save_successful = 0;

	$res_members_profile = mysqli_query($con, $sql_members_profile) or die(mysqli_error());
	if (!$res_members_profile){
		echo "**failed**";
	}else{
		$res_members_account = mysqli_query($con, $sql_members_account) or die(mysqli_error());
		if (!$res_members_account){
			echo "**failed**";
		}else{
			$res_Installment_ledger = mysqli_query($con, $sql_Installment_ledger) or die(mysqli_error());
			if (!$res_Installment_ledger){
				echo "**failed**";
			}else{
				echo "**success**";
				$save_successful=1;
		        $activity = "Register new client (Member_Code: $new_member_code)";
		        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','REGISTRATION',$user_id,NOW())");  
			}
			//mysqli_free_result($res_Installment_ledger);
		}
		//mysqli_free_result($res_members_account);
	}
	//mysqli_free_result($res_members_profile);
		
} //if ($aamembercode!='') else selection


	//SHARE COMPUTATION #1----------------------------------------------------------------------------------------------------------------


include '../dbclose.php';

?>

