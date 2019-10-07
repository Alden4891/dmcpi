<?php

    $activity = "";
    //$user_id = (isset($_REQUEST['userid'])?$_REQUEST['userid']:'0');
    $orno = (isset($_REQUEST['orno'])?$_REQUEST['orno']:'');
    $user_id = (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'');



    include '../dbconnect.php';


    $res_orstatus = mysqli_query($con, "SELECT DISTINCT date_posted, CURRENT_DATE() AS 'today', DATEDIFF(CURRENT_DATE(),date_encoded) AS lapse  FROM installment_ledger WHERE ORno = '$orno'");
    $r = mysqli_fetch_array($res_orstatus,MYSQLI_ASSOC);
    $lapse = $r['lapse'];
    $delete_command = "CALL sp_receipt_delete ($orno) ;";
    $for_approval = 0;
    if ($lapse == 0) {
        mysqli_query($con, $delete_command);
        $activity = "Deleted receipt#$orno (newly encoded)";

    }else{
        //insert to 'for approval' table
        $for_approval = 1;
        mysqli_query($con, "
        INSERT INTO approvals (`description`,`type`,`commands`,`requested_by`,`date_requested`,`reference`) 
        VALUES (
            'Request for deletion of receipt#$orno',
            'Void Receipt',
            '$delete_command',
            '$user_id',
            current_date(),
            '$orno'
            );
        ");

        
        $activity = "Sent request for deletion of receipt#$orno";

    }



    //check if newly encoded receipt
         //if so return '**success**'

    // --



    //mysqli_query($con, "") or die(mysqli_error());


    if (mysqli_affected_rows($con)==0){
        echo "**failed**";
    }else{
        
        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) 
                            VALUES ('$activity','PAYMENT',$user_id,NOW())");  

        mysqli_query($con, "");  
        

        echo ($for_approval == 1?'**for_approval**':'**success**');


        //echo "**success**";
    }

    include '../dbclose.php';




?>