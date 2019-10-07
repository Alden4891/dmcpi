<?php
$ParamYear  = (isset($_REQUEST['year'])?$_REQUEST['year']:1900);//2018;
#$ParamAgentID  = (isset($_REQUEST['AgentID'])?$_REQUEST['AgentID']:0);//8;
$paramMonth = (isset($_REQUEST['month'])?$_REQUEST['month']:1);//8;;
$encoder_name = (isset($_REQUEST['encoder_name'])?$_REQUEST['encoder_name']:1);//8;;
$user_id = (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:1);

$branchdata  = (isset($_REQUEST['p_branch'])?$_REQUEST['p_branch']:0);//8;
$arr_branchdata = explode('|', $branchdata);
$p_branch = $arr_branchdata[0];
$p_woa = $arr_branchdata[2];
$p_wa = $arr_branchdata[1];
$p_total = $p_wa + $p_woa;
$active_session_id = 0;
$res_session_id = mysqli_query($con,"SELECT IF (date_end < NOW(),ID*-1,ID) AS session_id FROM tbl_activities WHERE isactive=1;");
if (mysqli_num_rows($res_session_id) > 0) {
	$row_session = mysqli_fetch_row($res_session_id);
	$active_session_id = $row_session[0];
}
/*
if ($p_woa > 0) {
	echo "**prompt**|It seems that $p_woa out of $p_total members under this branch doesnt have Agent Information encoded. Please Update the records before proceeding.";
	return;
}
*/

include '../dbconnect.php';

//RESET MCPR
mysqli_query($con,"DELETE FROM tbl_mcpr_details WHERE MCPR_ID IN (SELECT MCPR_ID FROM tbl_mcpr WHERE `year`=$ParamYear AND `month`=$paramMonth AND branch_id=$p_branch);");
mysqli_query($con,"DELETE FROM tbl_mcpr WHERE `year`=$ParamYear AND `month`=$paramMonth AND branch_id=$p_branch;");

//FETCH DATA
$res_agents = mysqli_query($con,"
SELECT
    `members_account`.`AgentID`
FROM
    `dmcpi1_dmcsm`.`members_account`
    INNER JOIN `dmcpi1_dmcsm`.`agent_profile` 
        ON (`members_account`.`AgentID` = `agent_profile`.`AgentID`)
WHERE (`members_account`.`Account_Status` IN ('Active','Overdue')
    AND `members_account`.`AgentID` >0
    AND `members_account`.`BranchManager` = $p_branch)
GROUP BY `members_account`.`AgentID`;
");


$sqls = "";
while ($r=mysqli_fetch_array($res_agents,MYSQLI_ASSOC)) {
	$AgentID = $r['AgentID'];
	//$res_data = mysqli_query($con,"CALL sp_mcpr ($ParamYear, $paramMonth, $AgentID,'$encoder_name',$user_id);"); 
	//print_r($res_data);
	
	$sqls .= "CALL sp_mcpr ($ParamYear, $paramMonth, $AgentID,'$encoder_name',$user_id,$active_session_id);";

}
//echo "$sqls";
echo "$sqls";

mysqli_multi_query($con,$sqls) or die(MYSQLI_ERROR()) ;

$arr_sql = explode(";", $sqls);
$cnt=0;
foreach ($arr_sql as $key => $sql) {
	if ($sql<>""){
		 $cnt=$cnt+1;
	}
}

	echo "**success**!$cnt";

//mysqli_query($con,$sqls) or die(MYSQLI_ERROR());


//mysqli_free_result($res_data);
//mysqli_free_result($res_agents);

include '../dbclose.php';
?>