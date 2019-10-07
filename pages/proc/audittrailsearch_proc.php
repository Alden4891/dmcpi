<?php

	$criteria = (isset($_REQUEST['criteria'])?strtolower($_REQUEST['criteria']):'');
	$category = (isset($_REQUEST['category'])?strtolower($_REQUEST['category']):'');

	include '../dbconnect.php';


	$res = mysqli_query($con, "

		SELECT
		    `tbl_audittrail`.`ID`
		    , `tbl_audittrail`.`ACTIVITIES`
		    , `tbl_audittrail`.`CATEGORY`
		    , `users`.`fullname`
		    , `tbl_audittrail`.`DATE`
		    , `branch_details`.`Branch_Name`
		FROM
		    `dmcpi1_dmcsm`.`users`
		    INNER JOIN `dmcpi1_dmcsm`.`tbl_audittrail` 
			ON (`users`.`user_id` = `tbl_audittrail`.`USER_ID`)
		    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
			ON (`branch_details`.`Branch_ID` = `users`.`branch_id`)
		WHERE  
		lcase(`tbl_audittrail`.`CATEGORY`) LIKE '%$category%' AND (lcase(`tbl_audittrail`.`ACTIVITIES`) LIKE '%$criteria%' OR  lcase(`users`.`fullname`)
		 LIKE '%$criteria%')
		ORDER BY DATE DESC
		LIMIT 0, 100 ;

	") or die(mysqli_error());
	if (mysqli_num_rows($res)==0){
		echo "**failed**";
	}else{


		$table_rows = "";

		while ($r=mysqli_fetch_array($res,MYSQLI_ASSOC)) {
			$ID=$r['ID'];
			$ACTIVITIES=$r['ACTIVITIES'];
			$CATEGORY=$r['CATEGORY'];
			$fullname=$r['fullname'];
			$DATE=$r['DATE'];
			$Branch_Name=$r['Branch_Name'];


			$row_template = "<tr><td>$ID</td><td>$ACTIVITIES</td><td>$CATEGORY</td><td>$fullname</td><td>$DATE</td></tr>";
			$table_rows.=$row_template;
		}

		echo "**success**|$table_rows";
		

	}
	mysqli_free_result($res);
    include '../dbclose.php';

?>