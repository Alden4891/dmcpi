<?php



include 'dbconnect.php';

    if(isset($_GET['user_id'])) {
        $sql = "SELECT picture, isnull(picture) as nopic  FROM users WHERE user_id = ".$_GET['user_id'];
		$result = mysqli_query($con, $sql) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error($conn));
		$row = mysqli_fetch_array($result);

		if ($row["nopic"]==0){
			header("Content-Type: image/jpeg");
			echo $row["picture"];
		}else{
	        $sql2 = "SELECT image FROM images WHERE id = 1";
			$result2 = mysqli_query($con, $sql2) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error($conn));
			$row2 = mysqli_fetch_array($result2);

			header("Content-Type: image/jpeg");
			echo $row2["image"];


		}
        
	}
	//mysqli_close($conn);


include 'dbclose.php';






/*

include 'dbconnect.php';

    if(isset($_GET['user_id'])) {
        $sql = "SELECT picture  FROM users WHERE user_id = ".$_GET['user_id'];
		$result = mysqli_query($con, $sql) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error($conn));
		$row = mysqli_fetch_array($result);
		header("Content-Type: image/jpeg");
        echo $row["picture"];
	}
	mysqli_close($conn);


include 'dbclose.php';
*/





?>

