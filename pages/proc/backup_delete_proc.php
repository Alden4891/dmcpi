<?php


    $fn = (isset($_REQUEST['fn'])?$_REQUEST['fn']:'0');



    include '../dbconnect.php';
  
    


  $path = $_SERVER['DOCUMENT_ROOT'].'/beta/pages/backup/'.$fn;

    if(@unlink($path)) {
      echo "Deleted file "; 
      mysqli_query($con, "DELETE FROM backups WHERE filename = '$fn'") or die(mysqli_error());
      echo "**success**";
    }
    else{
      echo "**failed**";
    }


    include '../dbclose.php';




?>





