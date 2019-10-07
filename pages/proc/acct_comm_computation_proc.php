<?php  

include '../dbconnect.php';

$ORno 			=  (isset($_REQUEST['ORno'])?$_REQUEST['ORno']:''); 
$user_id 		=  (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:''); 
$Member_Code    =  (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:''); 
$is_sleeve_fee  =  (isset($_REQUEST['is_sleeve_fee'])?$_REQUEST['is_sleeve_fee']:'');

if ($is_sleeve_fee==0) {

	//START: INCENTIVES COMPUTATION -------------------------------------------

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
		    , `packages`.`oi_computation`
		    , `packages`.`oi_bm_fixed`
		    , `packages`.`oi_bm_percentage`
		    , `packages`.`oi_ffso_fixed`
		    , `packages`.`oi_ffso_percentage`
			, `agent_profile`.`referrer_id`
			, `agent_profile`.`referrer_type`

		FROM
		    `dmcpi1_dmcsm`.`members_account`
		    INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
		        ON (`members_account`.`Member_Code` = `members_profile`.`Member_Code`)
		    INNER JOIN `dmcpi1_dmcsm`.`packages` 
		        ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
		    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
		        ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
		    INNER JOIN `dmcpi1_dmcsm`.`agent_profile`
				ON (`agent_profile`.`AgentID` = `members_account`.`AgentID`)
		WHERE (`members_profile`.`Member_Code` ='$Member_Code');
	   ");

		$comp = mysqli_fetch_array($res_computation,MYSQLI_ASSOC);
		$PLAN_ID = $comp['Plan_id'];
		$BM_ID = $comp['BranchManager'];
		$AGENT_ID = $comp['AgentID'];
		$COSTANT_COMPUTATION = $comp['Comp_Constant'];
		$MAINOFFICE = $comp['mainoffice'];

		$OI_COMPUTATION=$comp['oi_computation'];
		$OI_BM_FIXED=$comp['oi_bm_fixed'];
		$OI_BM_PERCENTAGE=$comp['oi_bm_percentage'];
		$OI_FFSO_FIXED=$comp['oi_ffso_fixed'];
		$OI_FFSO_PERCENTAGE=$comp['oi_ffso_percentage'];
		$OI_FEFERRER_ID=$comp['referrer_id'];
		$OI_FEFERRER_TYPE =$comp['referrer_type'];


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


		$res_orinfo = mysqli_query($con,"SELECT Installment_No, Amt_Due, Period_No,Period_Year,Period_Covered,ORdate FROM installment_ledger WHERE ORNO='$ORno' ORDER BY Installment_No");
		$res_orinfo_count = mysqli_num_rows($res_orinfo);

		$i=0;
	    while ($r=mysqli_fetch_array($res_orinfo,MYSQLI_ASSOC)) {
			$amount = $r['Amt_Due'];
			$month = $r['Period_Covered'];
			$year = $r['Period_Year'];
			$next_installment_no = $r['Installment_No'];
			$Period_No = $r['Period_No'];
			$term = ceil($r['Installment_No'] / 12);
			$ORdate = $r['ORdate'];
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
				$MODE_OF_COMPUTATION = 'Constant';
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
				$MODE_OF_COMPUTATION = 'Percentage';
			}

			//OVERRIDING INCENTIVES -------------------
			$OI_FFSO_AMT=0;
			$OI_BM_AMT=0;
			$OI_REF_BM_ID=0;
			$OI_REF_FFSO_ID=0;

			if ($OI_COMPUTATION == 1) {

				//echo "OI_FEFERRER_TYPE: $OI_FEFERRER_TYPE  ";
				//echo "OI_FEFERRER_ID: $OI_FEFERRER_ID  ";

				if ($OI_FEFERRER_ID > 0 &&  ($OI_FEFERRER_TYPE=='FFSO' ||  $OI_FEFERRER_TYPE=='BM')) {
					if ($OI_FEFERRER_TYPE=='FFSO') {$OI_REF_FFSO_ID=$OI_FEFERRER_ID;}
					if ($OI_FEFERRER_TYPE=='BM')   {$OI_REF_BM_ID  =$OI_FEFERRER_ID;}

					if ($OI_FFSO_FIXED>0) {$OI_FFSO_AMT = $OI_FFSO_FIXED;}
					if ($OI_FFSO_PERCENTAGE>0) {$OI_FFSO_AMT = $OI_FFSO_PERCENTAGE*$amount/100;}
					if ($OI_BM_FIXED>0) {$OI_BM_AMT = $OI_BM_FIXED;}
					if ($OI_BM_PERCENTAGE>0) {$OI_BM_AMT = $OI_BM_PERCENTAGE*$amount/100;}
				}
			}

			//PREPARE RESULTS -------------------------
			$SHARE_COMP_SQL_ROW = "(
				'$AGENT_ID',
				'$BM_ID',
				'$Member_Code',
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
				'$ORno',
				'$ORdate',
				'$OI_FFSO_AMT',
				'$OI_BM_AMT',
				'$OI_REF_FFSO_ID',
				'$OI_REF_BM_ID'
				)
			";

			$SHARE_COMP_SQL_ROWS .= $SHARE_COMP_SQL_ROW.($i==$res_orinfo_count-1?';':',');
			$i++; 
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
				`ORdate`,
				`oi_ffso`,
				`oi_bm`,
				`oi_ffso_id`,
				`oi_bm_id`
				)
				VALUES $SHARE_COMP_SQL_ROWS 
				";
			//echo "$SHARE_COMP_SQL";
		mysqli_query($con, $SHARE_COMP_SQL);
}	//end: if ($is_sleeve_fee==0) 

	mysqli_free_result($res_computation);
	mysqli_free_result($res_orinfo);

