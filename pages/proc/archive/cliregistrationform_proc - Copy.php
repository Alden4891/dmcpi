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
$aabarangay = (isset($_REQUEST['aabarangay'])?$_REQUEST['aabarangay']:'');
$aamunicipality = (isset($_REQUEST['aamunicipality'])?$_REQUEST['aamunicipality']:'');
$aaprovince = (isset($_REQUEST['aaprovince'])?$_REQUEST['aaprovince']:'');
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
$aapayorbarangay = (isset($_REQUEST['aapayorbarangay'])?$_REQUEST['aapayorbarangay']:'');
$aapayormunicipality = (isset($_REQUEST['aapayormunicipality'])?$_REQUEST['aapayormunicipality']:'');
$aapayorprovince = (isset($_REQUEST['aapayorprovince'])?$_REQUEST['aapayorprovince']:'');
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

$sql = "";

include "../dbconnect.php";


//update command here
if ($aamembercode!=''){
	$res = mysqli_query($con, "SELECT COUNT(*) FROM members_profile WHERE Member_Code = '$aamembercode'") or die('ERROR');
	if (mysqli_num_rows($res)>0){
	//update prifle

		$res_profile = mysqli_query($con, "
			UPDATE members_profile
				SET 
				`Fname`		='$aafirstname',
				`Mname`		='$aamiddlename',
				`Lname`='$aasurname',
				`Nname`='$aamiddlename',
				`Sex`='$aasex',
				`Status`='$aacivilstatus',
				`Street`='$aapurok',
				`Barangay`='$aabarangay',
				`City`='$aamunicipality',
				`Province`='$aaprovince',
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
				`Cstreet`	='$aapayorpurok',
				`Cbarangay`	='$aapayorbarangay',
				`Ccity`		='$aapayormunicipality',
				`Cprovince`	='$aapayorprovince',
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
/*
			echo "
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
				";
*/
			
        	$activity = "Updated client`s basic information (Member_Code: $aamembercode)";
        	mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','REGISTRATION',$user_id,NOW())");  	

        	echo "**success**";

		}else{
			echo "**failed**";
		}

	



	
}else{


	//insert command here
	$new_member_code = ''; //<Branch CODE 2><VERSION AS '2'><USER id 2><entry 6> ; E.G. data(branch_code:RO;  version:2; userid:2; entry id:1234) = R0+2+01+001234 = R0201001234
	$Branch_Code = $_COOKIE['Branch_Code'];
	$user_id = $_COOKIE['user_id'];
	$version = '02';

	$res_newentryid  = mysqli_query($con, 'SELECT IFNULL(MAX(entry_id),0)+1 AS new_entry FROM members_profile');
	$res_newentryid_row = mysqli_fetch_array($res_newentryid, MYSQLI_ASSOC);
	$new_member_code = $Branch_Code.$version.$user_id.sprintf('%06d', $res_newentryid_row['new_entry']);

	mysqli_free_result($res_newentryid);	
	//mysqli_free_result($res_newentryid_row);


	//default values for new members
	$Installment_No = 1;
	$term=1;
	$Br_Amt=$aaamount;
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
		(`uid`,`Fname`,`Mname`,`Lname`,`Nname`,`Sex`,`Status`,`Street`,`Barangay`,`City`,`Province`,`IDno`,`Bdate`,`Age`,`Bplace`,`Occupation`,`Religion`,`Pname`,`Page`,`Prelation`,`Pcontactno`,`Cstreet`,`Cbarangay`,`Ccity`,`Cprovince`,`Mcontactno`,`Bname`,`Bbdate`,`Bage`,`Brelation`,`Bstatus`,`Bcontactno`,`Dname1`,`Dbdate1`,`Dage1`,`Drelation1`,`Dstatus1`,`Dname2`,`Dbdate2`,`Dage2`,`Drelation2`,`Dstatus2`,`Dname3`,`Dbdate3`,`Dage3`,`Drelation3`,`Dstatus3`,`Dname4`,`Dbdate4`,`Dage4`,`Drelation4`,`Dstatus4`,`Member_Code`) 
		values 
		('$uniqid','$aafirstname','$aamiddlename','$aasurname','$aamiddlename','$aasex','$aacivilstatus','$aapurok','$aabarangay','$aamunicipality','$aaprovince','$aavalidid','$aabirthdate','$aaage','$aabithplace','$aaoccupation','$aareligion','$aapayorname','$aapayorage','$aapayorrelation','$aapayorcontactno','$aapayorpurok','$aapayorbarangay','$aapayormunicipality','$aapayorprovince','$aamembercontactno','$aabenename','$aabenebirthdate','$aabeneage','$aabenerelation','$aabenecivilstatus','$aabenecontactno','$aadepname1','$aadepbirthdate1','$aadepage1','$aadeprelationship1','$aadepcivilstatus1','$aadepname2','$aadepbirthdate2','$aadepage2','$aadeprelationship2','$aadepcivilstatus2','$aadepname3','$aadepbirthdate3','$aadepage3','$aadeprelationship3','$aadepcivilstatus3','$aadepname4','$aadepbirthdate4','$aadepage4','$aadeprelationship4','$aadepcivilstatus4','$new_member_code');
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

	$aaamount_org = $aaamount/$number_of_payment;

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
		'$aaamount_org',
		'$unit',
		'$term',
		'$Br_period_covered',
		'$Br_installment_no',
		'$Br_Amt',
		'$aaprdate',
		'$aaprno',
		'$aaordate',
		'$aaornumber',
		'',
		'',
		current_date(),
		'$overDueDate2',
		'$deactivationDate2'
		)";


		$sql_Installment_ledger_rows.="$sql_Installment_ledger_row".($number_of_payment-$i==1?'':',');
	}


	$sql_Installment_ledger = "
		INSERT INTO Installment_ledger	(
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
		`DueDate`,
		`DeactivationDate`
		) 
		VALUES 	$sql_Installment_ledger_rows; 
	";

	
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


	//SHARE COMPUTATION ----------------------------------------------------------------------------------------------------------------
