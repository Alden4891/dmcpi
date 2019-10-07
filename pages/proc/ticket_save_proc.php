<?php

    $ntPRIORITY= $_POST['ntPRIORITY'];
    $ntTICKETNO= $_POST['ntTICKETNO'];
    $ntSUBJECT= $_POST['ntSUBJECT'];
    $ntCONCERN= $_POST['ntCONCERN'];
    $ntCATEGORY= $_POST['ntCATEGORY'];
    $USER_ID = $_POST['USER_ID'];
    $mode = '';

	include '../dbconnect.php';
    $res_data = mysqli_query($con,"SELECT * FROM tickets WHERE TICKETNO=$ntTICKETNO;");
   
	if(mysqli_num_rows($res_data) == 0 ) {
		mysqli_query($con,"

        INSERT INTO tickets (`USER_ID`,`CATEGORY`,`PRIORITY`,`SUBJECT`,`DESCRIPTION`,`DATE_RAISED`,`DATE_UPDATED`,`STATUS`) VALUES
        ('$USER_ID','$ntCATEGORY','$ntPRIORITY','$ntSUBJECT','$ntCONCERN',NOW(),NOW(),0);

        ");
        $mode = 'INSERT';
		$ntTICKETNO = mysqli_insert_id($con);
        //echo "->".$TICKETNO;
	}else{
		mysqli_query($con,"

            UPDATE `tickets` 
                SET `CATEGORY` = '$ntCATEGORY'
                   ,`PRIORITY`='$ntPRIORITY'
                   ,`SUBJECT`='$ntSUBJECT'
                   ,`DESCRIPTION`='$ntCONCERN'
                   ,`DATE_UPDATED`=NOW() 
            WHERE `TICKETNO`='$ntTICKETNO';");
        $mode = 'UPDATE';
	}


	
	if (mysqli_affected_rows($con)){
	   
		$res_new = mysqli_query($con, "


        SELECT
              `tickets`.`TICKETNO`
            , `users`.`user_id`
            , `users`.`fullname`
            , `libcategory`.`CATEGORY`
            , `libcategory`.RESP
            , CONCAT(`libcategory`.RESP,',',`users`.`user_id`) AS GRANTED_USER
            , `tickets`.`PRIORITY`
            , `tickets`.`SUBJECT`
            , `tickets`.`DESCRIPTION`
            , `tickets`.`DATE_RAISED`
            , `tickets`.`DATE_UPDATED`
            , `libstatus`.`STATUS`
            , `libstatus`.`ID` AS `STATUS_ID`
        FROM
            `tickets`
            INNER JOIN `users` 
                ON (`tickets`.`USER_ID` = `users`.`user_id`)
            INNER JOIN `libstatus` 
                ON (`tickets`.`STATUS` = `libstatus`.`ID`)
            INNER JOIN `libcategory` 
                ON (`tickets`.`CATEGORY` = `libcategory`.`ID`)
               
        WHERE `tickets`.`TICKETNO` = $ntTICKETNO
        ORDER BY  `tickets`.`DATE_UPDATED` DESC
         ;
                                 

        ");
		$r=mysqli_fetch_array($res_new,MYSQLI_ASSOC);




        $TICKETNO = sprintf('%06d', $r['TICKETNO']); 
        $USER_ID = $r['user_id']; 
        $FULLNAME = strtoupper($r['fullname']); 
        $CATEGORY = $r['CATEGORY'];
        $PRIORITY = $r['PRIORITY']; 
        $SUBJECT = $r['SUBJECT']; 
        $DESCRIPTION = $r['DESCRIPTION']; 
        $DATE_RAISED = $r['DATE_RAISED']; 
        $DATE_UPDATED = $r['DATE_UPDATED']; 
        $STATUS = $r['STATUS']; 
        $STATUS_ID = $r['STATUS_ID']; 
        $RESP = $r['RESP']; 
        $GRANTED_USER = explode(",", $r['RESP']);
        $btn_detail_class = "";
        if (!in_array($USER_ID, $GRANTED_USER)){
            $btn_detail_class = "disabled";    
        }



        $row_colorclass = "";                                
        if ($STATUS_ID == 3){
            $row_colorclass = "success";
        }else {
            $row_colorclass = "";
        }


        $ret_string = "";
            if ($mode=='UPDATE'){
            $ret_string = "**success**|UPDATE|
                                        <td class=\"even gradeC\"> $TICKETNO</td>
                                        <td>$SUBJECT</td>
                                        <td>$CATEGORY</td>
                                        <td>$DATE_RAISED</td>
                                        <td>$PRIORITY</td>
                                        <td>$STATUS</td>
                                        <td>$DATE_UPDATED</td>
                                        <td><a href='index.php?page=ticketlist_detail&tn=$TICKETNO' CLASS='btn btn-sm btn-primary $btn_detail_class'>DETAILS</a></td>
       

            ";
            }else{
            $ret_string = "**success**|INSERT|<tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $TICKETNO</td>
                                        <td>$SUBJECT</td>
                                        <td>$CATEGORY</td>
                                        <td>$DATE_RAISED</td>
                                        <td>$PRIORITY</td>
                                        <td>$STATUS</td>
                                        <td>$DATE_UPDATED</td>
                                        <td><a href='index.php?page=ticketlist_detail&tn=$TICKETNO' CLASS='btn btn-sm btn-primary $btn_detail_class'>DETAILS</a></td>
            </tr>

            ";           
        }
        //echo "$ntTICKETNO";
        echo "$ret_string";


		
	}else{
		echo "**no_changes**";
	}

	include '../dbclose.php';



?>