//echo "$SHARE_COMP_SQL";

//CHECK RESULTS-------------------------------------------------------
if (mysqli_affected_rows($con)==0){
          echo "**failed**";
}else{

	$row_sql = "SELECT
	    DISTINCT
	     `installment_ledger`.`LedgerID`
	    , `installment_ledger`.`Br_installment_no` AS 'BR_INSNo'
	    , `installment_ledger`.`Member_Code`
	    , `packages`.`Plan_Code`
	    , UPPER( CONCAT(`members_profile`.`Fname`,' ', MID(`members_profile`.`Mname`,1,1) ,'. ' ,`members_profile`.`Lname`) ) AS Member
	    , `installment_ledger`.`Br_period_covered`
	    , SUM(`installment_ledger`.`Amt_Due`) AS 'GROSS'
	    , `installment_ledger`.`ORdate`
	    , `installment_ledger`.`ORno`
	    , SUM(IFNULL(`tbl_sharecomputation`.BMShareAmount,0)) AS BM_Commision
	    , SUM(IFNULL(`tbl_sharecomputation`.AgentShareAmount,0)) AS AG_Commision
	    , SUM(IFNULL(`tbl_sharecomputation`.oi_bm,0)) AS BM_OI
	    , SUM(IFNULL(`tbl_sharecomputation`.oi_ffso,0)) AS FFSO_OI                         
	    , SUM(IFNULL(`tbl_sharecomputation`.oi_bm,0)+IFNULL(`tbl_sharecomputation`.oi_ffso,0)+IFNULL(`tbl_sharecomputation`.BMShareAmount,0)+IFNULL(`tbl_sharecomputation`.AgentShareAmount,0)) AS TOTAL_INCENTIVES                         
	    , SUM(`installment_ledger`.Amt_Due) - SUM(IFNULL(`tbl_sharecomputation`.oi_bm,0)+IFNULL(`tbl_sharecomputation`.oi_ffso,0)+IFNULL(`tbl_sharecomputation`.BMShareAmount,0)+IFNULL(`tbl_sharecomputation`.AgentShareAmount,0)) AS NET            
	    , IF(ISNULL(`tbl_sharecomputation`.AgentShareAmount),0,1) AS 'INC_COMPUTED'
	FROM
	    `dmcpi1_dmcsm`.`members_account`
	    INNER JOIN `dmcpi1_dmcsm`.`installment_ledger` 
	        ON (`members_account`.`Member_Code` = `installment_ledger`.`Member_Code`)
	    INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
	        ON (`members_profile`.`Member_Code` = `members_account`.`Member_Code`)
	    INNER JOIN `dmcpi1_dmcsm`.`packages`
	        ON (`members_account`.`Plan_id`=`packages`.`Plan_id`)
	LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation`
	ON (`installment_ledger`.ORno = `tbl_sharecomputation`.ORno)
	    WHERE 
		`installment_ledger`.`ORno`=$ORno

	    GROUP BY   
	         `installment_ledger`.`Member_Code`
	        ,`members_profile`.`Fname`
	        ,`members_profile`.`Mname`  
	        ,`members_profile`.`Lname`
	        ,`installment_ledger`.`Br_period_covered`
	        ,`installment_ledger`.`Br_installment_no`
	        ,`installment_ledger`.`PRdate`
	        ,`installment_ledger`.`PRno`
	        ,`installment_ledger`.`ORdate`
	        ,`installment_ledger`.`ORno` 
	        ,`installment_ledger`.`date_encoded`
	    ORDER BY ORDATE DESC
	    ;
	";

	$res_data = mysqli_query($con,$row_sql);
	$cnt=0;
	$row="";
	while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {

	    $Member_Code = $r['Member_Code']; 
	    $Fullname = $r['Member']; 
	    $Plan_Code= $r['Plan_Code'];

	    $Br_period_covered = $r['Br_period_covered']; 
	    $GROSS = $r['GROSS'];
	    $ORno = $r['ORno'];
	    $ORdate = $r['ORdate'];

	    $BM_Commision= $r['BM_Commision'];
	    $AG_Commision= $r['AG_Commision'];
	    $BM_OI= $r['BM_OI'];
	    $FFSO_OI= $r['FFSO_OI'];
	    $TOTAL_INCENTIVES= $r['TOTAL_INCENTIVES'];
	    $NET  = $r['NET'];

	    $btnCommOption="";
	    if ($r['INC_COMPUTED']==0){
	        $btnCommOption = "
	        <button type=\"button\" 
	        ORno=$ORno 
	        Member_Code=\"$Member_Code\"
	        id=btn_comm_compute 
	        class=\"btn btn-primary btn-sm\"
	        >COMPUTE</button>";
	    }else{
	        $btnCommOption = "
	        <button type=\"button\" 
	        ORno=$ORno 

            BM_Commision=$BM_Commision
            AG_Commision=$AG_Commision
            BM_OI=$BM_OI
            FFSO_OI=$FFSO_OI
            data-toggle=\"modal\" data-target=\"#modal_comm_alter\"

	        Member_Code=\"$Member_Code\"
	        id=btn_alter_computation 
	        class=\"btn btn-default btn-sm\"
	        disabled=true
	        >ALTER</button>";                                            
	    }
	    $cnt++;
	    $row="
	        
	            <td class=\"even gradeC\">>></td>
	            <td>$Member_Code</td>
	            <td>$Fullname</td>
	            <td>$Plan_Code</td>
	            
	            <td><div class='pull-right'>$GROSS</div></td>
	            <td>$ORno</td>
	            <td>$ORdate</td>
	            <td>$TOTAL_INCENTIVES</td>
	            <td>$NET</td>
	            <td>$btnCommOption</td>

	            <!--td>$Br_period_covered</td>
	            <td>$BM_Commision</td>
	            <td>$AG_Commision</td>
	            <td>$BM_OI</td>
	            <td>$FFSO_OI</td-->
	        

	    ";
	}
	mysqli_free_result($res_data);
    echo "**success**|$row";
}

include '../dbclose.php';
?>