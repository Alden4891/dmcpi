<?php

    $where = (isset($_GET['where'])?$_GET['where']:'');
    $table = (isset($_GET['table'])?$_GET['table']:'');
    $field = (isset($_GET['field'])?$_GET['field']:'');
    
    
	include '../dbconnect.php';
	//get vars

	$res_data = mysqli_query($con,"SELECT $field FROM $table where $where") or die("**failed**");
	$r 		= mysqli_fetch_row($res_data);
	$value 	= $r[0];
	echo $value."|";
	
	print_r($_GET);		
	
	mysqli_free_result($res_data);
    include '../dbclose.php';

?>