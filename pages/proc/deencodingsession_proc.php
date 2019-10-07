<?php
    
    $save_mode = (isset($_REQUEST['save_mode'])?$_REQUEST['save_mode']:'');
    $ES_SESSION_ID = (isset($_REQUEST['ES_SESSION_ID'])?$_REQUEST['ES_SESSION_ID']:0);
    $ES_PARTICULAR = (isset($_REQUEST['ES_PARTICULAR'])?$_REQUEST['ES_PARTICULAR']:'');
    $ES_MONTH = (isset($_REQUEST['ES_MONTH'])?$_REQUEST['ES_MONTH']:'');
    $ES_YEAR = (isset($_REQUEST['ES_YEAR'])?$_REQUEST['ES_YEAR']:'');
    $ES_START = (isset($_REQUEST['ES_START'])?$_REQUEST['ES_START']:'');
    $ES_END = (isset($_REQUEST['ES_END'])?$_REQUEST['ES_END']:'');

    include '../dbconnect.php';

    $sql= "";
    if ($save_mode=="insert"){
        $sql = "INSERT INTO `dmcpi1_dmcsm`.`tbl_activities`(`ID`,`PARTICULAR`,`DATE_START`,`DATE_END`,`MONTHNO`,`YEAR`) 
                VALUES ( NULL,'$ES_PARTICULAR','$ES_START','$ES_END','$ES_MONTH','$ES_YEAR');";
    }else if ($save_mode=="update"){
        $sql = "UPDATE `dmcpi1_dmcsm`.`tbl_activities` SET 
                    `PARTICULAR` = '$ES_PARTICULAR',
                    `DATE_START`='$ES_START',
                    `DATE_END`='$ES_END',
                    `MONTHNO`='$ES_MONTH',
                    `YEAR`='$ES_YEAR' 
                WHERE `ID`='$ES_SESSION_ID';";
    }else if ($save_mode=="delete"){
        $sql = "DELETE FROM `dmcpi1_dmcsm`.`tbl_activities` WHERE `ID`='$ES_SESSION_ID';";
    }else if ($save_mode=='activate'){
        $sql = "
            UPDATE `dmcpi1_dmcsm`.`tbl_activities` SET `ISACTIVE` = '1' WHERE `ID`='$ES_SESSION_ID';
            UPDATE `dmcpi1_dmcsm`.`tbl_activities` SET `ISACTIVE` = NULL WHERE `ID`<>'$ES_SESSION_ID';
        ";
    }
    echo "sql:$sql";
    $res = mysqli_multi_query($con, $sql);

    if ($save_mode=="update"){
        echo mysqli_affected_rows($con)==0?"**noChanges**":"**success**";    
    }else{
        echo mysqli_affected_rows($con)==0?"**failed**":"**success**";    
    }
    
    
    include '../dbclose.php';

?>