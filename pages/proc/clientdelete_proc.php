<?php

/*
DESCRIPTION: DELETE CLIENT PROC
PARENT FORM: clientlistaddedit.php
*/
    $activity = "";
    $user_id = (isset($_REQUEST['userid'])?$_REQUEST['userid']:'0');
    $member_code = (isset($_REQUEST['member_code'])?$_REQUEST['member_code']:'');



    include '../dbconnect.php';

    //check if newly registered client (1 = newly registered)
    $res = mysqli_query($con, "SELECT COUNT(*) as 'DELETABLE' FROM tbl_audittrail WHERE activities LIKE '%$member_code%' AND DATE(`DATE`)= CURDATE();") or die(mysqli_error());
    $r = mysqli_fetch_array($res,MYSQLI_ASSOC); 

    if ($r['DELETABLE']=='1'){

        mysqli_query($con, "DELETE FROM members_account WHERE Member_Code = '$member_code';");
        mysqli_query($con, "DELETE FROM members_profile WHERE Member_Code = '$member_code';");
        mysqli_query($con, "DELETE FROM installment_ledger WHERE Member_Code = '$member_code';");

        $activity = "Deleted client information (Member_Code#$member_code)";
        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','REGISTRATION',$user_id,NOW())");  
        echo "**success**";       
    }else{
        echo "**failed**";
    }

    mysqli_free_result( $res);
    include '../dbclose.php';



      //  echo "**success**";

?>





