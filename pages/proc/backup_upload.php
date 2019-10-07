<?php
    $target_path = '../backup';
    $uploaded_backup  = "uploaded_backup.sql";
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_path . '/' . $uploaded_backup) or die('**failed**');    
    echo "**success**";

?>