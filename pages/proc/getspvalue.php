<?php

    $sp = (isset($_GET['sp'])?$_GET['sp']:'');
	include '../dbconnect.php';

	$res_data = mysqli_query($con,$sp) or die("**failed**");
	$r 		= mysqli_fetch_row($res_data);
	$value 	= $r[0];
	echo $value;
	
			
	
	mysqli_free_result($res_data);
    include '../dbclose.php';

?>