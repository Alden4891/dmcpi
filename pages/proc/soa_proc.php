<?php

    $member_code = (isset($_REQUEST['member_code'])?$_REQUEST['member_code']:'');
	//$member_code="RO024003959";
	//$present_date=date('Y-m-d', strtotime("Aug 15, 2018"));
	$present_date=date('Y-m-d');

	include '../dbconnect.php';
	//get vars

	$res_account = mysqli_query($con,"
		SELECT
		    `members_account`.`No_of_units`
		    , `members_account`.`Current_term`
		    , `members_account`.`Account_Status`
		    , `packages`.`Amount`
		    , `packages`.`Coverage`
		    , `packages`.`Term`
		    , `packages`.`Constability`
		FROM
		    `dmcpi1_dmcsm`.`members_account`
		    INNER JOIN `dmcpi1_dmcsm`.`packages` 
		        ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
		WHERE (`members_account`.`Member_Code` ='$member_code');
	") or die("**failed**");

	$r_account 		= mysqli_fetch_row($res_account);
	$a_unit 		= $r_account[0];
	$a_currebt_term = $r_account[1];
	$a_status 		= $r_account[2];
	$a_amount 		= $r_account[3];
	$a_coverage 	= $r_account[4];
	$a_term 		= $r_account[5];
	$a_constability	= $r_account[6];


		//get latest ledger entry
		$res_last_ledger = mysqli_query($con, "SELECT Period_Covered, Period_Year,Period_No FROM installment_ledger WHERE Member_Code='$member_code' ORDER BY LedgerID DESC LIMIT 0,1") or die("**failed**");
		$last_ledg_row=mysqli_fetch_row($res_last_ledger);
		$last_ledg_pc = $last_ledg_row[0];
		$last_ledg_py = $last_ledg_row[1];
		$last_ledg_pn = $last_ledg_row[2];
		$last_ledg_dt = date('Y-m-d', strtotime("$last_ledg_pc 15, $last_ledg_py "));
		$present_date = $last_ledg_dt;

		//get the latest mcpr entry
		$res_last_mcpr = mysqli_query($con, "SELECT Installment_No,Installment_Period_Covered,Installment_Period_Year FROM mcpr_ledger WHERE Member_Code='$member_code' ORDER BY mcprid DESC LIMIT 0,1") or die("**failed**");
		$last_mcpr_row=mysqli_fetch_row($res_last_mcpr);
		$last_mcpr_in = $last_mcpr_row[0];
		$last_mcpr_ipc= $last_mcpr_row[1];
		$last_mcpr_ipy= $last_mcpr_row[2];
		$last_mcpr_date= date('Y-m-d', strtotime("$last_mcpr_ipc 15, $last_mcpr_ipy "));
	
		//if no mcpr entry yet, load first payment as last mcpr entry
		if (mysqli_num_rows($res_last_mcpr) == 0){
			$res_first_payment = mysqli_query($con, "SELECT Installment_No, Period_Covered, Period_Year FROM installment_ledger WHERE Member_Code = '$member_code' LIMIT 0,1;") or die("**failed**");
			$last_mcpr_row=mysqli_fetch_row($res_first_payment);
			$last_mcpr_in = $last_mcpr_row[0];
			$last_mcpr_ipc= $last_mcpr_row[1];
			$last_mcpr_ipy= $last_mcpr_row[2];
			$last_mcpr_date = date('Y-m-d', strtotime("-1 months", strtotime(date('Y-m-d', strtotime("$last_mcpr_ipc 15, $last_mcpr_ipy ")))));
		}
		

		//return 0;

		echo "$last_mcpr_date $present_date <br>";

		//get the difference in months
		$ts1 = strtotime($last_mcpr_date);
		$ts2 = strtotime($present_date);
		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);
		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);
		$diff_months = (($year2 - $year1) * 12) + ($month2 - $month1);

		echo "$diff_months";

		//dump null mcpr
		$pperiods = "";
		for ($i=1; $i <= $diff_months ; $i++) { 
			$PeriodDate = date('Y-m-d', strtotime("+".$i." months", strtotime($last_mcpr_date)));
			$PeriodDate_m = date('M',  strtotime("$PeriodDate"));
			$PeriodDate_y = date('Y',  strtotime("$PeriodDate"));
			$pperiods .= "'$PeriodDate_m $PeriodDate_y',";
			$next_mcpr_in = $last_mcpr_in+$i;

				$nullmcpr=
				"INSERT INTO mcpr_ledger ( 
				Amt_Due, 
				Over_Due, 
				Installment_No, 
				ORdate, 
				ORno, 
				Rec_Amt, 
				Remarks, 
				Installment_Period_Covered, 
				Installment_Period_Year, 
				MCPR_remarks, 
				Member_Code, 
				LedgerID 
				)
				 VALUES (
				 '$a_amount',
				 '0',
				 '$next_mcpr_in',
				 null,
				 null,
				 '0',
				 '',
				 '$PeriodDate_m',
				 '$PeriodDate_y',
				 '',
				 '$member_code',
				 null
				 );";
				 echo "$nullmcpr <br>";
				  mysqli_query($con, $nullmcpr) or die("**failed**");

		}

		//update mcpr base on ledger
		if ($pperiods!=""){
			
			$res_new_mcpr = mysqli_query($con,
			"SELECT 
			 Installment_No,
			 Period_Covered,
			 Period_No,
			 Period_Year,
			 Amt_Due,
			 Units,
			 Term,
			 Br_period_covered,
			 Br_installment_no,
			 Br_Amt,
			 ORdate,
			 ORno,
			 LedgerID
			 FROM installment_ledger WHERE Member_Code='$member_code' AND CONCAT(Period_Covered,' ',period_year) IN (".substr($pperiods,0,-1).");") or die("**failed**");		
			while ($r=mysqli_fetch_array($res_new_mcpr,MYSQLI_NUM)){
				$in = $r[0];
				$pc = $r[1];
				$pn = $r[2];
				$py = $r[3];
				$ad = $r[4];
				$u 	= $r[5];
				$t 	= $r[6];
				$bpc = $r[7];
				$bin = $r[8];
				$ba  = $r[9];
				$od  = $r[10];
				$on  = $r[11];
				$lid = $r[12];

				#converts dash separated to cvs
				$period_count = substr_count($bpc,"-")+1;
				$arr_periods = explode("-", $bpc);
				$csv_periods = "";
				foreach ($arr_periods as $key => $value) {
					$csv_periods.="'$value',";
				}
				//echo substr($csv_periods,0,-1);

				$remarks="";
				if ($period_count>1){
					$remarks = "PUT ".$arr_periods[$period_count-1];
				}

				mysqli_query($con,"
				UPDATE mcpr_ledger 
				SET 
				Amt_Due = '$ad', 
				Over_Due = '0', 
				Installment_No = '$in', 
				ORdate = '$od', 
				ORno = '$on', 
				Rec_Amt = '$ba', 
				MCPR_remarks = ''
				WHERE Member_Code='$member_code' AND Installment_Period_Covered = '$pc' AND Installment_Period_Year = '$py'
				") or die("**failed**");

				mysqli_query($con,"
				UPDATE mcpr_ledger 
				SET 
				Remarks = '$remarks', 
				LedgerID = '$lid' 
				WHERE orno='$on' ;
				") or die("**failed**");


				

			}

			mysqli_free_result($res_new_mcpr);
		}
		echo "**success**";
	
	mysqli_free_result($res_last_mcpr);
    include '../dbclose.php';

?>