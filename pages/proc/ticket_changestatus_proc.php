<?php  
include '../dbconnect.php';

$CMD 		=  (isset($_REQUEST['CMD'])?$_REQUEST['CMD']:''); 
$TICKETNO 	=  (isset($_REQUEST['TICKETNO'])?$_REQUEST['TICKETNO']:'');
$USER_ID = (isset($_REQUEST['USER_ID'])?$_REQUEST['USER_ID']:'');



$res = mysqli_query($con,"SELECT USER_ID FROM tickets WHERE TICKETNO = $TICKETNO;");
$r=mysqli_fetch_array($res, MYSQLI_ASSOC);
$CP_USER_ID = $r['USER_ID'];

//echo "$CMD | $CP_USER_ID | $USER_ID";

if ($CMD=='close') {
	mysqli_query($con,"UPDATE tickets set STATUS = 3, DATE_UPDATED = NOW() WHERE TICKETNO = $TICKETNO;");
}else if ($CMD=='cancel' && $CP_USER_ID == $USER_ID){	
	mysqli_query($con,"UPDATE tickets set STATUS = 4, DATE_UPDATED = NOW() WHERE TICKETNO = $TICKETNO;");	
}else{
	mysqli_query($con,"UPDATE tickets set STATUS = 5, DATE_UPDATED = NOW() WHERE TICKETNO = $TICKETNO;");		
}


echo "**success**";
//echo "$RESPONSE";

mysqli_free_result($res);
include '../dbclose.php';
?>