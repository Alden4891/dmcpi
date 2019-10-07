<?php

    $activity = "";
    $user_id = (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'0');
    $action = (isset($_REQUEST['action'])?$_REQUEST['action']:'');
    $id = (isset($_REQUEST['id'])?$_REQUEST['id']:'');
    $Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'');


    include '../dbconnect.php';

	$sql = "";
	if ($action == 'approve') {
        mysqli_query($con, "
			UPDATE deceased_table
			SET approved_by = '$user_id',
			date_approved=current_date()
			WHERE ID = '$id'
        ");
        $activity = "Client#$Member_Code has approved for memorial services.";
	}
        
    if (mysqli_affected_rows($con)==0){
        echo "**failed**";
    }else{
        
        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','PAYMENT',$user_id,NOW())");  
        echo "**success**";
    }

    include '../dbclose.php';





?>