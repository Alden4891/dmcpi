<?php

    $username = (isset($_REQUEST['username'])?$_REQUEST['username']:'');
	$password = (isset($_REQUEST['password'])?$_REQUEST['password']:'');
	$mode =     (isset($_REQUEST['mode'])?$_REQUEST['mode']:'');



	include '../dbconnect.php';
	$res = mysqli_query($con, "

			SELECT
			    `users`.`user_id`
			    , `users`.`fullname`
			    , `users`.`username`
			    , `users`.`password`
			    , `users`.`role_id`
			    , `users`.`branch_id`
			    , `users`.`branch_ids`
			    , `users`.`status`
			    , `users`.`mode`
			    , `roles`.*
			FROM
			    `dmcpi1_dmcsm`.`users`
			    INNER JOIN `dmcpi1_dmcsm`.`roles` 
			        ON (`roles`.`role_id` = `users`.`role_id`)
			WHERE (`users`.`username` ='$username'
			    AND `users`.`password` ='$password');

	") or die(mysqli_error());
	
	echo "test";
	if (mysqli_num_rows($res)==0){
		echo "**failed**";
	}else{
		//cookie here
		$row = mysqli_fetch_array($res, MYSQLI_ASSOC);


		$user_id = $row['user_id'];
		$fullname = $row['fullname'];
		$username = $row['username'];
		$password = $row['password'];
		$role_id = $row['role_id'];
		$role = $row['role'];
		$branch_ids = $row['branch_ids'];
		$status = $row['status'];
		$acct_mode = $row['mode'];

		if ($status=='Disabled') {
			echo "**Disabled**";

		}else{

//			echo "$mode  |  as:$is_as | ms:$is_ms";
			if ($mode=='ms' && $acct_mode<>'ms' ){
				echo "**ms**";
				mysqli_free_result($res);
				return;		
			}else if ($mode=='as' && $acct_mode<>'as'){
				echo "**as**";
				mysqli_free_result($res);
				return;		
			}else if (($mode=='is' || $mode=='' ) && ($acct_mode<>'is')){
				echo "**is**";
				mysqli_free_result($res);
				return;		
			}

			// echo "$mode  /  $role";
			// if ($mode=='ms' && $role<>'Memorial' ){
			// 	echo "**ms**";
			// 	mysqli_free_result($res);
			// 	return;		
			// }else if ($mode=='as' && $role<>'Accouting'){
			// 	echo "**as**|$role";
			// 	mysqli_free_result($res);
			// 	return;		
			// }else if (($mode=='is' || $mode=='' ) && ($role=='Accouting' || $role=='Memorial')){
			// 	echo "**is**";
			// 	mysqli_free_result($res);
			// 	return;		
			// }

		
			$timeout = 86400; // 86400 = 1 day

			setcookie('branch_ids', $branch_ids , time() + ($timeout), "/");
			setcookie('user_id', $user_id, time() + ($timeout), "/"); 
			setcookie('fullname', $fullname, time() + ($timeout), "/"); 
			setcookie('username', $username, time() + ($timeout), "/"); 
			setcookie('password', $password, time() + ($timeout), "/"); 
			setcookie('role_id', $role_id, time() + ($timeout), "/"); 
			setcookie('role', $role, time() + ($timeout), "/"); 
			setcookie('mode', $acct_mode, time() + ($timeout), "/"); 

			
			setcookie('MP_MEMBER_ENCODING', $row['MP_MEMBER_ENCODING'], time() + ($timeout), '/');
			setcookie('MP_MEMBER_DELETION', $row['MP_MEMBER_DELETION'], time() + ($timeout), '/');
			setcookie('MP_PAYMENT', $row['MP_PAYMENT'], time() + ($timeout), '/');
			setcookie('MP_MCPR_UPLOAD', $row['MP_MCPR_UPLOAD'], time() + ($timeout), '/');
			setcookie('MP_ENCODING_SUMMARY', $row['MP_ENCODING_SUMMARY'], time() + ($timeout), '/');
			setcookie('MP_APPROVAL_OF_REQUESTS', $row['MP_APPROVAL_OF_REQUESTS'], time() + ($timeout), '/');
			setcookie('MP_DECEASED_UPDATING', $row['MP_DECEASED_UPDATING'], time() + ($timeout), '/');
			setcookie('REP_AUDIT_TRAILS', $row['REP_AUDIT_TRAILS'], time() + ($timeout), '/');
			setcookie('REP_MCPR_REPORTS', $row['REP_MCPR_REPORTS'], time() + ($timeout), '/');
			setcookie('REP_MCPR_GENERATE', $row['REP_MCPR_GENERATE'], time() + ($timeout), '/');
			setcookie('REP_MCPR_DOWNLOAD', $row['REP_MCPR_DOWNLOAD'], time() + ($timeout), '/');
			setcookie('REP_MCPR_OFFLINE_DOWNLOAD', $row['REP_MCPR_OFFLINE_DOWNLOAD'], time() + ($timeout), '/');
			setcookie('REP_MCPR_DELETE', $row['REP_MCPR_DELETE'], time() + ($timeout), '/');
			setcookie('REP_PERIODIC_INCENTIVES_REPORTS', $row['REP_PERIODIC_INCENTIVES_REPORTS'], time() + ($timeout), '/');
			setcookie('REP_MANILA_REPORTS', $row['REP_MANILA_REPORTS'], time() + ($timeout), '/');
			setcookie('REP_BRANCH_REPORTS', $row['REP_BRANCH_REPORTS'], time() + ($timeout), '/');
			setcookie('REP_STATEMENT_OF_OPERATION', $row['REP_STATEMENT_OF_OPERATION'], time() + ($timeout), '/');
			setcookie('FM_AGENT_MANAGEMENT', $row['FM_AGENT_MANAGEMENT'], time() + ($timeout), '/');
			setcookie('FM_BRANCH_MANAGEMENT', $row['FM_BRANCH_MANAGEMENT'], time() + ($timeout), '/');
			setcookie('FM_PLANS', $row['FM_PLANS'], time() + ($timeout), '/');
			setcookie('FM_POLICY_FORMS', $row['FM_POLICY_FORMS'], time() + ($timeout), '/');
			setcookie('MEMORIAL_SERVICES', $row['MEMORIAL_SERVICES'], time() + ($timeout), '/');
			setcookie('ACCT_INCENTIVES_COMPUTATION', $row['ACCT_INCENTIVES_COMPUTATION'], time() + ($timeout), '/');
			setcookie('ACCT_OR_VERIFICATION', $row['ACCT_OR_VERIFICATION'], time() + ($timeout), '/');
			setcookie('ACCT_COLLECTION_SUMMARY', $row['ACCT_COLLECTION_SUMMARY'], time() + ($timeout), '/');
			setcookie('SUPPORT_TICKETS_OPEN', $row['SUPPORT_TICKETS_OPEN'], time() + ($timeout), '/');
			setcookie('SUPPORT_TICKETS_CLOSED', $row['SUPPORT_TICKETS_CLOSED'], time() + ($timeout), '/');
			setcookie('SUPPORT_USER_GUIDE', $row['SUPPORT_USER_GUIDE'], time() + ($timeout), '/');
			setcookie('SETTINGS_USER_ACCOUNTS', $row['SETTINGS_USER_ACCOUNTS'], time() + ($timeout), '/');
			setcookie('SETTINGS_ACCESS_ROLES', $row['SETTINGS_ACCESS_ROLES'], time() + ($timeout), '/');
			setcookie('SETTINGS_BACKUP_RESTOR', $row['SETTINGS_BACKUP_RESTOR'], time() + ($timeout), '/');
			setcookie('DEV_DEBUG', $row['DEV_DEBUG'], time() + ($timeout), '/');



	        $activity = "User logged-in";
	        mysqli_query($con, "INSERT INTO tbl_audittrail (`ACTIVITIES`,`CATEGORY`,`USER_ID`,`DATE`) VALUES ('$activity','LOGIN',$user_id,NOW())");  		

			echo "**success**";


		}



	}
	mysqli_free_result($res);
    include '../dbclose.php';

?>