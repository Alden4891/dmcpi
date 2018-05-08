
<?php

	$p_year = (isset($_REQUEST['year'])?$_REQUEST['year']:'');
	$p_month = (isset($_REQUEST['month'])?$_REQUEST['month']:'');
	$table_rows = "";

	include '../dbconnect.php';


	$res = mysql_query("

		SELECT
		    `AgentID`
		    , `AGENT`
		    , `Initials`
		    , Amount_Paid
		    , `BM_SHARE`
		    , `AGENT_SHARE`
		    , `AGENT_SHARE` + `BM_SHARE` AS TOTAL_SHARE
		    , `No_of_Clients`
		    , `Month`
		    , `Year`
		    , `PeriodNo`
		FROM
		    `dmcsm`.`vbmagentshares`
		WHERE (`Year` =$p_year
		    AND `Month`='$p_month')
		ORDER BY `AGENT` ASC;


	") or die(mysql_error());
	if (mysql_num_rows($res)==0){
		echo "**failed**";
	}else{

		while ($r=mysql_fetch_array($res,MYSQL_ASSOC)) {
			$AgentID=$r['AgentID'];
			$AGENT=$r['AGENT'];
			$Initials=$r['Initials'];
			$Amount_Paid=$r['Amount_Paid'];
			$BM_SHARE=$r['BM_SHARE'];
			$AGENT_SHARE = $r['AGENT_SHARE'];
			$TOTAL_SHARE = $r['TOTAL_SHARE'];
			$No_of_Clients=$r['No_of_Clients'];
			
			$row_template="<tr><td>$AGENT</td><td>$Amount_Paid</td><td>$BM_SHARE</td><td>$AGENT_SHARE</td><td>$TOTAL_SHARE</td><td>$No_of_Clients</td><td>
			
				<a href=\"#\" 
				type=\"button\" 
				class=\"btn btn-primary btn-xs agentbyclientsharelist \"  
				data-toggle=\"modal\" 
				data-target=\"#showagentscleintsharelist_modal\" 
				id=agentbyclientsharelist 
				name=agentbyclientsharelist 
				year=$p_year 
				month=$p_month 
				agentid=$AgentID 
				agentname=\"$AGENT\"
				>DETAILS</a>


	        	<a href=\"#\" class=\"btn btn-primary btn-circle agentbyclientsharelist\" year=$Year month=$Month data-toggle=\"modal\" data-target=\"#showagentscleintsharelist_modal\" id=agentbyclientsharelist name=agentbyclientsharelist><i class=\"fa fa-list\"></i></a>

			</td></tr>";
			$table_rows .= $row_template;
		}

		echo "**success**|$table_rows";
		

	}
	mysql_free_result($res);
    include '../dbclose.php';

?>


