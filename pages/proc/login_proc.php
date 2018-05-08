<?php

    $username = (isset($_REQUEST['username'])?$_REQUEST['username']:'');
	$password = (isset($_REQUEST['password'])?$_REQUEST['password']:'');

	include '../dbconnect.php';
	$res = mysql_query("
			SELECT
			    `users`.`user_id`
			    , `users`.`fullname`
			    , `users`.`username`
			    , `users`.`password`
			    , `users`.`role_id`
			    , `users`.`branch_id`
			    , `branch_details`.`Branch_Name`
			    , `branch_details`.`Branch_Code`
			    , `branch_details`.`Branch_Manager`
			    , `roles`.`role`
			    , `roles`.`encoding`
			    , `roles`.`collections`
			    , `roles`.`audittrail`
			    , `roles`.`reporting`
			FROM
			    `dmcsm`.`users`
			    INNER JOIN `dmcsm`.`branch_details` 
			        ON (`users`.`branch_id` = `branch_details`.`Branch_ID`)
			    INNER JOIN `dmcsm`.`roles` 
			        ON (`roles`.`role_id` = `users`.`role_id`)
			WHERE (`users`.`username` ='$username'
			    AND `users`.`password` ='$password');
	") or die(mysql_error());
	if (mysql_num_rows($res)==0){
		echo "**failed**";
	}else{
		//cookie here
		$row = mysql_fetch_array($res, MYSQL_ASSOC);

		$user_id = $row['user_id'];
		$fullname = $row['fullname'];
		$username = $row['username'];
		$password = $row['password'];
		$role_id = $row['role_id'];
		$role = $row['role'];
		$encoding = $row['encoding'];
		$collections = $row['collections'];
		$audittrail = $row['audittrail'];
		$reporting = $row['reporting'];
		$branch = $row['Branch_Code'];

	
		$timeout = 86400; // 86400 = 1 day

		setcookie('user_id', $user_id, time() + ($timeout), "/"); 
		setcookie('fullname', $fullname, time() + ($timeout), "/"); 
		setcookie('username', $username, time() + ($timeout), "/"); 
		setcookie('password', $password, time() + ($timeout), "/"); 
		setcookie('role_id', $role_id, time() + ($timeout), "/"); 
		setcookie('role', $role, time() + ($timeout), "/"); 
		setcookie('encoding', $encoding, time() + ($timeout), "/"); 
		setcookie('collections', $collections, time() + ($timeout), "/"); 
		setcookie('audittrail', $audittrail, time() + ($timeout), "/"); 
		setcookie('reporting', $reporting, time() + ($timeout), "/"); 
		setcookie('Branch_Code', $branch , time() + ($timeout), "/"); 

		echo "**success**";
	}
	mysql_free_result($res);
    include '../dbclose.php';

?>