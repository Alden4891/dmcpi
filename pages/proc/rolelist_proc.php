<?php  
include '../dbconnect.php';

try
{

	$PermissionString = "MP_MEMBER_ENCODING,MP_MEMBER_DELETION,MP_PAYMENT,MP_MCPR_UPLOAD,MP_ENCODING_SUMMARY,MP_APPROVAL_OF_REQUESTS,MP_DECEASED_UPDATING,REP_AUDIT_TRAILS,REP_MCPR_REPORTS,REP_MCPR_GENERATE,REP_MCPR_DOWNLOAD,REP_MCPR_OFFLINE_DOWNLOAD,REP_MCPR_DELETE,REP_PERIODIC_INCENTIVES_REPORTS,REP_MANILA_REPORTS,REP_BRANCH_REPORTS,REP_STATEMENT_OF_OPERATION,FM_AGENT_MANAGEMENT,FM_BRANCH_MANAGEMENT,FM_PLANS,FM_POLICY_FORMS,MEMORIAL_SERVICES,ACCT_INCENTIVES_COMPUTATION,ACCT_OR_VERIFICATION,ACCT_COLLECTION_SUMMARY,SUPPORT_TICKETS_OPEN,SUPPORT_TICKETS_CLOSED,SUPPORT_USER_GUIDE,SETTINGS_USER_ACCOUNTS,SETTINGS_ACCESS_ROLES,SETTINGS_BACKUP_RESTOR";

	$ROLE_ID=isset($_REQUEST['ROLE_ID'])?$_REQUEST['ROLE_ID']:'';
	$ROLE=isset($_REQUEST['ROLE'])?$_REQUEST['ROLE']:'';
	$DESCRIPTION=isset($_REQUEST['DESCRIPTION'])?$_REQUEST['DESCRIPTION']:'';
	$selected=isset($_REQUEST['selected'])?$_REQUEST['selected']:'';

	$arrPerm = explode(",", $PermissionString);
	$arrSelectedPerm = explode(",", $selected);


	if($_REQUEST["save_mode"] == "update")
	{
		$update_values = "`role`='$ROLE',`desciption`='$DESCRIPTION',";
		foreach ($arrPerm as $key => $value) {
			if (in_array($value, $arrSelectedPerm)) {
			    $update_values.="`$value` = 1,";
			}else{
			    $update_values.="`$value` = 0,";
			}		    
		}
		$update_values = substr_replace($update_values, "", -1);

		$result = mysqli_query($con,"UPDATE roles set $update_values WHERE role_id=$ROLE_ID;");

		if (mysqli_affected_rows($con) > 0){
			
			$result = mysqli_query($con,"

                        SELECT
                            `roles`.`role_id` AS 'ROLE_ID'
                            , `roles`.`role` AS 'ROLE'
                            , `roles`.`desciption` AS 'DESCRIPTION'
                            , `roles`.`MP_MEMBER_ENCODING`
                            , `roles`.`MP_MEMBER_DELETION`
                            , `roles`.`MP_PAYMENT`
                            , `roles`.`MP_MCPR_UPLOAD`
                            , `roles`.`MP_ENCODING_SUMMARY`
                            , `roles`.`MP_APPROVAL_OF_REQUESTS`
                            , `roles`.`MP_DECEASED_UPDATING`
                            , `roles`.`REP_AUDIT_TRAILS`
                            , `roles`.`REP_MCPR_REPORTS`
                            , `roles`.`REP_MCPR_GENERATE`
                            , `roles`.`REP_MCPR_DOWNLOAD`
                            , `roles`.`REP_MCPR_OFFLINE_DOWNLOAD`
                            , `roles`.`REP_MCPR_DELETE`
                            , `roles`.`REP_PERIODIC_INCENTIVES_REPORTS`
                            , `roles`.`REP_MANILA_REPORTS`
                            , `roles`.`REP_BRANCH_REPORTS`
                            , `roles`.`REP_STATEMENT_OF_OPERATION`
                            , `roles`.`FM_AGENT_MANAGEMENT`
                            , `roles`.`FM_BRANCH_MANAGEMENT`
                            , `roles`.`FM_PLANS`
                            , `roles`.`FM_POLICY_FORMS`
                            , `roles`.`MEMORIAL_SERVICES`
                            , `roles`.`ACCT_INCENTIVES_COMPUTATION`
                            , `roles`.`ACCT_OR_VERIFICATION`
                            , `roles`.`ACCT_COLLECTION_SUMMARY`
                            , `roles`.`SUPPORT_TICKETS_OPEN`
                            , `roles`.`SUPPORT_TICKETS_CLOSED`
                            , `roles`.`SUPPORT_USER_GUIDE`
                            , `roles`.`SETTINGS_USER_ACCOUNTS`
                            , `roles`.`SETTINGS_ACCESS_ROLES`
                            , `roles`.`SETTINGS_BACKUP_RESTOR`
                            , `roles`.`DEV_DEBUG`
                            , SUM(`users`.`user_id`) AS `USER_COUNT`
                        FROM
                            `dmcpi1_dmcsm`.`users`
                            INNER JOIN `dmcpi1_dmcsm`.`roles` 
                                ON (`users`.`role_id` = `roles`.`role_id`)
                        GROUP BY `roles`.`role_id`, `roles`.`role`, `roles`.`desciption`, `roles`.`MP_MEMBER_ENCODING`, `roles`.`MP_MEMBER_DELETION`, `roles`.`MP_PAYMENT`, `roles`.`MP_MCPR_UPLOAD`, `roles`.`MP_ENCODING_SUMMARY`, `roles`.`MP_APPROVAL_OF_REQUESTS`, `roles`.`MP_DECEASED_UPDATING`, `roles`.`REP_AUDIT_TRAILS`, `roles`.`REP_MCPR_REPORTS`, `roles`.`REP_MCPR_GENERATE`, `roles`.`REP_MCPR_DOWNLOAD`, `roles`.`REP_MCPR_OFFLINE_DOWNLOAD`, `roles`.`REP_MCPR_DELETE`, `roles`.`REP_PERIODIC_INCENTIVES_REPORTS`, `roles`.`REP_MANILA_REPORTS`, `roles`.`REP_BRANCH_REPORTS`, `roles`.`REP_STATEMENT_OF_OPERATION`, `roles`.`FM_AGENT_MANAGEMENT`, `roles`.`FM_BRANCH_MANAGEMENT`, `roles`.`FM_PLANS`, `roles`.`FM_POLICY_FORMS`, `roles`.`MEMORIAL_SERVICES`, `roles`.`ACCT_INCENTIVES_COMPUTATION`, `roles`.`ACCT_OR_VERIFICATION`, `roles`.`ACCT_COLLECTION_SUMMARY`, `roles`.`SUPPORT_TICKETS_OPEN`, `roles`.`SUPPORT_TICKETS_CLOSED`, `roles`.`SUPPORT_USER_GUIDE`, `roles`.`SETTINGS_USER_ACCOUNTS`, `roles`.`SETTINGS_ACCESS_ROLES`, `roles`.`SETTINGS_BACKUP_RESTOR`, `roles`.`DEV_DEBUG`
                        HAVING `roles`.`role_id` = $ROLE_ID;

                        ");
			$r = mysqli_fetch_array($result);

            $ROLE_ID = $r['ROLE_ID']; 
            $ROLE = $r['ROLE']; 
            $DESCRIPTION = $r['DESCRIPTION']; 

            $MP_MEMBER_ENCODING=$r['MP_MEMBER_ENCODING'];
            $MP_MEMBER_DELETION=$r['MP_MEMBER_DELETION'];
            $MP_PAYMENT=$r['MP_PAYMENT'];
            $MP_MCPR_UPLOAD=$r['MP_MCPR_UPLOAD'];
            $MP_ENCODING_SUMMARY=$r['MP_ENCODING_SUMMARY'];
            $MP_APPROVAL_OF_REQUESTS=$r['MP_APPROVAL_OF_REQUESTS'];
            $MP_DECEASED_UPDATING=$r['MP_DECEASED_UPDATING'];
            $REP_AUDIT_TRAILS=$r['REP_AUDIT_TRAILS'];
            $REP_MCPR_REPORTS=$r['REP_MCPR_REPORTS'];
            $REP_MCPR_GENERATE=$r['REP_MCPR_GENERATE'];
            $REP_MCPR_DOWNLOAD=$r['REP_MCPR_DOWNLOAD'];
            $REP_MCPR_OFFLINE_DOWNLOAD=$r['REP_MCPR_OFFLINE_DOWNLOAD'];
            $REP_MCPR_DELETE=$r['REP_MCPR_DELETE'];
            $REP_PERIODIC_INCENTIVES_REPORTS=$r['REP_PERIODIC_INCENTIVES_REPORTS'];
            $REP_MANILA_REPORTS=$r['REP_MANILA_REPORTS'];
            $REP_BRANCH_REPORTS=$r['REP_BRANCH_REPORTS'];
            $REP_STATEMENT_OF_OPERATION=$r['REP_STATEMENT_OF_OPERATION'];
            $FM_AGENT_MANAGEMENT=$r['FM_AGENT_MANAGEMENT'];
            $FM_BRANCH_MANAGEMENT=$r['FM_BRANCH_MANAGEMENT'];
            $FM_PLANS=$r['FM_PLANS'];
            $FM_POLICY_FORMS=$r['FM_POLICY_FORMS'];
            $MEMORIAL_SERVICES=$r['MEMORIAL_SERVICES'];
            $ACCT_INCENTIVES_COMPUTATION=$r['ACCT_INCENTIVES_COMPUTATION'];
            $ACCT_OR_VERIFICATION=$r['ACCT_OR_VERIFICATION'];
            $ACCT_COLLECTION_SUMMARY=$r['ACCT_COLLECTION_SUMMARY'];
            $SUPPORT_TICKETS_OPEN=$r['SUPPORT_TICKETS_OPEN'];
            $SUPPORT_TICKETS_CLOSED=$r['SUPPORT_TICKETS_CLOSED'];
            $SUPPORT_USER_GUIDE=$r['SUPPORT_USER_GUIDE'];
            $SETTINGS_USER_ACCOUNTS=$r['SETTINGS_USER_ACCOUNTS'];
            $SETTINGS_ACCESS_ROLES=$r['SETTINGS_ACCESS_ROLES'];
            $SETTINGS_BACKUP_RESTOR=$r['SETTINGS_BACKUP_RESTOR'];
            $DEV_DEBUG=$r['DEV_DEBUG'];

            $USER_COUNT = $r['USER_COUNT'];  

            
                $row = "
                                    <tr id=row$ROLE_ID>
                                        <td class=\"even gradeC\"> $ROLE_ID</td>
                                        <td>$ROLE</td>
                                        <td>$DESCRIPTION</td>
                                        <td>

                                            <a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnuseredit data-toggle=\"modal\" data-target=\"#myModal\"

                                                ROLE_ID     =\"$ROLE_ID\"
                                                ROLE    =\"$ROLE\"
                                                DESCRIPTION    =\"$DESCRIPTION\"

                                                MP_MEMBER_ENCODING=\"$MP_MEMBER_ENCODING\"
                                                MP_MEMBER_DELETION=\"$MP_MEMBER_DELETION\"
                                                MP_PAYMENT=\"$MP_PAYMENT\"
                                                MP_MCPR_UPLOAD=\"$MP_MCPR_UPLOAD\"
                                                MP_ENCODING_SUMMARY=\"$MP_ENCODING_SUMMARY\"
                                                MP_APPROVAL_OF_REQUESTS=\"$MP_APPROVAL_OF_REQUESTS\"
                                                MP_DECEASED_UPDATING=\"$MP_DECEASED_UPDATING\"
                                                REP_AUDIT_TRAILS=\"$REP_AUDIT_TRAILS\"
                                                REP_MCPR_REPORTS=\"$REP_MCPR_REPORTS\"
                                                REP_MCPR_GENERATE=\"$REP_MCPR_GENERATE\"
                                                REP_MCPR_DOWNLOAD=\"$REP_MCPR_DOWNLOAD\"
                                                REP_MCPR_OFFLINE_DOWNLOAD=\"$REP_MCPR_OFFLINE_DOWNLOAD\"
                                                REP_MCPR_DELETE=\"$REP_MCPR_DELETE\"
                                                REP_PERIODIC_INCENTIVES_REPORTS=\"$REP_PERIODIC_INCENTIVES_REPORTS\"
                                                REP_MANILA_REPORTS=\"$REP_MANILA_REPORTS\"
                                                REP_BRANCH_REPORTS=\"$REP_BRANCH_REPORTS\"
                                                REP_STATEMENT_OF_OPERATION=\"$REP_STATEMENT_OF_OPERATION\"
                                                FM_AGENT_MANAGEMENT=\"$FM_AGENT_MANAGEMENT\"
                                                FM_BRANCH_MANAGEMENT=\"$FM_BRANCH_MANAGEMENT\"
                                                FM_PLANS=\"$FM_PLANS\"
                                                FM_POLICY_FORMS=\"$FM_POLICY_FORMS\"
                                                MEMORIAL_SERVICES=\"$MEMORIAL_SERVICES\"
                                                ACCT_INCENTIVES_COMPUTATION=\"$ACCT_INCENTIVES_COMPUTATION\"
                                                ACCT_OR_VERIFICATION=\"$ACCT_OR_VERIFICATION\"
                                                ACCT_COLLECTION_SUMMARY=\"$ACCT_COLLECTION_SUMMARY\"
                                                SUPPORT_TICKETS_OPEN=\"$SUPPORT_TICKETS_OPEN\"
                                                SUPPORT_TICKETS_CLOSED=\"$SUPPORT_TICKETS_CLOSED\"
                                                SUPPORT_USER_GUIDE=\"$SUPPORT_USER_GUIDE\"
                                                SETTINGS_USER_ACCOUNTS=\"$SETTINGS_USER_ACCOUNTS\"
                                                SETTINGS_ACCESS_ROLES=\"$SETTINGS_ACCESS_ROLES\"
                                                SETTINGS_BACKUP_RESTOR=\"$SETTINGS_BACKUP_RESTOR\"




                                            >
                                            <i class=\"glyphicon glyphicon-edit\"></i></a>

                                            <a href=\"#\" 
                                            role_id=$ROLE_ID
                                            user_count=$USER_COUNT
                                            id=btnroledelete 
                                            class=\"btn btn-xs btn-danger btn-circle \"><i class=\"glyphicon glyphicon-trash\"></i></a>

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
		$result = mysqli_query($con,"SELECT count(*) as roleCount FROM roles WHERE role = '$ROLE';");
		$data 	= mysqli_fetch_row($result);
		if ($data[0] > 0) {
			echo "**exists**";
			return;
		}

		
		$strCols="`role`,`desciption`,";
		$strVals="'$ROLE','$DESCRIPTION',";

		foreach ($arrPerm as $key => $col) {
			$strCols.="`$col`,";
			if (in_array($col, $arrSelectedPerm)) {
			    $strVals.="1,";
			}else{
			    $strVals.="0,";
			}		    
		}

		$strCols = substr_replace($strCols, "", -1);
		$strVals = substr_replace($strVals, "", -1);

		//Insert record into database
		$result = mysqli_query($con,"INSERT INTO roles ($strCols) VALUES ($strVals);");

		//echo "INSERT INTO role ($strCols) VALUES ($strVals);";
		//return;

		if (mysqli_affected_rows($con) > 0){
			$result = mysqli_query($con,"


                        SELECT
                            `roles`.`role_id` AS 'ROLE_ID'
                            , `roles`.`role` AS 'ROLE'
                            , `roles`.`desciption` AS 'DESCRIPTION'
                            , `roles`.`MP_MEMBER_ENCODING`
                            , `roles`.`MP_MEMBER_DELETION`
                            , `roles`.`MP_PAYMENT`
                            , `roles`.`MP_MCPR_UPLOAD`
                            , `roles`.`MP_ENCODING_SUMMARY`
                            , `roles`.`MP_APPROVAL_OF_REQUESTS`
                            , `roles`.`MP_DECEASED_UPDATING`
                            , `roles`.`REP_AUDIT_TRAILS`
                            , `roles`.`REP_MCPR_REPORTS`
                            , `roles`.`REP_MCPR_GENERATE`
                            , `roles`.`REP_MCPR_DOWNLOAD`
                            , `roles`.`REP_MCPR_OFFLINE_DOWNLOAD`
                            , `roles`.`REP_MCPR_DELETE`
                            , `roles`.`REP_PERIODIC_INCENTIVES_REPORTS`
                            , `roles`.`REP_MANILA_REPORTS`
                            , `roles`.`REP_BRANCH_REPORTS`
                            , `roles`.`REP_STATEMENT_OF_OPERATION`
                            , `roles`.`FM_AGENT_MANAGEMENT`
                            , `roles`.`FM_BRANCH_MANAGEMENT`
                            , `roles`.`FM_PLANS`
                            , `roles`.`FM_POLICY_FORMS`
                            , `roles`.`MEMORIAL_SERVICES`
                            , `roles`.`ACCT_INCENTIVES_COMPUTATION`
                            , `roles`.`ACCT_OR_VERIFICATION`
                            , `roles`.`ACCT_COLLECTION_SUMMARY`
                            , `roles`.`SUPPORT_TICKETS_OPEN`
                            , `roles`.`SUPPORT_TICKETS_CLOSED`
                            , `roles`.`SUPPORT_USER_GUIDE`
                            , `roles`.`SETTINGS_USER_ACCOUNTS`
                            , `roles`.`SETTINGS_ACCESS_ROLES`
                            , `roles`.`SETTINGS_BACKUP_RESTOR`
                            , `roles`.`DEV_DEBUG`
                            , SUM(`users`.`user_id`) AS `USER_COUNT`
                        FROM
                            `dmcpi1_dmcsm`.`users`
                            INNER JOIN `dmcpi1_dmcsm`.`roles` 
                                ON (`users`.`role_id` = `roles`.`role_id`)
                        GROUP BY `roles`.`role_id`, `roles`.`role`, `roles`.`desciption`, `roles`.`MP_MEMBER_ENCODING`, `roles`.`MP_MEMBER_DELETION`, `roles`.`MP_PAYMENT`, `roles`.`MP_MCPR_UPLOAD`, `roles`.`MP_ENCODING_SUMMARY`, `roles`.`MP_APPROVAL_OF_REQUESTS`, `roles`.`MP_DECEASED_UPDATING`, `roles`.`REP_AUDIT_TRAILS`, `roles`.`REP_MCPR_REPORTS`, `roles`.`REP_MCPR_GENERATE`, `roles`.`REP_MCPR_DOWNLOAD`, `roles`.`REP_MCPR_OFFLINE_DOWNLOAD`, `roles`.`REP_MCPR_DELETE`, `roles`.`REP_PERIODIC_INCENTIVES_REPORTS`, `roles`.`REP_MANILA_REPORTS`, `roles`.`REP_BRANCH_REPORTS`, `roles`.`REP_STATEMENT_OF_OPERATION`, `roles`.`FM_AGENT_MANAGEMENT`, `roles`.`FM_BRANCH_MANAGEMENT`, `roles`.`FM_PLANS`, `roles`.`FM_POLICY_FORMS`, `roles`.`MEMORIAL_SERVICES`, `roles`.`ACCT_INCENTIVES_COMPUTATION`, `roles`.`ACCT_OR_VERIFICATION`, `roles`.`ACCT_COLLECTION_SUMMARY`, `roles`.`SUPPORT_TICKETS_OPEN`, `roles`.`SUPPORT_TICKETS_CLOSED`, `roles`.`SUPPORT_USER_GUIDE`, `roles`.`SETTINGS_USER_ACCOUNTS`, `roles`.`SETTINGS_ACCESS_ROLES`, `roles`.`SETTINGS_BACKUP_RESTOR`, `roles`.`DEV_DEBUG`
                        HAVING `roles`.`role_id` = LAST_INSERT_ID();
            ");

			$r = mysqli_fetch_array($result);

                                $ROLE_ID = $r['ROLE_ID']; 
                                $ROLE = $r['ROLE']; 
                                $DESCRIPTION = $r['DESCRIPTION']; 

                                $MP_MEMBER_ENCODING=$r['MP_MEMBER_ENCODING'];
                                $MP_MEMBER_DELETION=$r['MP_MEMBER_DELETION'];
                                $MP_PAYMENT=$r['MP_PAYMENT'];
                                $MP_MCPR_UPLOAD=$r['MP_MCPR_UPLOAD'];
                                $MP_ENCODING_SUMMARY=$r['MP_ENCODING_SUMMARY'];
                                $MP_APPROVAL_OF_REQUESTS=$r['MP_APPROVAL_OF_REQUESTS'];
                                $MP_DECEASED_UPDATING=$r['MP_DECEASED_UPDATING'];
                                $REP_AUDIT_TRAILS=$r['REP_AUDIT_TRAILS'];
                                $REP_MCPR_REPORTS=$r['REP_MCPR_REPORTS'];
                                $REP_MCPR_GENERATE=$r['REP_MCPR_GENERATE'];
                                $REP_MCPR_DOWNLOAD=$r['REP_MCPR_DOWNLOAD'];
                                $REP_MCPR_OFFLINE_DOWNLOAD=$r['REP_MCPR_OFFLINE_DOWNLOAD'];
                                $REP_MCPR_DELETE=$r['REP_MCPR_DELETE'];
                                $REP_PERIODIC_INCENTIVES_REPORTS=$r['REP_PERIODIC_INCENTIVES_REPORTS'];
                                $REP_MANILA_REPORTS=$r['REP_MANILA_REPORTS'];
                                $REP_BRANCH_REPORTS=$r['REP_BRANCH_REPORTS'];
                                $REP_STATEMENT_OF_OPERATION=$r['REP_STATEMENT_OF_OPERATION'];
                                $FM_AGENT_MANAGEMENT=$r['FM_AGENT_MANAGEMENT'];
                                $FM_BRANCH_MANAGEMENT=$r['FM_BRANCH_MANAGEMENT'];
                                $FM_PLANS=$r['FM_PLANS'];
                                $FM_POLICY_FORMS=$r['FM_POLICY_FORMS'];
                                $MEMORIAL_SERVICES=$r['MEMORIAL_SERVICES'];
                                $ACCT_INCENTIVES_COMPUTATION=$r['ACCT_INCENTIVES_COMPUTATION'];
                                $ACCT_OR_VERIFICATION=$r['ACCT_OR_VERIFICATION'];
                                $ACCT_COLLECTION_SUMMARY=$r['ACCT_COLLECTION_SUMMARY'];
                                $SUPPORT_TICKETS_OPEN=$r['SUPPORT_TICKETS_OPEN'];
                                $SUPPORT_TICKETS_CLOSED=$r['SUPPORT_TICKETS_CLOSED'];
                                $SUPPORT_USER_GUIDE=$r['SUPPORT_USER_GUIDE'];
                                $SETTINGS_USER_ACCOUNTS=$r['SETTINGS_USER_ACCOUNTS'];
                                $SETTINGS_ACCESS_ROLES=$r['SETTINGS_ACCESS_ROLES'];
                                $SETTINGS_BACKUP_RESTOR=$r['SETTINGS_BACKUP_RESTOR'];
                                $DEV_DEBUG=$r['DEV_DEBUG'];

                                $USER_COUNT = $r['USER_COUNT'];  
            
                $row = "
                                    <tr id=row$ROLE_ID>
                                        <td class=\"even gradeC\"> $ROLE_ID</td>
                                        <td>$ROLE</td>
                                        <td>$DESCRIPTION</td>
                                        <td>

                                            <a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnuseredit data-toggle=\"modal\" data-target=\"#myModal\"

                                                ROLE_ID     =\"$ROLE_ID\"
                                                ROLE    =\"$ROLE\"
                                                DESCRIPTION    =\"$DESCRIPTION\"

                                                MP_MEMBER_ENCODING=\"$MP_MEMBER_ENCODING\"
                                                MP_MEMBER_DELETION=\"$MP_MEMBER_DELETION\"
                                                MP_PAYMENT=\"$MP_PAYMENT\"
                                                MP_MCPR_UPLOAD=\"$MP_MCPR_UPLOAD\"
                                                MP_ENCODING_SUMMARY=\"$MP_ENCODING_SUMMARY\"
                                                MP_APPROVAL_OF_REQUESTS=\"$MP_APPROVAL_OF_REQUESTS\"
                                                MP_DECEASED_UPDATING=\"$MP_DECEASED_UPDATING\"
                                                REP_AUDIT_TRAILS=\"$REP_AUDIT_TRAILS\"
                                                REP_MCPR_REPORTS=\"$REP_MCPR_REPORTS\"
                                                REP_MCPR_GENERATE=\"$REP_MCPR_GENERATE\"
                                                REP_MCPR_DOWNLOAD=\"$REP_MCPR_DOWNLOAD\"
                                                REP_MCPR_OFFLINE_DOWNLOAD=\"$REP_MCPR_OFFLINE_DOWNLOAD\"
                                                REP_MCPR_DELETE=\"$REP_MCPR_DELETE\"
                                                REP_PERIODIC_INCENTIVES_REPORTS=\"$REP_PERIODIC_INCENTIVES_REPORTS\"
                                                REP_MANILA_REPORTS=\"$REP_MANILA_REPORTS\"
                                                REP_BRANCH_REPORTS=\"$REP_BRANCH_REPORTS\"
                                                REP_STATEMENT_OF_OPERATION=\"$REP_STATEMENT_OF_OPERATION\"
                                                FM_AGENT_MANAGEMENT=\"$FM_AGENT_MANAGEMENT\"
                                                FM_BRANCH_MANAGEMENT=\"$FM_BRANCH_MANAGEMENT\"
                                                FM_PLANS=\"$FM_PLANS\"
                                                FM_POLICY_FORMS=\"$FM_POLICY_FORMS\"
                                                MEMORIAL_SERVICES=\"$MEMORIAL_SERVICES\"
                                                ACCT_INCENTIVES_COMPUTATION=\"$ACCT_INCENTIVES_COMPUTATION\"
                                                ACCT_OR_VERIFICATION=\"$ACCT_OR_VERIFICATION\"
                                                ACCT_COLLECTION_SUMMARY=\"$ACCT_COLLECTION_SUMMARY\"
                                                SUPPORT_TICKETS_OPEN=\"$SUPPORT_TICKETS_OPEN\"
                                                SUPPORT_TICKETS_CLOSED=\"$SUPPORT_TICKETS_CLOSED\"
                                                SUPPORT_USER_GUIDE=\"$SUPPORT_USER_GUIDE\"
                                                SETTINGS_USER_ACCOUNTS=\"$SETTINGS_USER_ACCOUNTS\"
                                                SETTINGS_ACCESS_ROLES=\"$SETTINGS_ACCESS_ROLES\"
                                                SETTINGS_BACKUP_RESTOR=\"$SETTINGS_BACKUP_RESTOR\"




                                            >
                                            <i class=\"glyphicon glyphicon-edit\"></i></a>

                                            <a href=\"#\" 
                                            role_id=$ROLE_ID
                                            user_count=$USER_COUNT
                                            id=btnroledelete 
                                            class=\"btn btn-xs btn-danger btn-circle \"><i class=\"glyphicon glyphicon-trash\"></i></a>

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

       // echo("DELETE FROM roles WHERE role_id = $ROLE_ID;");
		$result = mysqli_query($con,"DELETE FROM roles WHERE role_id = $ROLE_ID;");
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