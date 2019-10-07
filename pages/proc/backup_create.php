<?php

	include '../dbconnect.php';
	require_once('../backup_restore_class.php'); 
	$newImport = new backup_restore($con_host,$con_database,$con_username,$con_password);

    $backup_date = date('Y-m-d-h-i-s');
    $backup_filename = 'db-backup-'.$backup_date.rand(1,100000).'.sql';
    $newImport -> set_database_dump_filename($backup_filename);
    $message = $newImport -> backup ();   
    mysqli_query($con,"INSERT INTO backups (filename, description, filedate) VALUES ('$backup_filename', '', '$backup_date');");
    echo "**success**|$backup_filename";
    include '../dbclose.php';

?>