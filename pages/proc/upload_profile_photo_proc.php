<?php

$user_id = $_REQUEST['user_id'];
include '../dbconnect.php';


$size = getimagesize($_FILES['imgfile']['tmp_name']);
//print_r($size);

$image = addslashes(file_get_contents($_FILES['imgfile']['tmp_name']));
mysqli_query($con,"UPDATE users SET picture = '{$image}', picture_size='{$size[3]}', picture_type='{$size['mime']}' WHERE user_id = $user_id");

include '../dbclose.php';

echo "**success**";
?>