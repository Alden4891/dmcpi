<?php  

include '../dbconnect.php';



try

{



	$Branch_ID=isset($_REQUEST['Branch_ID'])?$_REQUEST['Branch_ID']:'';

	$Branch_Name=isset($_REQUEST['Branch_Name'])?$_REQUEST['Branch_Name']:'';

	//$Branch_Code=isset($_REQUEST['Branch_Code'])?$_REQUEST['Branch_Code']:'';

	$Branch_Manager=isset($_REQUEST['Branch_Manager'])?$_REQUEST['Branch_Manager']:'';

	$mainoffice=isset($_REQUEST['mainoffice'])?$_REQUEST['mainoffice']:'';



	if($_REQUEST["save_mode"] == "update")

	{



		$result = mysqli_query($con,"

		UPDATE branch_details

		SET 

		    Branch_Name = '$Branch_Name',

		    Branch_Manager = '$Branch_Manager',

		    mainoffice = '$mainoffice'

		WHERE Branch_ID = $Branch_ID;

			");



		if (mysqli_affected_rows($con) > 0){

			

			$result = mysqli_query($con,"

	            SELECT

	                `branch_details`.`Branch_ID`

	                , `branch_details`.`Branch_Name`

	                , CONCAT(LEFT(BRANCH_NAME,1),Branch_ID) AS Branch_Code

	                , `branch_details`.`Branch_Manager`

	                , `branch_details`.`mainoffice`

	                , COUNT(`members_account`.`Member_Code`) AS `No_of_clients`

	            FROM

	                `dmcpi1_dmcsm`.`members_account`

	                RIGHT JOIN `dmcpi1_dmcsm`.`branch_details` 

	                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)

	            GROUP BY `branch_details`.`Branch_ID`, `branch_details`.`Branch_Name`,`branch_details`.`Branch_Manager`, `branch_details`.`mainoffice`

	            HAVING `branch_details`.`Branch_ID` = $Branch_ID

	            ORDER BY `branch_details`.`Branch_Name` ASC



			");

			$r = mysqli_fetch_array($result);



            $Branch_ID = $r['Branch_ID']; 

            $Branch_Name = $r['Branch_Name']; 

            $Branch_Code = $r['Branch_Code']; 

            $Branch_Manager = $r['Branch_Manager']; 

            $mainoffice = $r['mainoffice']; 

            $No_of_clients = $r['No_of_clients'];



            $row = "

                <tr id=row$Branch_ID>

                    <td class=\"even gradeC\"> $Branch_Code</td>

                    <td>$Branch_Name</td>

                    <td>$Branch_Manager</td>

                    <td>".($mainoffice==0?"Branch office":"Main Office")."</td>

                    <td>$No_of_clients</td>

                    <td>

                        <a href=\"#\" class=\"btn btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"

                            Branch_ID =\"$Branch_ID\"

                            Branch_Name =\"$Branch_Name\"

                            Branch_Code =\"$Branch_Code\"

                            Branch_Manager =\"$Branch_Manager\"

                            mainoffice =\"$mainoffice\"

                            No_of_clients =\"$No_of_clients\"



                        >



                        <i class=\"glyphicon glyphicon-edit\"></i></a>

                        <a href=\"#\" 

                        Branch_ID=$Branch_ID

                        No_of_clients=\"$No_of_clients\" 

                        id=btnbranchdelete 

                        class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>



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

		//Insert record into database

		$result = mysqli_query($con,"



			INSERT INTO branch_details (

			`Branch_Name`, 

			`Branch_Manager`, 

			`mainoffice`

			)

	  		VALUES (

	  		'$Branch_Name', 

	  		'$Branch_Manager', 

	  		'$mainoffice'

	  		);



		");





		if (mysqli_affected_rows($con) > 0){





			$result = mysqli_query($con,"

	            SELECT

	                `branch_details`.`Branch_ID`

	                , `branch_details`.`Branch_Name`

	                , CONCAT(LEFT(BRANCH_NAME,1),Branch_ID) AS Branch_Code

	                , `branch_details`.`Branch_Manager`

	                , `branch_details`.`mainoffice`

	                , COUNT(`members_account`.`Member_Code`) AS `No_of_clients`

	            FROM

	                `dmcpi1_dmcsm`.`members_account`

	                RIGHT JOIN `dmcpi1_dmcsm`.`branch_details` 

	                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)

	            GROUP BY `branch_details`.`Branch_ID`, `branch_details`.`Branch_Name`,  `branch_details`.`Branch_Manager`, `branch_details`.`mainoffice`

	            HAVING `branch_details`.`Branch_ID` = LAST_INSERT_ID()

	            ORDER BY `branch_details`.`Branch_Name` ASC



			");

			$r = mysqli_fetch_array($result);



            $Branch_ID = $r['Branch_ID']; 

            $Branch_Name = $r['Branch_Name']; 

            $Branch_Code = $r['Branch_Code']; 

            $Branch_Manager = $r['Branch_Manager']; 

            $mainoffice = $r['mainoffice']; 

            $No_of_clients = $r['No_of_clients'];



            $row = "

                <tr id=row$Branch_ID>

                    <td class=\"even gradeC\"> $Branch_Code</td>

                    <td>$Branch_Name</td>

                    <td>$Branch_Manager</td>

                    <td>".($mainoffice==0?"Branch office":"Main Office")."</td>

                    <td>$No_of_clients</td>

                    <td>

                        <a href=\"#\" class=\"btn btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"

                            Branch_ID =\"$Branch_ID\"

                            Branch_Name =\"$Branch_Name\"

                            Branch_Code =\"$Branch_Code\"

                            Branch_Manager =\"$Branch_Manager\"

                            mainoffice =\"$mainoffice\"

                            No_of_clients =\"$No_of_clients\"



                        >



                        <i class=\"glyphicon glyphicon-edit\"></i></a>

                        <a href=\"#\" 

                        Branch_ID=$Branch_ID

                        No_of_clients=\"$No_of_clients\" 

                        id=btnbranchdelete 

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



		$result = mysqli_query($con,"DELETE FROM `dmcpi1_dmcsm`.`branch_details` WHERE Branch_ID=$Branch_ID;");

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