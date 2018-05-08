<?php

    $username = (isset($_REQUEST['username'])?$_REQUEST['username']:'');
	$password = (isset($_REQUEST['password'])?$_REQUEST['password']:'');
	$fullname = (isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'');
	$role_id = (isset($_REQUEST['role_id'])?$_REQUEST['role_id']:'');
	$branch = (isset($_REQUEST['branch'])?$_REQUEST['branch']:'');


	include '../dbconnect.php';
	$res = mysql_query("SELECT * FROM users WHERE `username`='$username';") or die(mysql_error());

	if (mysql_num_rows($res)>0){
		echo "**exists**";
	}else{
		if (mysql_query("INSERT INTO users (`fullname`,`username`,`password`,`role_id`,`branch_id`) VALUES ('$fullname','$username','$password','$role_id','$branch');") or die(mysql_error())){
			echo "**success**";
		}else{
			echo "**failed**";
		}
	}
	mysql_free_result($res);
    include '../dbclose.php';


?>