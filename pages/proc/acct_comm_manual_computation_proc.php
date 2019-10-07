<?php  

include '../dbconnect.php';

$ORno 			=  (isset($_REQUEST['ORno'])?$_REQUEST['ORno']:''); 
$txtBMComm 		=  (isset($_REQUEST['txtBMComm'])?$_REQUEST['txtBMComm']:''); 
$txtAgentComm   =  (isset($_REQUEST['txtAgentComm'])?$_REQUEST['txtAgentComm']:''); 
$txtBMOI  		=  (isset($_REQUEST['txtBMOI'])?$_REQUEST['txtBMOI']:'');
$txtFFSOOI  	=  (isset($_REQUEST['txtFFSOOI'])?$_REQUEST['txtFFSOOI']:'');


$sql = "
	UPDATE	tbl_sharecomputation
	SET 
		  BMShareAmount='$txtBMComm'
		, AgentShareAmount='$txtAgentComm'
		, oi_ffso='$txtFFSOOI'
		, oi_bm='$txtBMOI'
		, Remarks='Manual Computation'
	WHERE ORno = '$ORno'	
";
$result = mysqli_query($con,$sql);


if (mysqli_affected_rows($con)==0){
          echo "**failed**|$sql";
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