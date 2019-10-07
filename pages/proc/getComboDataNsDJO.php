<?php  
include '../dbconnect.php';

$tableName 		=  (isset($_REQUEST['tableName'])?$_REQUEST['tableName']:''); 
$valueMember 	=  (isset($_REQUEST['valueMember'])?$_REQUEST['valueMember']:'');
$displayMember 	=  (isset($_REQUEST['displayMember'])?$_REQUEST['displayMember']:''); 
$condition 		=  (isset($_REQUEST['condition'])?$_REQUEST['condition']:'');
$joint1			=  (isset($_REQUEST['joint1'])?$_REQUEST['joint1']:'');
$joint2			=  (isset($_REQUEST['joint2'])?$_REQUEST['joint2']:'');
$joint3			=  (isset($_REQUEST['joint3'])?$_REQUEST['joint3']:'');
$joint4			=  (isset($_REQUEST['joint4'])?$_REQUEST['joint4']:'');
$joint5			=  (isset($_REQUEST['joint5'])?$_REQUEST['joint5']:'');

$order			=  (isset($_REQUEST['order'])?'ORDER BY '.$_REQUEST['order']:'');

$sql =  "
	SELECT 
		DISTINCT 
			$valueMember, 
			$displayMember 
		FROM `$tableName` 
			$joint1 
			$joint2 
			$joint3 
			$joint4 
			$joint5 
	WHERE 
			$condition 
			$order;";

$res = mysqli_query($con, $sql ) OR die ('Trace: '.$sql);
//echo "[$sql]";


	//echo "<option value='0'>Select</option>";
while ($r = mysqli_fetch_array($res)){
	$value = $r[0];
	$display = $r[1];
	echo "<option value='$value'>$display</option>";

}
include '../dbclose.php';
?>