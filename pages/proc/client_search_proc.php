<?php

$search_cri_agent 		= $_REQUEST['search_cri_agent'];
$search_cri_member_code = $_REQUEST['search_cri_member_code'];
$search_cri_surname 	= $_REQUEST['search_cri_surname'];
$search_cri_plan_type 	= $_REQUEST['search_cri_plan_type'];
$search_cri_insurance 	= $_REQUEST['search_cri_insurance'];
$search_cri_membership_date = $_REQUEST['search_cri_membership_date'];

$search_cri_membership_date_filter = '';
if (!$search_cri_membership_date == '') {
	$search_cri_membership_date_filter = " AND date_of_membership='$search_cri_membership_date' ";	
}


include('dbconnect.php');
/*
echo "
	SELECT * FROM dmcsm.members_list WHERE (
	Agent LIKE '%$search_cri_agent%' AND 
	plan_code LIKE '%$search_cri_plan_type%' 
	AND insurance_type LIKE '%$search_cri_insurance%' 
	AND member_code LIKE '%$search_cri_member_code%' 
	AND fullname LIKE '%$search_cri_surname%' 
".$search_cri_membership_date_filter."
	) LIMIT 1, 10
";
exit();
*/
$sql = "aa";
if (!strlen($search_cri_member_code) == 9){
	$sql = "
		SELECT * FROM dmcsm.members_list WHERE (
		Agent LIKE '%$search_cri_agent%' AND 
		plan_code LIKE '%$search_cri_plan_type%' 
		AND insurance_type LIKE '%$search_cri_insurance%' 
		AND member_code LIKE '%$search_cri_member_code%' 
		AND fullname LIKE '%$search_cri_surname%' 
		".$search_cri_membership_date_filter."
		) LIMIT 1, 200
	";
}else{
	$sql = "SELECT * FROM dmcsm.members_list WHERE member_code = '$search_cri_member_code'";
}
//echo "$sql";


$res_members_list = mysqli_query($sql) or die(mysqli_error());

//	AND date_of_membership=''

 $record_count = mysqli_num_rows($res_members_list);

 echo "$record_count|";
 if ($record_count==0) {
 	echo "No Record";
 	exit();
 }



 while ($r=mysqli_fetch_array($res_members_list,MYSQLI_ASSOC)) {
    $Member_Code = $r['Member_Code']; 
    $Fullname = $r['Fullname']; 
    $Agent = $r['Agent']; 
    $Plan_Code = $r['Plan_Code']; 
    $No_of_Units = $r['No_of_Units']; 
    $Date_of_Membership = $r['Date_of_Membership']; 
    echo "
        <tr>
            <td class=\"text-primary\"> $Member_Code</td>
            <td>$Fullname</td>
            <td>$Agent</td>
            <td>$Plan_Code</td>
            <td>$No_of_Units</td>
            <td>$Date_of_Membership</td>

            <td><a href=\"?page=clientslist&cmd=editclient&Member_Code=$Member_Code\"><i class=\"material-icons\">edit</i></a></td>
            <td><a href=\"?page=clientslist&cmd=installment&Member_Code=$Member_Code\"><i class=\"material-icons\">assignment</i></a></td>
            <td><a href=\"?page=clientslist&cmd=addunit&Member_Code=$Member_Code\"><i class=\"material-icons\">note</i></a></td>
            <td><a href=\"?page=clientslist&cmd=status&Member_Code=$Member_Code\"><i class=\"material-icons\">pageview</i></a></td>
            <td><a href=\"?page=clientslist&cmd=printdetail&Member_Code=$Member_Code\"><i class=\"material-icons\">print</i></a></td>
            </tr>

    ";


}


mysqli_free_result($res_members_list);
include('dbclose.php');


?>