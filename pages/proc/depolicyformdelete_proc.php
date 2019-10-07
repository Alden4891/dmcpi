<?php

$Plan_id		= $_REQUEST['Plan_id'];
$form_number	= $_REQUEST['form_number'];

include '../dbconnect.php';

mysqli_query($con,"DELETE FROM form_details WHERE plan_id = $Plan_id");
mysqli_query($con,"UPDATE packages SET form_number = '' WHERE Plan_id = $Plan_id");
unlink($_SERVER['DOCUMENT_ROOT']."/pages/fpdf/reports/forms/$form_number.jpg");

include '../dbclose.php';

echo "**success**";
?>