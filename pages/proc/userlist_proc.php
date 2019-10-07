<?php  
include '../dbconnect.php';

try
{

	$user_id=isset($_REQUEST['a_user_id'])?$_REQUEST['a_user_id']:'';
	$fullname=isset($_REQUEST['a_fullname'])?$_REQUEST['a_fullname']:'';
	$username=isset($_REQUEST['a_username'])?$_REQUEST['a_username']:'';
	$role_id=isset($_REQUEST['a_role_id'])?$_REQUEST['a_role_id']:'';
	$status=isset($_REQUEST['a_status'])?$_REQUEST['a_status']:'';
	$branch_id=isset($_REQUEST['a_branch_id'])?$_REQUEST['a_branch_id']:'';
	$password=isset($_REQUEST['a_password'])?$_REQUEST['a_password']:'';
	$sysmode=isset($_REQUEST['a_sysmode'])?$_REQUEST['a_sysmode']:'';

	echo "$branch_id";


	if($_REQUEST["save_mode"] == "update")
	{

		echo "

		UPDATE users
		SET fullname = '$fullname',
		    username = '$username',
		    password = '$password',
		    role_id = '$role_id',
		    branch_id = '$branch_id',
		    status = '$status',
		    mode = '$sysmode'
		WHERE user_id = $user_id

		";

		$result = mysqli_query($con,"

		UPDATE users
		SET fullname = '$fullname',
		    username = '$username',
		    password = '$password',
		    role_id = '$role_id',
		    branch_id = '$branch_id',
		    status = '$status',
		    mode = '$sysmode'
		WHERE user_id = $user_id

		");

		if (mysqli_affected_rows($con) > 0){
			
			$result = mysqli_query($con,"

                            SELECT
                              `dmcpi1_dmcsm`.`users`.`user_id`              AS `user_id`,
                              `dmcpi1_dmcsm`.`users`.`fullname`             AS `fullname`,
                              `dmcpi1_dmcsm`.`users`.`username`             AS `username`,
                              `dmcpi1_dmcsm`.`users`.`password`             AS `password`,
                              `dmcpi1_dmcsm`.`users`.`status`               AS `status`,
                              `dmcpi1_dmcsm`.`users`.`approved`             AS `approved`,
                              `dmcpi1_dmcsm`.`users`.`mode`             	AS `sysmode`,
                              `dmcpi1_dmcsm`.`branch_details`.`Branch_ID`   AS `Branch_ID`,
                              `dmcpi1_dmcsm`.`branch_details`.`Branch_Name` AS `Branch_Name`,
                              `dmcpi1_dmcsm`.`roles`.*
                            FROM ((`dmcpi1_dmcsm`.`users`
                                LEFT JOIN `dmcpi1_dmcsm`.`roles`
                                  ON ((`dmcpi1_dmcsm`.`users`.`role_id` = `dmcpi1_dmcsm`.`roles`.`role_id`)))
                               LEFT JOIN `dmcpi1_dmcsm`.`branch_details`
                                 ON ((`dmcpi1_dmcsm`.`users`.`branch_id` = `dmcpi1_dmcsm`.`branch_details`.`Branch_ID`)))
							WHERE `dmcpi1_dmcsm`.`users`.`user_id`= $user_id"

							);
			$r = mysqli_fetch_array($result);

	            $user_id = $r['user_id']; 
	            $fullname = $r['fullname']; 
	            $username = $r['username']; 
	            $branch_id = $r['Branch_ID']; 
	            $role_id = $r['role_id']; 
	            $sysmode = $r['sysmode'];
	            $role = $r['role'];
	            $approved = $r['approved'];
	            $isapproved = ($r['approved']==1?"Yes":"No");
	            $status = $r['status'];
	            $Branch_Name = $r['Branch_Name'];
            
                $row = "
                                    <tr id=row$user_id>
                                        <td class=\"even gradeC\"> $user_id</td>
                                        <td>$username</td>
                                        <td>$fullname</td>
                                        <td>$role</td>
                                        <!--td>$Branch_Name</td-->
                                        <td>$status</td>
                                        <!--td>$isapproved</td-->                                       
                                        <td>

                                            <a href=\"#\" class=\"btn btn-success btn-xs btn-circle\" id=btnuseredit data-toggle=\"modal\" data-target=\"#myModal\"

                                                user_id     =\"$user_id\"
                                                fullname    =\"$fullname\"
                                                username    =\"$username\"
                                                branch_id   =\"$branch_id\"
                                                role_id     =\"$role_id\"

                                                role        =\"$role\"
                                                approved    =\"$approved\"
                                                isapproved  =\"$isapproved\"
                                                status      =\"$status\"
                                                Branch_Name =\"$Branch_Name\"
                                                sysmode     = \"$sysmode\"
                                                password =\"$password\"
                                            >
                                            <i class=\"glyphicon glyphicon-edit\"></i></a>



                                            <a href=\"#\" 
                                            user_id=$user_id
                                            id=btnuserdelete 
                                            class=\"btn btn-danger btn-xs btn-circle disabled\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                                        </td>
                                </tr>

                ";



			echo "**success**|".$row;

		}else{
			echo "**noChanges**";
		}
	}
	
	else if($_REQUEST["save_mode"] == "insert")
	{
		//check if user exists
		$result = mysqli_query($con,"SELECT count(*) as userCount FROM vUserRoles WHERE username = '$username';");
		$data 	= mysqli_fetch_row($result);
		echo $data[0];
		if ($data[0] > 0) {
			echo "**exists**";
			return;
		}

		
		
		//Insert record into database
		$result = mysqli_query($con,"
			INSERT INTO users (fullname, username, password, role_id, branch_id, approved, status,mode)
  			VALUES ('$fullname', '$username', '$password', '$role_id', '$branch_id', '0', '$status','$sysmode');
		");


		if (mysqli_affected_rows($con) > 0){
			
			$result = mysqli_query($con,"SELECT * FROM vUserRoles WHERE user_id= LAST_INSERT_ID()");
			$r = mysqli_fetch_array($result);

	            $user_id = $r['user_id']; 
	            $fullname = $r['fullname']; 
	            $username = $r['username']; 
	            $branch_id = $r['Branch_ID']; 
	            $role_id = $r['role_id']; 
	            $sysmode = $r['sysmode'];
	            
	            $role = $r['role'];
	            $approved = $r['approved'];
	            $isapproved = ($r['approved']==1?"Yes":"No");
	            $status = $r['status'];
	            $Branch_Name = $r['Branch_Name'];
            
                $row = "
                    <tr id=row$user_id>
                        <td class=\"even gradeC\"> $user_id</td>
                        <td>$username</td>
                        <td>$fullname</td>
                        <td>$role</td>
                        <td>$Branch_Name</td>
                        <td>$status</td>
                        <td>$isapproved</td>                                       
                        <td>

                            <a href=\"#\" class=\"btn btn-success btn-circle\" id=btnuseredit data-toggle=\"modal\" data-target=\"#myModal\"

                                user_id     =\"$user_id\"
                                fullname    =\"$fullname\"
                                username    =\"$username\"
                                branch_id   =\"$branch_id\"
                                role_id     =\"$role_id\"
                                sysmode     = \"$sysmode\"

                                role        =\"$role\"
                                approved    =\"$approved\"
                                isapproved  =\"$isapproved\"
                                status      =\"$status\"
                                Branch_Name =\"$Branch_Name\"

                                password =\"$password\"

                            >
                            <i class=\"glyphicon glyphicon-edit\"></i></a>



                            <a href=\"#\" 
                            user_id=$user_id
                            id=btnuserdelete 
                            class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                        </td>
                </tr>

                ";

			echo "**success**|".$row;


		}else{
			echo "**failed**";
		}



		
	}

	else if($_GET["save_mode"] == "delete")
	{

		$result = mysqli_query($con,"DELETE FROM users WHERE user_id = $user_id;");
		if (mysqli_affected_rows($con) > 0){
			echo "**success**";
		}else{
			echo "**failed**";
		}

	}

	//Close database connection
	mysqli_close($con);

}
catch(Exception $ex)
{
	echo "**failed**";
}
	
?>