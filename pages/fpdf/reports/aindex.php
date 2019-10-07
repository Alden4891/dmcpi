<?php
	$report = (isset($_REQUEST['rep_id'])?$_REQUEST['rep_id']:'none');

	switch ($report) {
		case '1':
			include 'report1.php';
			break;
		
		default:
			# do nothing
			break;
	}

?>
