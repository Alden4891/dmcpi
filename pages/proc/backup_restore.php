<?php

	include '../dbconnect.php';
	require_once('../backup_restore_class.php'); 
	$newImport = new backup_restore($con_host,$con_database,$con_username,$con_password);


    $fn = $_REQUEST['fn'];
    $newImport -> set_database_dump_filename($fn);            
    $message = $newImport -> restore (); 
    @unlink('backup/'.$fn);

    echo "**success**";

?>