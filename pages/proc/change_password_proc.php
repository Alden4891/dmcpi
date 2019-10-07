<?php

    $password = (isset($_REQUEST['passowrd'])?$_REQUEST['passowrd']:'');
    $user_id = (isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'');

// 	echo "$user_id | $password";

    include '../dbconnect.php';


    mysqli_query($con, "UPDATE users SET `password` = '$password' WHERE user_id = $user_id;");
	
        
    if (mysqli_affected_rows($con)==0){
        echo "**failed**";
    }else{
        
        echo "**success**";
    }

    include '../dbclose.php';





?>