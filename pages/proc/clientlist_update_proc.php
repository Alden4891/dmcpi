<?php

$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'');

$txtfirstname = (isset($_REQUEST['txtfirstname'])?$_REQUEST['txtfirstname']:'');
$txtmiddlename = (isset($_REQUEST['txtmiddlename'])?$_REQUEST['txtmiddlename']:'');
$txtlastname = (isset($_REQUEST['txtlastname'])?$_REQUEST['txtlastname']:'');
$selSex = (isset($_REQUEST['selSex'])?$_REQUEST['selSex']:'');
$dtDOB = (isset($_REQUEST['dtDOB'])?$_REQUEST['dtDOB']:'');

$dtDOI = (isset($_REQUEST['dtDOI'])?$_REQUEST['dtDOI']:'');
$selPlan = (isset($_REQUEST['selPlan'])?$_REQUEST['selPlan']:'');
$selAgent = (isset($_REQUEST['selAgent'])?$_REQUEST['selAgent']:'');
$selBranch = (isset($_REQUEST['selBranch'])?$_REQUEST['selBranch']:'');
$no_of_units = (isset($_REQUEST['no_of_units'])?$_REQUEST['no_of_units']:'');


//$dtReceiptDate = (isset($_REQUEST['dtReceiptDate'])?$_REQUEST['dtReceiptDate']:'');
//$txtORPR = (isset($_REQUEST['txtORPR'])?$_REQUEST['txtORPR']:'');
//$selPeriod = (isset($_REQUEST['selPeriod'])?$_REQUEST['selPeriod']:'');
//$selYear = (isset($_REQUEST['selYear'])?$_REQUEST['selYear']:'');
//$txtNoPeriodPaid = (isset($_REQUEST['txtNoPeriodPaid'])?$_REQUEST['txtNoPeriodPaid']:'');
//$txtAmountPaid = (isset($_REQUEST['txtAmountPaid'])?$_REQUEST['txtAmountPaid']:'');

include "../dbconnect.php";

		mysqli_query($con, "
			UPDATE members_profile
				SET 
				`Fname`		='$txtfirstname',
				`Mname`		='$txtmiddlename',
				`Lname`		='$txtlastname',
				`Sex`		='$selSex',
				`Bdate`		='$dtDOB'
			WHERE Member_Code = '$Member_Code';
		") or die('**failed**|'.mysqli_error());


		mysqli_query($con, "
			UPDATE members_account
			SET
				`Plan_id`='$selPlan',
				`No_of_units`='1',
				`AgentID`='$selAgent',
				`Date_of_membership`='$dtDOI',
				`BranchManager`='$selBranch',
				`no_of_units`='$no_of_units',
				`Remarks`='' 
			WHERE `Member_Code`='$Member_Code';
		") or die('**failed**|'.mysqli_error());


		echo "**success**|Update Saved";

include '../dbclose.php';

?>

