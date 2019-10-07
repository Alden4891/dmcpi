<?php
    $activity = "";
    $user_id = (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'0');
    $action = (isset($_REQUEST['action'])?$_REQUEST['action']:'');
    $req_id = (isset($_REQUEST['req_id'])?$_REQUEST['req_id']:'');

//    echo "user: $user_id|action: $action|id: $req_id";
//    return;
    include '../dbconnect.php';

	$sql = "";
	if ($action == 'reject') {

        mysqli_query($con, "UPDATE approvals SET STATUS = 'Rejected', action_date = CURRENT_DATE(), action_by = $user_id WHERE id = $req_id");

        $activity = "Request ID# $req_id rejected";

	}else if ($action == 'approve') {

		if ($result=mysqli_query($con,"SELECT commands FROM approvals WHERE id = $req_id")){

		  $row=mysqli_fetch_row($result);

		  $sql=$row[0];

		  mysqli_query($con,$sql);

          mysqli_query($con, "UPDATE approvals SET STATUS = 'Approved', action_date = CURRENT_DATE(), action_by = $user_id WHERE id = $req_id");

		  mysqli_free_result($result);

    	  $activity = "Request ID# $req_id granted.";

		}

	}

        

    if (mysqli_affected_rows($con)==0){

        echo "**failed**";

    }else{

        

        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','PAYMENT',$user_id,NOW())");  

        echo "**success**";

    }



    include '../dbclose.php';















?>