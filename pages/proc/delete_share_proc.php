<?php

/*
DESCRIPTION: DELETE SHARE PROC
PARENT FORM: sharelist.php
*/
    $activity = "";
    $user_id = (isset($_REQUEST['userid'])?$_REQUEST['userid']:'0');
    $p_year = (isset($_REQUEST['year'])?$_REQUEST['year']:'');
    $p_month = (isset($_REQUEST['month'])?$_REQUEST['month']:'');


    include '../dbconnect.php';


    mysqli_query($con, "DELETE FROM tbl_sharecomputation WHERE MONTH='$p_month' AND YEAR=$p_year") or die(mysqli_error());


    if (mysqli_affected_rows($con)==0){
        echo "**failed**";
    }else{
        $activity = "Deletion of share computation for $p_month year $p_year";
        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','SHARES',$user_id,NOW())");  
        echo "**success**";
    }

    include '../dbclose.php';



      //  echo "**success**";

?>





