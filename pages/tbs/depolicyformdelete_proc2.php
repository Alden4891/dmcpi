<?php

$Plan_id		= $_REQUEST['Plan_id'];
$form_number	= $_REQUEST['form_number'];

include '../dbconnect.php';

mysqli_query($con,"UPDATE packages SET form_number = null WHERE Plan_id = $Plan_id");
//unlink($_SERVER['DOCUMENT_ROOT']."/pages/fpdf/reports/forms/$form_number.docx");
//unlink("./fpdf/reports/forms/$form_number.docx");

include '../dbclose.php';

echo "**success**";
?>