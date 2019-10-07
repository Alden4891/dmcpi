<?php  

include '../dbconnect.php';

$ORno 			=  (isset($_REQUEST['ORno'])?$_REQUEST['ORno']:''); 
$user_id 		=  (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:''); 
$source         = (isset($_REQUEST['source'])?$_REQUEST['source']:'');


//UPDATE -----------------------------------------------------------
$res = mysqli_query($con, "
UPDATE installment_ledger
	SET AcctDateApproved = CURRENT_DATE(),
	    AcctApprovedBy = $user_id
WHERE ORno = $ORno; 
" ) OR die ($sql);

//CHECK RESULTS-------------------------------------------------------
if (mysqli_affected_rows($con)==0){
          echo "**failed**";
}else{

$sql = "

                                        SELECT
                                            `installment_ledger`.`Member_Code`
                                            , CONCAT(`members_profile`.`Fname`,' ',`members_profile`.`Mname`,' ',`members_profile`.`Lname`) AS `CLIENT`
                                            , `packages`.`Plan_Code`
                                            , SUM(`installment_ledger`.`Amt_Due`) AS `GROSS`
                                            , `installment_ledger`.`ORno` AS `ENC_OR`
                                            , `installment_ledger`.`ORdate` AS `ENC_ORDATE`
                                            , `tbl_sharecomputation`.`BMShareAmount` AS `BM_COM`
                                            , `tbl_sharecomputation`.`AgentShareAmount` AS `AG_COM`
                                            , `tbl_sharecomputation`.`oi_bm` AS `BM_OI`
                                            , `tbl_sharecomputation`.`oi_ffso` AS `AG_OI`
                                            ,  SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS TOTAL_INCENTIVES
                                            , SUM(IFNULL(`installment_ledger`.`Amt_Due`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS NET
                                            , `tbl_sharecomputation`.`Remarks`
                                            , `installment_ledger`.`AcctDateApproved`
                                            , IF (`installment_ledger`.`AcctDateApproved` IS NULL, 0,1) AS IS_APPROVED
                                            , IF (`tbl_sharecomputation`.`BMShareAmount` IS NULL AND `tbl_sharecomputation`.`AgentShareAmount` IS NULL,0,1) AS IS_COMPUTED
                                            , IF (`installment_ledger`.`Amt_Due` IS NULL,0,1) AS IS_ENCODED

                                        FROM
                                            `dmcpi1_dmcsm`.`members_profile`
                                            INNER JOIN `dmcpi1_dmcsm`.`installment_ledger` 
                                                ON (`members_profile`.`Member_Code` = `installment_ledger`.`Member_Code`)
                                            INNER JOIN `dmcpi1_dmcsm`.`members_account` 
                                                ON (`members_profile`.`Member_Code` = `members_account`.`Member_Code`)
                                            INNER JOIN `dmcpi1_dmcsm`.`packages` 
                                                ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
                                            LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
                                                ON (`tbl_sharecomputation`.`ORno` = `installment_ledger`.`ORno`)
                                        WHERE 
                                            `installment_ledger`.`ORno` = '$ORno'
                                        GROUP BY 
                                            `installment_ledger`.`Member_Code`
                                            , `members_profile`.`Fname`
                                            , `members_profile`.`Mname`
                                            , `members_profile`.`Lname`
                                            , `packages`.`Plan_Code`
                                            , `ENC_OR`
                                            , `installment_ledger`.`ORdate`
                                            , `BM_COM`
                                            , `AG_COM`
                                            , `BM_OI`
                                            , `AG_OI`;


";






$res_data = mysqli_query($con,$sql) or die(mysqli_error());

$r=mysqli_fetch_array($res_data,MYSQLI_ASSOC);

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
            $row = "
                    <td class=\"even gradeC\"> >> </td>
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


            ";

	mysqli_free_result($res_data);
    echo "**success**|$row";



echo "**success**|";
}

include '../dbclose.php';
?>