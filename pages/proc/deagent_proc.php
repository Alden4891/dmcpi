<?php  

include '../dbconnect.php';
$success = 0;
try
{
	$agent_id=isset($_REQUEST['agent_id'])?$_REQUEST['agent_id']:'';
	$agent_fname=isset($_REQUEST['agent_fname'])?$_REQUEST['agent_fname']:'';
	$agent_mname=isset($_REQUEST['agent_mname'])?$_REQUEST['agent_mname']:'';
	$agent_lname=isset($_REQUEST['agent_lname'])?$_REQUEST['agent_lname']:'';
	$agent_initials=isset($_REQUEST['agent_initials'])?$_REQUEST['agent_initials']:'';
	
	$agent_dob	=isset($_REQUEST['$agent_dob'])?$_REQUEST['$agent_dob']:'';
	$agent_age=isset($_REQUEST['agent_age'])?$_REQUEST['agent_age']:'';
	$agent_sex	=isset($_REQUEST['agent_sex'])?$_REQUEST['agent_sex']:'';
	$agent_mstatus	=isset($_REQUEST['agent_mstatus'])?$_REQUEST['agent_mstatus']:'';
	$agent_contact	=isset($_REQUEST['agent_contact'])?$_REQUEST['agent_contact']:'';

	$agent_street	=isset($_REQUEST['agent_street'])?$_REQUEST['agent_street']:'';
	$agent_barangay	=isset($_REQUEST['agent_barangay'])?$_REQUEST['agent_barangay']:'';
	$agent_city	=isset($_REQUEST['agent_city'])?$_REQUEST['agent_city']:'';
	$agent_province	=isset($_REQUEST['agent_province'])?$_REQUEST['agent_province']:'';
	$agent_type	=isset($_REQUEST['agent_type'])?$_REQUEST['agent_type']:'';
    $branch=isset($_REQUEST['branch'])?$_REQUEST['branch']:'';

    $agent_referrer = isset($_REQUEST['agent_referrer'])?$_REQUEST['agent_referrer']:'';

    $referrer_id="";
    $referrer_type="";
    echo "agent_referrer: $agent_referrer";
    if ($agent_referrer!='' && $agent_referrer!='-1') {
        $referrer = explode("|", $agent_referrer);
        $referrer_id = $referrer[0]; 
        $referrer_type = $referrer[1];
    }



	if($_REQUEST["save_mode"] == "update")
	{

		$result = mysqli_query($con,"
		UPDATE agent_profile
		SET 
		    First_name = '$agent_fname',
		    Middle_Name = '$agent_mname',
		    Last_name = '$agent_lname',
		    Initials = '$agent_initials',
		    Birth_Date = '$agent_dob',
		    Contact_No = '$agent_contact',
		    Street = '$agent_street',
		    Barangay = '$agent_barangay',
		    City = '$agent_city',
		    Province = '$agent_province',
		    `type` = '$agent_type',
		    `Sex` = '$agent_sex',
            `referrer_id`='$referrer_id',
            `referrer_type`='$referrer_type'
		WHERE AgentID = $agent_id;
			");

        $affected1 = mysqli_affected_rows($con);
        $affected2 = branchagents_update($agent_id,$branch,$con);

		if ($affected1+$affected2 > 0){
			
			$result = mysqli_query($con,"
                            SELECT
                                  `agent_profile`.`AgentID`
                                , `agent_profile`.`First_name`
                                , `agent_profile`.`Middle_Name`
                                , `agent_profile`.`Last_name`
                                , `agent_profile`.`Initials`
                                , `agent_profile`.`Birth_Date`
                                , `agent_profile`.`Age`
                                , `agent_profile`.`Sex`
                                , `agent_profile`.`Status`
                                , `agent_profile`.`Contact_No`
                                , `agent_profile`.`Street`
                                , `agent_profile`.`Barangay`
                                , `agent_profile`.`City`
                                , `agent_profile`.`Province`
                                , `agent_profile`.`type` AS `agent_type`
                                , COUNT(`members_account`.`Member_Code`) AS `No_of_clients`
                                , `branch_details`.`Branch_Manager`
                                , `branch_details`.`mainoffice`
                                , CONCAT(referrer_id,'|',referrer_type) AS referrer

                            FROM
                                `dmcpi1_dmcsm`.`agent_profile`
                                LEFT JOIN `dmcpi1_dmcsm`.`members_account` 
                                    ON (`agent_profile`.`AgentID` = `members_account`.`AgentID`)
                                LEFT JOIN `dmcpi1_dmcsm`.`branch_details` 
                                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                            WHERE `agent_profile`.`AgentID` = $agent_id
                            GROUP BY `agent_profile`.`Initials`, `agent_profile`.`First_name`, `agent_profile`.`Middle_Name`, `agent_profile`.`Last_name`, `agent_profile`.`Sex`, `agent_profile`.`TYPE`
                            ORDER BY  `agent_profile`.`Last_name`, `agent_profile`.`First_name`
			");
			
            $r = mysqli_fetch_array($result, MYSQLI_ASSOC);
                                $AgentID = $r['AgentID']; 
                                $First_name = $r['First_name']; 
                                $Middle_Name = $r['Middle_Name']; 
                                $Last_name = $r['Last_name']; 
                                $Initials = $r['Initials']; 
                                $fullname = "$Last_name, $First_name $Middle_Name";
                                $Birth_Date = $r['Birth_Date'];
                                $Age = $r['Age'];
                                $Sex = $r['Sex'];
                                $Status = $r['Status'];
                                $Contact_No = $r['Contact_No'];
                                $Street     = $r['Street'];
                                $Barangay    = $r['Barangay'];
                                $City    = $r['City'];
                                $Province    = $r['Province'];
                                $agent_type   = $r['agent_type'];
                                $No_of_clients  = $r['No_of_clients'];
                                $Branch_Manager   = $r['Branch_Manager'];
                                $mainoffice = $r['mainoffice'];
                                $referrer=$r['referrer'];

                                $row = "
                                    <tr id=row$AgentID>
                                        <td class=\"even gradeC\"> $AgentID</td>
                                        <td>$fullname</td>
                                        <td>$Initials</td>
                                        <td>$Sex</td>
                                        <td>$Contact_No</td>
                                        <td>$City</td>
                                        <td>$agent_type</td>
                                        <td>$Branch_Manager</td>

                                        <td>
                                            <a href=\"#\" class=\"btn btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"myModal\"
                                                agent_id    =\"$AgentID\"
                                                agent_fname =\"$First_name\"
                                                agent_mname =\"$Middle_Name\"
                                                agent_lname =\"$Last_name\"
                                                agent_initials =\"$Initials\"                                               
                                                agent_dob =\"$Birth_Date\"
                                                agent_age    =\"$Age\"
                                                agent_sex =\"$Sex\"
                                                agent_mstatus =\"$Status\"
                                                agent_contact =\"$Contact_No\"
                                                agent_street     =\"$Street\"
                                                agent_barangay    =\"$Barangay\"
                                                agent_city    =\"$City\"
                                                agent_province    =\"$Province\"
                                                type   =\"$agent_type\"
                                                No_of_clients  =\"$No_of_clients\"
                                                Branch_Manager   =\"$Branch_Manager\"
                                                mainoffice = \"$mainoffice\"
                                                referrer = \"$referrer\"
                                            >

                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
                                            <a href=\"#\" 
                                            AgentID=$AgentID
                                            No_of_clients=\"$No_of_clients\" 
                                            id=btnagentdelete 
                                            class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>
                                        </td>
                                </tr>
                                ";

			echo "**success**|".$row;
            $success=1;

		}else{
			echo "**noChanges**";
		}
		
	}
	
	else if($_REQUEST["save_mode"] == "insert")
	{
		//Insert record into database
		$result = mysqli_query($con,"

		INSERT INTO agent_profile (
		`First_name`, 
		`Last_name`, 
		`Sex`, 
		`Contact_No`, 
		`Street`, 
		`Barangay`, 
		`City`,
		`Province`, 
		`Initials`, 
		`type`, 
		`Middle_Name`, 
		`Birth_Date`,
		`Status`,
        `referrer_id`,
        `referrer_type`
		)
  		VALUES (
  		'$agent_fname', 
  		'$agent_lname', 
  		'$agent_sex', 
  		'$agent_contact', 
  		'$agent_street', 
  		'$agent_barangay', 
  		'$agent_city', 
  		'$agent_province', 
  		'$agent_initials', 
  		'$agent_type', 
  		'$agent_mname', 
  		'$agent_dob',
  		'$agent_mstatus',
        '$referrer_id',
        '$referrer_type'

  		);


		");


        $affected1 = mysqli_affected_rows($con);
        $affected2 = branchagents_update($agent_id,$branch,$con);
 

		if ($affected1+$affected2 > 0){
			//Get last inserted record (to return to Table)
			//$result = mysqli_query($con,"SELECT * FROM agent_profile WHERE AgentID = LAST_INSERT_ID();");

            $result = mysqli_query($con,"
                            SELECT
                                  `agent_profile`.`AgentID`
                                , `agent_profile`.`First_name`
                                , `agent_profile`.`Middle_Name`
                                , `agent_profile`.`Last_name`
                                , `agent_profile`.`Initials`
                                , `agent_profile`.`Birth_Date`
                                , `agent_profile`.`Age`
                                , `agent_profile`.`Sex`
                                , `agent_profile`.`Status`
                                , `agent_profile`.`Contact_No`
                                , `agent_profile`.`Street`
                                , `agent_profile`.`Barangay`
                                , `agent_profile`.`City`
                                , `agent_profile`.`Province`
                                , `agent_profile`.`type` as `agent_type`
                                , COUNT(`members_account`.`Member_Code`) AS `No_of_clients`
                                , `branch_details`.`Branch_Manager`
                                , `branch_details`.`mainoffice`
                                , CONCAT(referrer_id,'|',referrer_type) AS referrer
                            FROM
                                `dmcpi1_dmcsm`.`agent_profile`
                                LEFT JOIN `dmcpi1_dmcsm`.`members_account` 
                                    ON (`agent_profile`.`AgentID` = `members_account`.`AgentID`)
                                LEFT JOIN `dmcpi1_dmcsm`.`branch_details` 
                                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                            WHERE `agent_profile`.`AgentID` = LAST_INSERT_ID()
                            GROUP BY `agent_profile`.`Initials`, `agent_profile`.`First_name`, `agent_profile`.`Middle_Name`, `agent_profile`.`Last_name`, `agent_profile`.`Sex`, `agent_profile`.`type`
                            ORDER BY  `agent_profile`.`Last_name`, `agent_profile`.`First_name`
            ");
            $r = mysqli_fetch_array($result);
                                $AgentID = $r['AgentID']; 
                                $First_name = $r['First_name']; 
                                $Middle_Name = $r['Middle_Name']; 
                                $Last_name = $r['Last_name']; 
                                $Initials = $r['Initials']; 
                                $fullname = "$Last_name, $First_name $Middle_Name";
                                $Birth_Date = $r['Birth_Date'];
                                $Age = $r['Age'];
                                $Sex = $r['Sex'];
                                $Status = $r['Status'];
                                $Contact_No = $r['Contact_No'];
                                $Street     = $r['Street'];
                                $Barangay    = $r['Barangay'];
                                $City    = $r['City'];
                                $Province    = $r['Province'];
                                $agent_type   = $r['agent_type'];
                                $No_of_clients  = $r['No_of_clients'];
                                $Branch_Manager   = $r['Branch_Manager'];
                                $mainoffice = $r['mainoffice'];
                                $referrer=$r['referrer'];

                                $row = "
                                    <tr id=row$AgentID>
                                        <td class=\"even gradeC\"> $AgentID</td>
                                        <td>$fullname</td>
                                        <td>$Initials</td>
                                        <td>$Sex</td>
                                        <td>$Contact_No</td>
                                        <td>$City</td>
                                        <td>$agent_type</td>
                                        <td>$Branch_Manager</td>

                                        <td>
                                            <a href=\"#\" class=\"btn btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"
                                                agent_id     =\"$AgentID\"
                                                agent_fname =\"$First_name\"
                                                agent_mname =\"$Middle_Name\"
                                                agent_lname =\"$Last_name\"
                                                agent_initials =\"$Initials\"                                               
                                                agent_dob =\"$Birth_Date\"
                                                agent_age    =\"$Age\"
                                                agent_sex =\"$Sex\"
                                                agent_mstatus =\"$Status\"
                                                agent_contact =\"$Contact_No\"
                                                agent_street     =\"$Street\"
                                                agent_barangay    =\"$Barangay\"
                                                agent_city    =\"$City\"
                                                agent_province    =\"$Province\"
                                                type   =\"$agent_type\"
                                                No_of_clients  =\"$No_of_clients\"
                                                Branch_Manager   =\"$Branch_Manager\"
                                                mainoffice = \"$mainoffice\"
                                                referrer = \"$referrer\"
                                            >

                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
                                            <a href=\"#\" 
                                            AgentID=$AgentID
                                            No_of_clients=\"$No_of_clients\" 
                                            id=btnagentdelete 
                                            class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>
                                        </td>
                                </tr>
                                ";



            echo "**success**|".$row;
            $success=1;
		}else{
			echo "**failed**";
		}
 
	}
	else if($_GET["save_mode"] == "delete")
	{

		$result = mysqli_query($con,"DELETE FROM agent_profile WHERE `AgentID`='$agent_id';");
		$affected= mysqli_affected_rows($con);
		mysqli_query($con,"DELETE FROM tbl_branchagents WHERE `AgentID`='$agent_id';");

		if ($affected > 0){
            $success=1;
			echo "**success** - $affected";
		}else{
			echo "**failed** - $affected";
		}

	}

    //try to update tbl_branchagents
/*
    if ( $success==1 && ($_REQUEST["mode"] == "insert" || $_REQUEST["mode"] == "update" )){
        branchagents_update();
    }
*/

	//Close database connection
	mysqli_close($con);

}
catch(Exception $ex)
{
	echo "**failed**";
}
	
function branchagents_update($param1,$param2,$param3){
        mysqli_query($param3,"DELETE FROM tbl_branchagents WHERE `AgentID`='$param1';");
        mysqli_query($param3,"INSERT INTO tbl_branchagents (`Branch_ID`,`AgentID`) VALUES ('$param2','$param1');"); 
        return mysqli_affected_rows($param3);   
}

?>


