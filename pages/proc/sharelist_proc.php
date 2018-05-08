<?php

	$p_year = (isset($_REQUEST['p_year'])?$_REQUEST['p_year']:'');
	$p_month = (isset($_REQUEST['p_month'])?$_REQUEST['p_month']:'');
	$summary = "";

	include '../dbconnect.php';


	$res = mysql_query("call sp_share_generate ($p_year,$p_month);") or die(mysql_error());
	if (mysql_num_rows($res)==0){
		echo "**failed**";
	}else{


		$table_rows = "";

		$tot_bm_share=0;
		$tot_agent_share=0;
		$tot_bm_agent=0;
		$tot_clients=0;


		while ($r=mysql_fetch_array($res,MYSQL_ASSOC)) {
			$AgentID=$r['AgentID'];
			$AGENT=$r['AGENT'];
			$Initials=$r['Initials'];
			$BM_SHARE=$r['BM_SHARE'];
			$No_of_Clients=$r['No_of_Clients'];
			$AGENT_SHARE=$r['AGENT_SHARE'];
			$total_share=$BM_SHARE + $AGENT_SHARE;


			$row_template = "<tr><td>$AGENT</td><td>$BM_SHARE</td><td>$AGENT_SHARE</td><td>$total_share</td><td>$p_year</td><td>$p_month</td></tr>";
			$table_rows.=$row_template;

			$tot_bm_share+=$BM_SHARE;
			$tot_agent_share+=$AGENT_SHARE;
			$tot_bm_agent+=1;
			$tot_clients+=$No_of_Clients;
		}

		$summary = "$tot_bm_share|$tot_agent_share|$tot_bm_agent|$tot_clients";
		echo "**success**|$summary|$table_rows";
		

	}
	mysql_free_result($res);
    include '../dbclose.php';

?>