if ($save_successful==1) {
	$res_computation = mysqli_query($con,"
	SELECT
	    `members_account`.`BranchManager`
	    , `members_account`.`AgentID`
	    , `packages`.`Plan_id`
	    , `packages`.`Agent_Share_1st`
	    , `packages`.`Agent_Share_2nd`
	    , `packages`.`BM_Share_1st`
	    , `packages`.`BM_Share_2nd`
	    , `packages`.`Comp_Constant`
	    , `packages`.`Const_BM_Share`
	    , `packages`.`Const_Agent_Share`
	    , `branch_details`.`mainoffice`
	FROM
	    `dmcpi1_dmcsm`.`members_account`
	    INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
	        ON (`members_account`.`Member_Code` = `members_profile`.`Member_Code`)
	    INNER JOIN `dmcpi1_dmcsm`.`packages` 
	        ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
	    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
	        ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
	WHERE (`members_profile`.`Member_Code` ='$new_member_code');
   ");

	$comp = mysqli_fetch_array($res_computation,MYSQLI_ASSOC);
	$PLAN_ID = $comp['Plan_id'];
	$BM_ID = $comp['BranchManager'];
	$AGENT_ID = $comp['AgentID'];
	$COSTANT_COMPUTATION = $comp['Comp_Constant'];
	$MAINOFFICE = $comp['mainoffice'];

	$BM_SHARE_RATE = 0;
	$AG_SHARE_RATE = 0;
	$BM_SHARE_FIXED_AMOUNT=0;
	$AG_SHARE_FIXED_AMOUNT=0;
	$BM_SHARE_COMP_MODE = '';
	$AG_SHARE_COMP_MODE = '';
	$SHARE_COMP_SQL = '';
	$MODE_OF_COMPUTATION = '';
	$SHARE_COMP_SQL_ROW='';
	$SHARE_COMP_SQL_ROWS='';

	$comp_date = date('Y-m-15',  strtotime($aaordate));

	for ($i=0; $i < $number_of_payment ; $i++) { 
		$amount = $aaamount_org;

		$month = date('M', strtotime("+$i month", strtotime($comp_date))); //jan to dec
		$year  = date('Y', strtotime("+$i month", strtotime($comp_date))); //YYYY
		$next_installment_no = $i+1;
		$Period_No = date('m', strtotime($month));
		$term = ceil($next_installment_no / 12);

		$BM_SHARE_RATE = 0;
		$AG_SHARE_RATE = 0;
		$BM_SHARE_FIXED_AMOUNT=0;
		$AG_SHARE_FIXED_AMOUNT=0;
		$BM_SHARE_COMP_MODE = '';
		$AG_SHARE_COMP_MODE = '';
		$BM_SHARE_AMOUNT = 0;
		$AG_SHARE_AMOUNT = 0;
		$MODE_OF_COMPUTATION = '';

		if ($COSTANT_COMPUTATION==1){
			$BM_SHARE_RATE=0;
			$AG_SHARE_RATE=0;
			if ($MAINOFFICE==1){
				$BM_SHARE_FIXED_AMOUNT=0;
				$AG_SHARE_FIXED_AMOUNT=$comp['Const_Agent_Share']+$comp['Const_BM_Share'];				
			}else{
				$BM_SHARE_FIXED_AMOUNT=$comp['Const_BM_Share'];
				$AG_SHARE_FIXED_AMOUNT=$comp['Const_Agent_Share'];				
			}
			$BM_SHARE_AMOUNT = $BM_SHARE_FIXED_AMOUNT;
			$AG_SHARE_AMOUNT = $AG_SHARE_FIXED_AMOUNT;
			$MODE_OF_COMPUTATION = 'CONSTANT';
		}else{	 //PERCENTAGE
			$BM_SHARE_FIXED_AMOUNT=0;
			$AG_SHARE_FIXED_AMOUNT=0;
			if ($next_installment_no<13){
				if ($MAINOFFICE==1){
					$BM_SHARE_COMP_MODE='';
					$AG_SHARE_COMP_MODE='1ST';
					$BM_SHARE_RATE = 0;
					$AG_SHARE_RATE = $comp['BM_Share_1st']+$comp['Agent_Share_1st'];				
				}else{
					$BM_SHARE_COMP_MODE='1ST';
					$AG_SHARE_COMP_MODE='1ST';
					$BM_SHARE_RATE = $comp['Agent_Share_1st'];
					$AG_SHARE_RATE = $comp['BM_Share_1st'];
				}

			}else{

				if ($MAINOFFICE==1){
					$BM_SHARE_COMP_MODE='';
					$AG_SHARE_COMP_MODE='2ND';
					$BM_SHARE_RATE = 0;
					$AG_SHARE_RATE = $comp['BM_Share_2nd']+$comp['Agent_Share_2nd'];									
				}else{
					$BM_SHARE_COMP_MODE='2ND';
					$AG_SHARE_COMP_MODE='2ND';
					$BM_SHARE_RATE = $comp['Agent_Share_2nd'];
					$AG_SHARE_RATE = $comp['BM_Share_2nd'];									
				} 
			}
			$BM_SHARE_AMOUNT = $amount * $BM_SHARE_RATE/100.0;
			$AG_SHARE_AMOUNT = $amount * $AG_SHARE_RATE/100.0;
			$MODE_OF_COMPUTATION = 'PERCENTAGE';
		}

		$SHARE_COMP_SQL_ROW = "(
			'$AGENT_ID',
			'$BM_ID',
			'$new_member_code',
			'$PLAN_ID',
			'$amount',
			'$next_installment_no',
			'$AG_SHARE_RATE',
			'$BM_SHARE_RATE',
			'$MODE_OF_COMPUTATION',
			'$BM_SHARE_AMOUNT',
			'$AG_SHARE_AMOUNT',
			'$month',
			'$year',
			'$Period_No',
			'$aaornumber',
			'$aaordate'
			)
		";

		$SHARE_COMP_SQL_ROWS .= $SHARE_COMP_SQL_ROW.($i==$number_of_payment-1?';':','); 
	}
		$SHARE_COMP_SQL = "
			INSERT INTO tbl_sharecomputation (
			`AgentID`,
			`BranchID`,
			`Member_Code`,
			`PlanID`,
			`Amount_Paid`,
			`NoOfPeriodPaid`,
			`AgentShareRate`,
			`BMShareRate`,
			`Mode_of_Computation`,
			`BMShareAmount`,
			`AgentShareAmount`,
			`Month`,
			`Year`,
			`PeriodNo`,
			`ORno`,
			`ORdate`)
			VALUES $SHARE_COMP_SQL_ROWS 
			";
		//echo "$SHARE_COMP_SQL";
		mysqli_query($con, $SHARE_COMP_SQL);

	echo "$SHARE_COMP_SQL";
	mysqli_free_result($res_computation);

} 	
include '../dbclose.php';

?>

