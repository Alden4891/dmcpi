

<?php

    $p_year = (isset($_REQUEST['year'])?$_REQUEST['year']:'');
    $p_month = (isset($_REQUEST['month'])?$_REQUEST['month']:'');
    $pid = (isset($_REQUEST['pid'])?$_REQUEST['pid']:'');
    $percentage_rows = "";
    $constant_rows = "";


    include '../dbconnect.php';


    $res_percentage = mysqli_query($con, "
    SELECT
        `members_profile`.`Member_Code`
        , UCASE(CONCAT(`members_profile`.`Fname`,' ',LEFT(`members_profile`.`Mname`,1),'. ',`members_profile`.`Lname`)) AS BENEFICIARY
        , `dmcpi1_dmcsm`.`packages`.`Plan_Code`
        , SUM(`v_sharecomputation`.`Amount_Paid`) AS Amount_Paid
        ,  IF (`Mode_of_Computation`='Constant','n/a', CONCAT(`v_sharecomputation`.`AgentShareRate`,'%')) AS 'AgentShareRate'
        ,  IF (`Mode_of_Computation`='Constant','n/a', CONCAT(`v_sharecomputation`.`BMShareRate`,'%')) AS 'BMShareRate'
        , `v_sharecomputation`.`Mode_of_Computation`
        , SUM(`v_sharecomputation`.`BMShareAmount`) AS `BMShareAmount`
        , SUM(`v_sharecomputation`.`AgentShareAmount`) AS `AgentShareAmount`
        , SUM(`v_sharecomputation`.`oi_ffso`) AS `oi_ffso`
        , SUM(`v_sharecomputation`.`oi_bm`) AS `oi_bm`
        , SUM(`v_sharecomputation`.`AgentShareAmount`) 
            + SUM(`v_sharecomputation`.`BMShareAmount`)
            + SUM(`v_sharecomputation`.`oi_ffso`)
            + SUM(`v_sharecomputation`.`oi_bm`)
             AS 'TOTAL'
    FROM
        `dmcpi1_dmcsm`.`v_sharecomputation`
        INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
            ON (`v_sharecomputation`.`Member_Code` = `members_profile`.`Member_Code`)
        INNER JOIN `dmcpi1_dmcsm`.`packages`
            ON (`v_sharecomputation`.`PlanID` = `dmcpi1_dmcsm`.`packages`.`Plan_id`)    
        WHERE (YEAR(`v_sharecomputation`.`ORdate`) =$p_year
            AND MONTH(`v_sharecomputation`.`ORdate`) = '$p_month' 
            AND AgentID=$pid 
            AND NOT `Mode_of_Computation`='Constant') 
    GROUP BY `members_profile`.`Member_Code`, `members_profile`.`Fname`, `members_profile`.`Mname`, `members_profile`.`Lname`
    ORDER BY BENEFICIARY;

    ") or die(mysqli_error());

    $res_constant = mysqli_query($con, "
    SELECT
        `members_profile`.`Member_Code`
        , UCASE(CONCAT(`members_profile`.`Fname`,' ',LEFT(`members_profile`.`Mname`,1),'. ',`members_profile`.`Lname`)) AS BENEFICIARY
        , `dmcpi1_dmcsm`.`packages`.`Plan_Code`
        , sum(`v_sharecomputation`.`Amount_Paid`) as Amount_Paid
        ,  IF (`Mode_of_Computation`='Constant','n/a', CONCAT(`v_sharecomputation`.`AgentShareRate`,'%')) AS 'AgentShareRate'
        ,  IF (`Mode_of_Computation`='Constant','n/a', CONCAT(`v_sharecomputation`.`BMShareRate`,'%')) AS 'BMShareRate'
        , `v_sharecomputation`.`Mode_of_Computation`
        , SUM(`v_sharecomputation`.`BMShareAmount`) AS `BMShareAmount`
        , SUM(`v_sharecomputation`.`AgentShareAmount`) AS `AgentShareAmount`
        , SUM(`v_sharecomputation`.`oi_ffso`) AS `oi_ffso`
        , SUM(`v_sharecomputation`.`oi_bm`) AS `oi_bm`
        , SUM(`v_sharecomputation`.`AgentShareAmount`) 
            + SUM(`v_sharecomputation`.`BMShareAmount`) 
            + SUM(`v_sharecomputation`.`oi_ffso`)
            + SUM(`v_sharecomputation`.`oi_bm`)
            AS 'TOTAL'
    FROM
        `dmcpi1_dmcsm`.`v_sharecomputation`
        INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
            ON (`v_sharecomputation`.`Member_Code` = `members_profile`.`Member_Code`)
        INNER JOIN `dmcpi1_dmcsm`.`packages`
            ON (`v_sharecomputation`.`PlanID` = `dmcpi1_dmcsm`.`packages`.`Plan_id`)    
    WHERE (YEAR(`v_sharecomputation`.`ORdate`) =$p_year
            AND MONTH(`v_sharecomputation`.`ORdate`) = '$p_month' 
            AND AgentID=$pid 
            AND `Mode_of_Computation`='Constant') 
        GROUP BY `members_profile`.`Member_Code`, `members_profile`.`Fname`, `members_profile`.`Mname`, `members_profile`.`Lname`
        ORDER BY BENEFICIARY;

    ") or die(mysqli_error());

    $res_percentage_count=mysqli_num_rows($res_percentage);
    $res_constant_count=mysqli_num_rows($res_constant);


    if ($res_percentage_count>0){

        while ($r=mysqli_fetch_array($res_percentage,MYSQLI_ASSOC)) {
            $Member_Code=$r['Member_Code'];
            $BENEFICIARY=$r['BENEFICIARY'];
            $Amount_Paid=$r['Amount_Paid'];
            $BMShareRate=$r['BMShareRate'];
            $AgentShareRate=$r['AgentShareRate'];

            $oi_bm=$r['oi_bm'];
            $oi_ffso=$r['oi_ffso'];

            $Plan_Code=$r['Plan_Code'];

            $Mode_of_Computation = $r['Mode_of_Computation'];
            $BMShareAmount = $r['BMShareAmount'];
            $AgentShareAmount=$r['AgentShareAmount'];

            $TOTAL_SHARE =$r['TOTAL'];
            
            $row_template="<tr>
            <td>$Member_Code</td>
            <td>$BENEFICIARY</td>
            <td>$Plan_Code</td>
            <td>$Amount_Paid</td>
            <td>$AgentShareRate</td>
            <td>$AgentShareAmount</td>
            <!--td>$oi_ffso</td-->
            </tr>";
            $percentage_rows .= $row_template;
        }
    }

    if ($res_constant_count>0){
        while ($r=mysqli_fetch_array($res_constant,MYSQLI_ASSOC)) {
            $Member_Code=$r['Member_Code'];
            $BENEFICIARY=$r['BENEFICIARY'];
            $Amount_Paid=$r['Amount_Paid'];
            $BMShareRate=$r['BMShareRate'];
            $AgentShareRate=$r['AgentShareRate'];

            $oi_bm=$r['oi_bm'];
            $oi_ffso=$r['oi_ffso'];

            $Plan_Code=$r['Plan_Code'];

            $Mode_of_Computation = $r['Mode_of_Computation'];
            $BMShareAmount = $r['BMShareAmount'];
            $AgentShareAmount=$r['AgentShareAmount'];
            $TOTAL_SHARE =$r['TOTAL'];
            
            $row_template="<tr>
            <td>$Member_Code</td>
            <td>$BENEFICIARY</td>
            <td>$Plan_Code</td>
            <td>$Amount_Paid</td>
            <td>$AgentShareAmount</td>
            <!--td>$oi_ffso</td-->

            </tr>";
            $constant_rows .= $row_template;
        }

    }

    if ($res_constant_count+$res_percentage_count>0){
        echo "**success**|$percentage_rows|$constant_rows";
    }else{
         echo "**failed**";
    }
    
    mysqli_free_result($res_percentage);
    mysqli_free_result($res_constant);

    include '../dbclose.php';

?>





