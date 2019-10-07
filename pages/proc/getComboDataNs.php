<?php  
include '../dbconnect.php';

$tableName 		=  (isset($_REQUEST['tableName'])?$_REQUEST['tableName']:''); 
$valueMember 	=  (isset($_REQUEST['valueMember'])?$_REQUEST['valueMember']:'');
$displayMember 	=  (isset($_REQUEST['displayMember'])?$_REQUEST['displayMember']:''); 
$condition 		=  (isset($_REQUEST['condition'])?$_REQUEST['condition']:'');


$sql =  "SELECT $valueMember, $displayMember FROM `$tableName` WHERE $condition;";

$res = mysqli_query($con, $sql ) OR die ('Trace: '.$sql);
echo "[$sql]";


	//echo "<option value='0'>Select</option>";
while ($r = mysqli_fetch_array($res)){
	$value = $r[0];
	$display = $r[1];
	echo "<option value='$value'>$display</option>";

}
include '../dbclose.php';
?>