<?php

	$file = isset($_REQUEST['file'])?$_REQUEST['file']:'dummy.file';
	echo file_exists($file)?'**exists**':'**notexists**';

?>