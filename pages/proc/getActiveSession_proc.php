<?php

include '../dbconnect.php';


$res = mysqli_query($con, "SELECT ID,PARTICULAR,DATE_START,DATE_END,MONTHNO,YEAR,ISACTIVE FROM tbl_activities WHERE ISACTIVE = 1;");

if (mysqli_num_rows($res)>0){
	$row=mysqli_fetch_row($res);
	$ID  		=$row[0];
	$PARTICULAR  =$row[1];
	$DATE_START  =$row[2];
	$DATE_END  	=$row[3];
	$MONTHNO  	=$row[4];
	$YEAR  		=$row[5];
	$ISACTIVE  	=$row[6];
	//return "$ID|$PARTICULAR|$DATE_START|$DATE_END|$MONTHNO|$YEAR|$ISACTIVE";
	echo json_encode($row);
}else{
	echo "";
}




include '../dbclose.php';
?>