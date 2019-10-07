<?php



/*
Array
(
    [data] => ids%5B%5D=1&ids%5B%5D=3
    [role_id] => 2
    [fullname] => 3123
    [username] => 123
    [password] => 123123123
)

*/


	

	$selected_mode = (isset($_REQUEST['selected_mode'])?$_REQUEST['selected_mode']:'');
    $username = (isset($_REQUEST['username'])?$_REQUEST['username']:'');
	$password = (isset($_REQUEST['password'])?$_REQUEST['password']:'');
	$fullname = (isset($_REQUEST['fullname'])?$_REQUEST['fullname']:'');
	$role_id = (isset($_REQUEST['role_id'])?$_REQUEST['role_id']:'');

//	$branch = (isset($_REQUEST['branch'])?$_REQUEST['branch']:'');

	$csv_branches="";
	$branches = (isset($_REQUEST['data'])?$_REQUEST['data']:'');
	$branches = explode('&', $branches);

	foreach ($branches as $key => $branch) {
		$branch_id = explode("=", $branch)[1];
		$csv_branches.="$branch_id,";
	}
	$csv_branches.="-1";
//	echo "$csv_branches";

	include '../dbconnect.php';
	$res = mysqli_query($con, "SELECT * FROM users WHERE `username`='$username';") or die(mysqli_error());

	if (mysqli_num_rows($res)>0){
		echo "**exists**";
	}else{
		if (mysqli_query($con, "INSERT INTO users (`fullname`,`username`,`password`,`role_id`,`branch_id`,`branch_ids`,`mode`) 
			VALUES ('$fullname','$username','$password','$role_id','-1','$csv_branches','$selected_mode');") or die(mysqli_error())){
			echo "**success**";
		}else{
			echo "**failed**";
		}
	}
	mysqli_free_result($res);
    include '../dbclose.php';


?>