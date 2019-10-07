<?php  
include '../dbconnect.php';

$RESPONSE 		=  (isset($_REQUEST['reply'])?$_REQUEST['reply']:''); 
$TICKETNO 	=  (isset($_REQUEST['TICKETNO'])?$_REQUEST['TICKETNO']:'');
$USER_ID = (isset($_REQUEST['sender_user_id'])?$_REQUEST['sender_user_id']:'');
$RESPONSE = addslashes($RESPONSE);

mysqli_query($con, "INSERT INTO chat (CONVERSATION,TICKETNO,DATE_POSTED,USER_ID) VALUES ('$RESPONSE','$TICKETNO',NOW(),'$USER_ID');" );

$res = mysqli_query($con,"SELECT USER_ID FROM tickets WHERE TICKETNO = $TICKETNO;");
$r=mysqli_fetch_array($res, MYSQLI_ASSOC);
if ($r['USER_ID']==$USER_ID) {
	mysqli_query($con,"UPDATE tickets set STATUS = 1, DATE_UPDATED = NOW() WHERE TICKETNO = $TICKETNO;");
}else{
	mysqli_query($con,"UPDATE tickets set STATUS = 2, DATE_UPDATED = NOW() WHERE TICKETNO = $TICKETNO;");	
}


echo "**success**";
//echo "$RESPONSE";

mysqli_free_result($res);
include '../dbclose.php';
?>