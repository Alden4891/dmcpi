<?php

	$p_year = (isset($_REQUEST['p_year'])?$_REQUEST['p_year']:'');
	$p_month = (isset($_REQUEST['p_month'])?$_REQUEST['p_month']:'');
	$summary = "";
	$user_id = (isset($_REQUEST['userid'])?$_REQUEST['userid']:'0');

	include '../dbconnect.php';

	$monthName = date("F", mktime(0, 0, 0, $p_month, 10));

	$res = mysqli_query($con, "call sp_share_generate ($p_year,$p_month,$user_id);") or die(mysqli_error());
	if (mysqli_num_rows($res)==0){
		echo "**failed**";
	}else{


		$table_rows = "";

		$tot_bm_share=0;
		$tot_agent_share=0;
		$tot_bm_agent=0;
		$tot_payment=0;


		while ($r=mysqli_fetch_array($res,MYSQLI_ASSOC)) {
			$NAME=$r['NAME'];
			$Amount_Paid=$r['Amount_Paid'];
			//$NoOfPeriodPaid=$r['NoOfPeriodPaid'];
			$ShareAmount=$r['ShareAmount'];
			$POSITION=$r['POSITION'];
			if ($POSITION=='AGENT'){
				$tot_agent_share+=$Amount_Paid;
			}else{
				$tot_bm_share+=$Amount_Paid;
			}

			$row_template = "<tr><td>$NAME</td><td>$POSITION</td><td>".number_format($Amount_Paid,2)."</td><td>".number_format($ShareAmount,2)."</td><td>$monthName</td><td>$p_year</td></tr>";
			$table_rows.=$row_template;
			$tot_bm_agent+=1;
			$tot_payment+=$Amount_Paid;
		}

		$summary = number_format($tot_bm_share,2)."|".number_format($tot_agent_share,2)."|$tot_bm_agent|".number_format($tot_payment,2);
		

		echo "**success**|$summary|$table_rows";
		

	}
	mysqli_free_result($res);
    include '../dbclose.php';

?>