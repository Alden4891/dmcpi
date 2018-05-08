<?php
/*
DESCRIPTION: DISPLAYS THE LIST OF SHARES PER CLIENTS in a modal
PARENT FORM: sharelist.php
MODAL: agentbyclientsharelist modal

*/
//showagentsharebyclient_proc.php
echo "this is a test";

/*
SELECT
    `members_profile`.`Member_Code`
    , UCASE(CONCAT(`members_profile`.`Fname`,' ',LEFT(`members_profile`.`Mname`,1),'. ',`members_profile`.`Lname`)) AS BENEFICIARY
    , `tbl_sharecomputation`.`Amount_Paid`
    ,  IF (`Mode_of_Computation`='Constant','n/a', CONCAT(`tbl_sharecomputation`.`AgentShareRate` * 100,'%')) AS 'AgentShareRate'
    ,  IF (`Mode_of_Computation`='Constant','n/a', CONCAT(`tbl_sharecomputation`.`BMShareRate` * 100,'%')) AS 'BMShareRate'
    , `tbl_sharecomputation`.`Mode_of_Computation`
    , `tbl_sharecomputation`.`BMShareAmount`
    , `tbl_sharecomputation`.`AgentShareAmount`
    , `tbl_sharecomputation`.`AgentShareAmount` + `tbl_sharecomputation`.`BMShareAmount` AS 'TOTAL'
FROM
    `dmcsm`.`tbl_sharecomputation`
    INNER JOIN `dmcsm`.`members_profile` 
        ON (`tbl_sharecomputation`.`Member_Code` = `members_profile`.`Member_Code`)
WHERE (`tbl_sharecomputation`.`Year` =2013
    AND `tbl_sharecomputation`.`PeriodNo` =11 AND AgentID=26) ORDER BY BENEFICIARY;
*/




?>

