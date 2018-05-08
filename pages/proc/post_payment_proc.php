<?php

	$arr_amount = $_POST['pay_amount'];
	$arr_month = $_POST['pay_month'];
	$arr_year = $_POST['pay_year'];


	$or_number = $_POST['pay_or_number'];
	$prdate = $_POST['pay_prdate'];
	$pr_number = $_POST['pay_pr_number'];
	$br_period_covered = ''; // JAN-MAY
	$installment_no = 1; // unique indentifier number per entry starting 1
	$units = 1; // from members account
	$term =1; // number of years; increament every 12 months starting from 1
	$br_installment_no = 1; // number of transaction starting from 1
	$br_amount = 1; //total amount per transaction

	for ($i=0; $i < count($arr_amount) ; $i++) { 
		//echo $arr_amount[$i];
		$amount = $arr_amount[$i];
		$month = $arr_month[$i];
		$year = $arr_year[$i];
		$ordate = $_POST['pay_ordate'];


	}

	echo 'Test save: success...';


	//$pay_amount = implode(",",$arr_amount);
	



?>