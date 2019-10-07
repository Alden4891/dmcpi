<?php

    $activity = "";
    $user_id = (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'0');
    $action = (isset($_REQUEST['action'])?$_REQUEST['action']:'');
    $Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'');
	$dod = (isset($_REQUEST['dod'])?$_REQUEST['dod']:'');
    $pod = (isset($_REQUEST['pod'])?$_REQUEST['pod']:'');
    $reason = (isset($_REQUEST['reason'])?$_REQUEST['reason']:'');
    $date_reported = (isset($_REQUEST['date_reported'])?$_REQUEST['date_reported']:'');
 	$reported_by = (isset($_REQUEST['reported_by'])?$_REQUEST['reported_by']:'');


 	$burrial_date = (isset($_REQUEST['burrial_date'])?$_REQUEST['burrial_date']:'');
 	$memo_serv_duration = (isset($_REQUEST['memo_serv_duration'])?$_REQUEST['memo_serv_duration']:'');
 	$surcharge = (isset($_REQUEST['surcharge'])?$_REQUEST['surcharge']:'');


    include '../dbconnect.php';

	$sql = "";
	if ($action == 'deceased') {
        mysqli_query($con, "
		INSERT INTO deceased_table (
			Member_Code,
			Date_of_death,
			Place_of_death,
			Reason_of_death,
			Date_reported,
			Reported_by,
			recommended_by,
			date_recommended
			)VALUES (
			'$Member_Code',
			'$dod',
			'$pod',
			'$reason',
			'$date_reported',
			'$reported_by',
			'$user_id',
			current_date());
        ");
        $activity = "Client#$Member_Code was tagged as deceased.";
	}else if ($action == 'update_deceased'){
		
        mysqli_query($con, "
			UPDATE deceased_table 
			SET 
				Date_of_death = '$dod',
				Place_of_death= '$pod',
				Reason_of_death= '$reason',
				Date_reported= '$date_reported',
				Reported_by= '$reported_by',

				burrial_date= '$burrial_date',
				surcharge= '$surcharge',
				memo_serv_duration= '$memo_serv_duration'
			WHERE Member_Code = '$Member_Code';
        ");
        $activity = "Client#$Member_Code burrial information updated";

	}
        
    if (mysqli_affected_rows($con)==0){
        echo "**failed**";
    }else{
        
        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','PAYMENT',$user_id,NOW())");  
        echo "**success**";
    }

    include '../dbclose.php';





?>