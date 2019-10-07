<?php
$dev_mode = 0;
/*

CREATE USER 'dmcpi1_root'@'localhost' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON *.* TO 'dmcpi1_root'@'localhost';



db: dmcpi1_dmcsm

user: dmcpi1_root

pass: pass@word1



*/

/*

	$con_password = 'pass@word1';

	$con_username = 'root';

	$con_database = 'dmcpi1_dmcsm';

	$con_host = 'localhost';

*/

	/*

	$con_password = 'pass@word1';

	$con_username = 'dmcpi1_root';

	$con_database = 'dmcpi1_dmcsm';

	$con_host = 'localhost';	

	*/



	$con_password = 'pass@word1';

	$con_username = 'dmcpi1_root';

	$con_database = 'dmcpi1_dmcsm';

	//$con_host = 'mysql1005.mochahost.com';

	$con_host = 'localhost';	





	$con=mysqli_connect($con_host,$con_username,$con_password,$con_database);

	if (mysqli_connect_errno())

	  {

	  echo "Failed to connect to database: " . mysqli_connect_error();

	  }

?>