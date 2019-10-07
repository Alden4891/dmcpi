<?php
	function getAge($dob,$basedate){
 		 $date = new DateTime($dob);
		 $now = new DateTime($basedate);
		 $interval = $now->diff($date);
		 return $interval->y;
	}
?>
 

