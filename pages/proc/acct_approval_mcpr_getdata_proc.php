

<?php  

include '../dbconnect.php';

$MCPR_ID 			=  (isset($_REQUEST['MCPR_ID'])?$_REQUEST['MCPR_ID']:''); 


	//START: INCENTIVES COMPUTATION -------------------------------------------



$res_data = mysqli_query($con,"

SELECT
    `tbl_mcpr_details`.`MCPR_EID`
    , `tbl_mcpr_details`.`Member_Code`
    , `tbl_mcpr_details`.`CLIENT`
    , `tbl_mcpr_details`.`DOI_ORG` AS `DOI`
    , `tbl_mcpr_details`.`Plan_Code`
    , `tbl_mcpr_details`.`ENC_INS`
    , `tbl_mcpr_details`.`ENC_OR`
    , `tbl_mcpr_details`.`ENC_ORDATE` 
    , `tbl_mcpr_details`.`ENC_AMOUNT` AS GROSS
    , `tbl_mcpr_details`.`ENC_PC`
    , `tbl_mcpr_details`.`ENC_USERID`
    , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) AS BM_COM
    , SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) AS AG_COM
    , SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) AS AG_OI
    , SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS BM_OI
    , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS TOTAL_INCENTIVES
    , SUM(IFNULL(`tbl_mcpr_details`.`ENC_AMOUNT`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS NET
    , `tbl_sharecomputation`.`Remarks`
    , `installment_ledger`.`AcctDateApproved`
    , IF (`installment_ledger`.`AcctDateApproved` IS NULL, 0,1) AS IS_APPROVED
    , IF (`tbl_sharecomputation`.`BMShareAmount` IS NULL AND `tbl_sharecomputation`.`AgentShareAmount` IS NULL,0,1) AS IS_COMPUTED
    , IF (`tbl_mcpr_details`.`ENC_OR` IS NULL,0,1) AS IS_ENCODED
FROM
    `dmcpi1_dmcsm`.`tbl_sharecomputation`
    RIGHT JOIN `dmcpi1_dmcsm`.`tbl_mcpr_details` 
        ON (`tbl_sharecomputation`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
    LEFT JOIN `installment_ledger`
    	ON (`installment_ledger`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
WHERE  `tbl_mcpr_details`.`MCPR_ID` =$MCPR_ID 
#AND `tbl_mcpr_details`.`ENC_VALIDATED`=1
GROUP BY 
	  `tbl_mcpr_details`.`MCPR_ID`
	, `tbl_mcpr_details`.`MCPR_EID`
	, `tbl_mcpr_details`.`Member_Code`
	, `tbl_mcpr_details`.`CLIENT`
	, `DOI`
	, `tbl_mcpr_details`.`Plan_Code`
	, `tbl_mcpr_details`.`ENC_INS`
	, `tbl_mcpr_details`.`ENC_OR`
	, `tbl_mcpr_details`.`ENC_ORDATE` 
	, `tbl_mcpr_details`.`ENC_AMOUNT`
	, `tbl_mcpr_details`.`ENC_PC`
	, `tbl_mcpr_details`.`ENC_USERID`
	, `tbl_mcpr_details`.`ENC_VALIDATED`
	, `tbl_sharecomputation`.`Remarks`;

") or die(mysqli_error());


        $cnt=0;
        $row="";
        while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
        
            $Member_Code = $r['Member_Code'];
            $Fullname = $r['CLIENT']; 
			$Plan_Code= $r['Plan_Code'];

            $GROSS = $r['GROSS'];
            $ORno = $r['ENC_OR'];
            $ORdate = $r['ENC_ORDATE'];

            $BM_Commision= $r['BM_COM'];
            $AG_Commision= $r['AG_COM'];
            $BM_OI= $r['BM_OI'];
            $FFSO_OI= $r['AG_OI'];

            $TOTAL_INCENTIVES= $r['TOTAL_INCENTIVES'];
            $NET  = $r['NET'];

            $AcctDateApproved = $r['AcctDateApproved'];


            $btnCommOption="";
            if ($r['IS_ENCODED']==0){
				$AcctDateApproved="NO PAYMENT";            	
            }else if ($r['IS_COMPUTED']==0){
				$AcctDateApproved="INC/COM NOT YET COMPUTED";            	
            }else if ($r['IS_APPROVED']==0){
                $AcctDateApproved = "
                <button type=\"button\" 
                ORno=$ORno 
                id=btnacctapprove 
                class=\"btn btn-primary btn-sm\"
                >VERIFY</button>";
            }else{
            	$AcctDateApproved="DATE APPROVED: $AcctDateApproved";
            }


            $cnt++;
            $row .= "
                <tr id=sharelistdata>
                    <td class=\"even gradeC\"> $cnt</td>
                    <td>$Member_Code</td>
                    <td>$Fullname</td>
                    <td>$Plan_Code</td>
                    


                    <td><div class='pull-right'>$GROSS</div></td>
                    <td>$ORno</td>
                    <td>$ORdate</td>

                    <!--td bgcolor=\"#FDEDEC\">$Br_period_covered</td-->
                    <td bgcolor=\"#FDEDEC\">$BM_Commision</td>
                    <td bgcolor=\"#FDEDEC\">$AG_Commision</td>
                    <td bgcolor=\"#FDEDEC\">$BM_OI</td>
                    <td bgcolor=\"#FDEDEC\">$FFSO_OI</td>



                    <td bgcolor=\"#FDEDEC\"><B>$TOTAL_INCENTIVES</B></td>
                    <td>$NET</td>
                    <td>$AcctDateApproved</td>

                </tr>

            ";


        }


	mysqli_free_result($res_data);
    echo "**success**|$row";


include '../dbclose.php';
?>