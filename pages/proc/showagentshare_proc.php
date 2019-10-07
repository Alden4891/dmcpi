
<?php

	$p_year = (isset($_REQUEST['year'])?$_REQUEST['year']:'');
	$p_month = (isset($_REQUEST['month'])?$_REQUEST['month']:'');
	$branch_id= (isset($_REQUEST['branch_id'])?$_REQUEST['branch_id']:'');
	$agent_rows = "";
	$agent_oi_rows = "";
	$bm_rows = "";
	$bm_oi_rows = "";

	include '../dbconnect.php';
	//echo "$p_month";
/*
echo "	SELECT
	    `agent_profile`.AgentID
	    , UCASE(CONCAT(`agent_profile`.`Last_name`,', ',`agent_profile`.`First_name`,' ',SUBSTR(`agent_profile`.`Middle_Name`,1,1),'.')) AS `AGENT`
	    ,`agent_profile`.Initials AS `Initials`
	    , SUM(`v_sharecomputation`.`Amount_Paid`) AS `Amount_Paid`
	    , SUM(`v_sharecomputation`.`NoOfPeriodPaid`) AS `NoOfPeriodPaid`
	    , SUM(`v_sharecomputation`.`AgentShareAmount`) AS `AgentShareAmount`
	    , MONTH(`v_sharecomputation`.`ordate`) AS `Month`
	    , YEAR(`v_sharecomputation`.`ordate`) AS `Year`
	FROM
	    `dmcpi1_dmcsm`.`agent_profile`
	    INNER JOIN `dmcpi1_dmcsm`.`v_sharecomputation` 
	        ON (`agent_profile`.`AgentID` = `v_sharecomputation`.`AgentID`)
	WHERE (YEAR(`v_sharecomputation`.`ordate`)= $p_year
	    AND MONTH(`v_sharecomputation`.`ordate`) = $p_month
	    AND  v_sharecomputation.`BranchID` = $branch_id
	    )
	GROUP BY `agent_profile`.AgentID,`agent_profile`.`Last_name`, `agent_profile`.First_name, `agent_profile`.Middle_Name, `agent_profile`.Initials
	HAVING (`AgentShareAmount` > 0)
	ORDER BY `v_sharecomputation`.`Year` DESC, `v_sharecomputation`.`PeriodNo` DESC, `AGENT` ;
| 

	SELECT
	    `branch_details`.`Branch_ID`
	    , `branch_details`.`Branch_Manager`
	    , SUM(`v_sharecomputation`.`Amount_Paid`) AS `Amount_Paid`
	    , SUM(`v_sharecomputation`.`NoOfPeriodPaid`) AS `NoOfPeriodPaid`
	    , SUM(`v_sharecomputation`.`BMShareAmount`) AS `BMShareAmount`
	    , MONTH(`v_sharecomputation`.`ordate`) AS `Month`
	    , YEAR(`v_sharecomputation`.`ordate`) AS `Year`
	FROM
	    `dmcpi1_dmcsm`.`branch_details`
	    INNER JOIN `dmcpi1_dmcsm`.`v_sharecomputation` 
	        ON (`branch_details`.`Branch_ID` = `v_sharecomputation`.`BranchID`)
	WHERE (YEAR(`v_sharecomputation`.`ordate`)= $p_year
	    AND MONTH(`v_sharecomputation`.`ordate`)= $p_month
	    AND  `v_sharecomputation`.`BranchID` = $branch_id
	    )
	GROUP BY 
	`branch_details`.`Branch_ID`, 
	`branch_details`.`Branch_Manager`, 
	MONTH(`v_sharecomputation`.`ordate`), 
	YEAR(`v_sharecomputation`.`ordate`)
	HAVING (`BMShareAmount` >0)
	ORDER BY `year` DESC, periodno DESC, branch_manager;
";

*/



	$res_agent = mysqli_query($con, "
	SELECT
	    `agent_profile`.AgentID
	    , UCASE(CONCAT(`agent_profile`.`Last_name`,', ',`agent_profile`.`First_name`,' ',SUBSTR(`agent_profile`.`Middle_Name`,1,1),'.')) AS `AGENT`
	    ,`agent_profile`.Initials AS `Initials`
	    , SUM(`v_sharecomputation`.`Amount_Paid`) AS `Amount_Paid`
	    , SUM(`v_sharecomputation`.`NoOfPeriodPaid`) AS `NoOfPeriodPaid`
	    , SUM(`v_sharecomputation`.`AgentShareAmount`) AS `AgentShareAmount`
	    , SUM(`v_sharecomputation`.`oi_ffso`) AS `oi_ffso`
	    , MONTH(`v_sharecomputation`.`ordate`) AS `Month`
	    , YEAR(`v_sharecomputation`.`ordate`) AS `Year`
	FROM
	    `dmcpi1_dmcsm`.`agent_profile`
	    INNER JOIN `dmcpi1_dmcsm`.`v_sharecomputation` 
	        ON (`agent_profile`.`AgentID` = `v_sharecomputation`.`AgentID`)
	WHERE (YEAR(`v_sharecomputation`.`ordate`)= $p_year
	    AND MONTH(`v_sharecomputation`.`ordate`) = $p_month
	    AND  v_sharecomputation.`BranchID` = $branch_id
	    )
	GROUP BY `agent_profile`.AgentID,`agent_profile`.`Last_name`, `agent_profile`.First_name, `agent_profile`.Middle_Name, `agent_profile`.Initials
	HAVING (`AgentShareAmount` > 0)
	ORDER BY `v_sharecomputation`.`Year` DESC, `v_sharecomputation`.`PeriodNo` DESC, `AGENT` ;
	") or die(mysqli_error());

	$res_agent_oi = mysqli_query($con,"
	SELECT
	      `agent_profile`.`AgentID`
	    , `agent_profile`.`Initials`
	    , UCASE(CONCAT(`agent_profile`.`Last_name`,', ',`agent_profile`.`First_name`,' ',SUBSTR(`agent_profile`.`Middle_Name`,1,1),'.')) AS `AGENT`
	    , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `GROSS`
	    , SUM(`tbl_sharecomputation`.`oi_ffso`) AS `OI`
	FROM
	    `dmcpi1_dmcsm`.`tbl_sharecomputation`
	    INNER JOIN `dmcpi1_dmcsm`.`agent_profile` 
	        ON (`tbl_sharecomputation`.`oi_ffso_id` = `agent_profile`.`AgentID`)
	WHERE (`tbl_sharecomputation`.`BranchID` =  $branch_id
	    AND YEAR(ORdate) = $p_year
	    AND MONTH(ORdate) = $p_month);
	") or die(mysqli_error());


	$res_bm = mysqli_query($con, "
	SELECT
	    `branch_details`.`Branch_ID`
	    , `branch_details`.`Branch_Manager`
	    , SUM(`v_sharecomputation`.`Amount_Paid`) AS `Amount_Paid`
	    , SUM(`v_sharecomputation`.`NoOfPeriodPaid`) AS `NoOfPeriodPaid`
	    , SUM(`v_sharecomputation`.`BMShareAmount`) AS `BMShareAmount`
	    , SUM(`v_sharecomputation`.`oi_bm`) AS `oi_bm`
	    , MONTH(`v_sharecomputation`.`ordate`) AS `Month`
	    , YEAR(`v_sharecomputation`.`ordate`) AS `Year`
	FROM
	    `dmcpi1_dmcsm`.`branch_details`
	    INNER JOIN `dmcpi1_dmcsm`.`v_sharecomputation` 
	        ON (`branch_details`.`Branch_ID` = `v_sharecomputation`.`BranchID`)
	WHERE (YEAR(`v_sharecomputation`.`ordate`)= $p_year
	    AND MONTH(`v_sharecomputation`.`ordate`)= $p_month
	    AND  `v_sharecomputation`.`BranchID` = $branch_id
	    )
	GROUP BY 
	`branch_details`.`Branch_ID`, 
	`branch_details`.`Branch_Manager`, 
	MONTH(`v_sharecomputation`.`ordate`), 
	YEAR(`v_sharecomputation`.`ordate`)
	HAVING (`BMShareAmount` >0)
	ORDER BY `year` DESC, periodno DESC, branch_manager;

	") or die(mysqli_error());

	$res_bm_oi = mysqli_query($con,"
		SELECT
		      `branch_details`.`Branch_ID`
		    , `branch_details`.`Branch_Manager`
		    , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `GROSS`
		    , SUM(`tbl_sharecomputation`.`oi_bm`) AS `OI`
		FROM
		    `dmcpi1_dmcsm`.`tbl_sharecomputation`
		    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
		        ON (`tbl_sharecomputation`.`oi_bm_id` = `branch_details`.`Branch_ID`)
		WHERE (`tbl_sharecomputation`.`BranchID` =$branch_id
		    AND YEAR(ORdate) =$p_year
		    AND MONTH(ORdate) =$p_month);
	") or die(mysqli_error());



	if (mysqli_num_rows($res_agent)+mysqli_num_rows($res_bm)+mysqli_num_rows($res_agent_oi)>0){

		//AGENT ROWS
		while ($r=mysqli_fetch_array($res_agent,MYSQLI_ASSOC)) {
			$AgentID=$r['AgentID'];
			$AGENT=$r['AGENT'];
			$Initials=$r['Initials'];
			$Amount_Paid=$r['Amount_Paid'];
			$NoOfPeriodPaid=$r['NoOfPeriodPaid'];
			$AgentShareAmount = $r['AgentShareAmount'];
			$oi_ffso = $r['oi_ffso'];

			$row_template="<tr>
								<td>$Initials</td>
								<td>$AGENT</td>
								<td>$NoOfPeriodPaid</td>
								<td>".number_format($Amount_Paid,2)."</td>
								<td>".number_format($AgentShareAmount,2)."</td>
								<td>
									<a href=\"#\" 
									type=\"button\" 
									class=\"btn btn-primary btn-xs agentbyclientsharelist \"  
									data-toggle=\"modal\" 
									data-target=\"#showagentscleintsharelist_modal\" 
									id=agentbyclientsharelist 
									name=agentbyclientsharelist 
									year=$p_year 
									month=$p_month 
									pid=$AgentID 
									pname=\"$AGENT\"
									ptype=\"AGENT\"
									>DETAILS</a>
								</td>
							</tr>";
			$agent_rows .= $row_template;
		}

		//AGENT OI ROWS
		while ($r=mysqli_fetch_array($res_agent_oi,MYSQLI_ASSOC)) {
			$AgentID=$r['AgentID'];
			$AGENT=$r['AGENT'];
			$Initials=$r['Initials'];
			$gross=$r['GROSS'];
			$oi=$r['OI'];

			$row_template="<tr>
								<td>$Initials</td>
								<td>$AGENT</td>
								<td>".number_format($gross,2)."</td>
								<td>".number_format($oi,2)."</td>
								<td>
									<a href=\"#\" 
									type=\"button\" 
									class=\"btn btn-primary btn-xs agentbyclientsharelist \"  
									disabled
									>DETAILS</a>
								</td>
							</tr>";
			$agent_oi_rows .= $row_template;
		}


		//BMROWS ROWS
		while ($r=mysqli_fetch_array($res_bm,MYSQLI_ASSOC)) {
			$Branch_ID=$r['Branch_ID'];
			
			$Branch_Manager=$r['Branch_Manager'];
			$NoOfPeriodPaid=$r['NoOfPeriodPaid'];
			$Amount_Paid=$r['Amount_Paid'];
			$BMShareAmount=$r['BMShareAmount'];
			$oi_bm=$r['oi_bm'];

			$row_template="<tr>
								<td>$Branch_Manager</td>
								<td>$NoOfPeriodPaid</td>
								<td>".number_format($Amount_Paid,2)."</td>
								<td>".number_format($BMShareAmount,2)."</td>
								<td>
									<a href=\"#\" 
									type=\"button\" 
									class=\"btn btn-primary btn-xs agentbyclientsharelist \"  
									data-toggle=\"modal\" 
									data-target=\"#showagentscleintsharelist_modal\" 
									id=agentbyclientsharelist 
									name=agentbyclientsharelist 
									year=$p_year 
									month=$p_month 
									pid=$Branch_ID 
									pname=\"$Branch_Manager\"
									ptype=\"BM\"
									>DETAILS</a>
								</td>
							</tr>";
			$bm_rows .= $row_template;
		}

		//AGENT OI ROWS
		while ($r=mysqli_fetch_array($res_bm_oi,MYSQLI_ASSOC)) {
			$Branch_ID=$r['Branch_ID'];
			$Branch_Manager=$r['Branch_Manager'];
			$gross=$r['GROSS'];
			$oi=$r['OI'];

			$row_template="<tr>
								<td>$Branch_Manager</td>
								<td>".number_format($gross,2)."</td>
								<td>".number_format($oi,2)."</td>
								<td>
									<a href=\"#\" 
									type=\"button\" 
									class=\"btn btn-primary btn-xs agentbyclientsharelist \"  
									disabled
									>DETAILS</a>
								</td>
							</tr>";
			$bm_oi_rows .= $row_template;
		}




		echo "**success**|$agent_rows|$bm_rows|$agent_oi_rows|$bm_oi_rows";
	}else{
		echo "**failed**";
	}


	mysqli_free_result($res_agent);
	mysqli_free_result($res_agent_oi);
	mysqli_free_result($res_bm);
    include '../dbclose.php';

?>
