<?php
	$conn = mysql_connect('localhost','root','pass@word1') or die('Unable to connect to database');
	$db = mysql_select_db('dmcsm') or die(mysql_error());
?>