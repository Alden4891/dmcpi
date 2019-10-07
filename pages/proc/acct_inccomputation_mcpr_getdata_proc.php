<?php  

include '../dbconnect.php';

$MCPR_ID 			=  (isset($_REQUEST['MCPR_ID'])?$_REQUEST['MCPR_ID']:''); 



$sql = "

SELECT
    `tbl_mcpr_details`.`MCPR_EID`
    , `tbl_mcpr_details`.`Plan_Code`
    , `tbl_mcpr_details`.`Member_Code`
    , `tbl_mcpr_details`.`CLIENT` AS `Member`
    , `installment_ledger`.`Br_period_covered`
    , IFNULL(`tbl_mcpr_details`.`ENC_AMOUNT`,0) AS `GROSS`
    , `tbl_mcpr_details`.`ENC_OR` AS ORno
    , `tbl_mcpr_details`.`ENC_ORDATE` AS ORdate
    , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + 
      SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + 
      SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + 
      SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS `TOTAL_INCENTIVES`
    , IFNULL(`tbl_mcpr_details`.`ENC_AMOUNT`,0) - 
      SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + 
      SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + 
      SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + 
      SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0))  AS `NET`
 
    , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) AS BM_Commision
    , SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) AS AG_Commision
    , SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) AS FFSO_OI
    , SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS BM_OI
    , IF(ISNULL(SUM(tbl_sharecomputation.AgentShareAmount)),0,1) AS 'INC_COMPUTED'
    , `members_account`.`BranchManager` AS Branch_ID
FROM
    `dmcpi1_dmcsm`.`installment_ledger`
    RIGHT JOIN `dmcpi1_dmcsm`.`tbl_mcpr_details` 
        ON (`installment_ledger`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
    LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
        ON (`tbl_sharecomputation`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
    LEFT JOIN `dmcpi1_dmcsm`.`members_account`
        ON (`members_account`.`Member_Code` = `tbl_mcpr_details`.`Member_Code`)


WHERE (`tbl_mcpr_details`.`MCPR_ID` =$MCPR_ID)
GROUP BY `tbl_mcpr_details`.`MCPR_ID`, `tbl_mcpr_details`.`Plan_Code`, `tbl_mcpr_details`.`Member_Code`, `tbl_mcpr_details`.`CLIENT`, `GROSS`, `tbl_mcpr_details`.`ENC_OR`, `tbl_mcpr_details`.`ENC_ORDATE`
ORDER BY `tbl_mcpr_details`.`MCPR_EID`
;

";



$res_data = mysqli_query($con,"$sql") or die(mysqli_error());


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

                                        $Branch_ID = $r['Branch_ID'];
                                        $BM_VITO_ID=17;

                                        $ROW_COLOR = "bgcolor=\"\"";
                                        if ($Branch_ID == $BM_VITO_ID) {
                                            $ROW_COLOR = "bgcolor=\"#FFEFD5\"";
                                        }

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
                                            class=\"btn btn-primary btn-sm\"
                                            >ALTER</button>";                                            
                                        }
                                        $cnt++;
                                        $row .= "
                                            <tr id=sharelistdata $ROW_COLOR >
                                                <td class=\"even gradeC\"> $cnt</td>
                                                <td>$Member_Code</td>
                                                <td>$Fullname</td>
                                                <td>$Plan_Code</td>
                                                
                                                <td><div class='pull-right'>$GROSS</div></td>
                                                <td>$ORno</td>
                                                <td>$ORdate</td>
                                                <td>$TOTAL_INCENTIVES</td>
                                                <td>$NET</td>
                                                <td>$btnCommOption</td>

                                                <td>$Br_period_covered</td>
                                                <td>$BM_Commision</td>
                                                <td>$AG_Commision</td>
                                                <td>$BM_OI</td>
                                                <td>$FFSO_OI</td>
                                            </tr>

                                        ";


        }


	mysqli_free_result($res_data);
    echo "**success**|$row";


include '../dbclose.php';
?>