<?php
    
    $ES_START = (isset($_REQUEST['ES_START'])?$_REQUEST['ES_START']:'');
    $ES_END = (isset($_REQUEST['ES_END'])?$_REQUEST['ES_END']:'');
    $ES_SESSION_ID = (isset($_REQUEST['ES_SESSION_ID'])?$_REQUEST['ES_SESSION_ID']:0);

    include '../dbconnect.php';
    $res = mysqli_query($con, "
        SELECT CONCAT(MONTHNAME(CONCAT(YEAR,'-',MONTHNO,'-15')),' ', `YEAR`) AS SCHED, date(DATE_START), date(DATE_END) FROM tbl_activities 
        WHERE 
        ('$ES_START' BETWEEN DATE_START AND DATE_END
        OR '$ES_END' BETWEEN DATE_START AND DATE_END)
        AND ID <> $ES_SESSION_ID
        LIMIT 0,1;
    ");

    if (mysqli_num_rows($res)>0) {
        $row=mysqli_fetch_row($res);
        $data=$row[0];        
        $DATE_START=$row[1];        
        $DATE_END=$row[2];        

        echo "**conflict**|Conflict with $data encoding schedule ($DATE_START to $DATE_END)";
    }else{
        echo "**success**";        
    }

    include '../dbclose.php';

?>