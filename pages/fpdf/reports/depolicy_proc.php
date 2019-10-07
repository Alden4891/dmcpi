<?php

$Plan_id		= $_REQUEST['Plan_id'];
$form_number	= $_REQUEST['form_number'];
$arrfield	= $_REQUEST['field'];
$arrfont	= $_REQUEST['font'];
$arrfsize	= $_REQUEST['fsize'];
$arrstyle	= $_REQUEST['style'];
$arrx	= $_REQUEST['xcoor'];
$arry	= $_REQUEST['ycoor'];

$mode = ($_REQUEST['hidden_form_number']=='0'?'insert':'update');

//clear first
include '../../dbconnect.php';

//note: dont use array [0];
$values = "";
foreach ($arrfield as $key=>$field) {
	if ($key>0){
		$style = $arrstyle[$key];
		$font = $arrfont[$key];
		$fsize = $arrfsize[$key];
		$style = $arrstyle[$key];
		$x = $arrx[$key];	
		$y = $arry[$key];	
		$values .= "('$Plan_id','$field','$font','$fsize','$style','$x','$y'),";
	}
}
$values = substr($values, 0, -1);

mysqli_query($con,"DELETE FROM form_details WHERE plan_id = $Plan_id");
mysqli_query($con,"INSERT INTO form_details (`plan_id`,`field`,`font`,`font_size`,`font_style`,`x`,`y`) VALUES $values;");
mysqli_query($con,"UPDATE packages SET form_number = '$form_number' WHERE Plan_id = $Plan_id");

echo "INSERT INTO form_details (`plan_id`,`field`,`font`,`font_size`,`font_style`,`x`,`y`) VALUES $values;";

//file upload
$sourcePath = $_FILES['file']['tmp_name'];
$targetPath = "forms/$form_number.jpg"; 
move_uploaded_file($sourcePath,$targetPath);


    $res_package = mysqli_query($con, "

        SELECT
            `Plan_id`
            , `Plan_Code`
            , `Plan_name`
            , `Eligibility`
            , `Coverage`
            , `Term`
            , `Constability`
            , `form_number`
        FROM
            `dmcpi1_dmcsm`.`packages`
        WHERE Plan_id = $Plan_id                                 

    ") or die(mysqli_error());

    $r=mysqli_fetch_array($res_package,MYSQLI_ASSOC);
    $Plan_Code = $r['Plan_Code']; 
    $Plan_name = $r['Plan_name']; 
    $Eligibility = $r['Eligibility']; 
    $Coverage = $r['Coverage'];
    $Term = $r['Term'];
    $Constability = $r['Constability'];

	$row = "
	    <tr id=row$Plan_id>
	        <td class=\"even gradeC\"> $Plan_Code</td>
	        <td>$Plan_name</td>
	        <td>$Eligibility</td>
	        <td>$Coverage</td>
	        <td>$Term</td>
	        <td>$Constability</td>
	        <td>$form_number</td>
	        
	        <td>
	            <a href=\"#\" class=\"btn btn-success btn-circle\" id=btnformedit data-toggle=\"modal\" data-target=\"#myModal\"
	                Plan_id =\"$Plan_id\"
	                form_number=$form_number    
	            >

	            <i class=\"glyphicon glyphicon-edit\"></i></a>
	            <a href=\"#?Plan_id=$Plan_id\" 
	            Plan_id=$Plan_id
	            id=btnformdelete 
	            form_number=$form_number
	            
	            class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

	        </td>
	</tr>

	";



mysqli_free_result($res_package);

include '../../dbclose.php';

echo "**success**|$row";
?>