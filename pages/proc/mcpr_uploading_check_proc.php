<?php  

include '../dbconnect.php';

$MCPR_ID   =  (isset($_REQUEST['MCPR_ID'])?$_REQUEST['MCPR_ID']:''); 
/*
//CHECK IF 

$res_data = mysqli_query($con,$res_data_sql) or die(mysqli_error());

$res_sql_completeness_check = mysqli_query($con,"
	select MCPR_EID, 
	 if (ENC_INS='' OR ENC_INS IS NULL,0,1) as C_ENC_INS 
	,if (ENC_OR='' OR ENC_OR IS NULL,0,1) as C_ENC_OR
	,if (ENC_ORDATE='' OR ENC_ORDATE IS NULL,0,1) as C_ENC_ORDATE 
	,if (ENC_AMOUNT=0 OR ENC_AMOUNT IS NULL,0,1) as C_ENC_AMOUNT

	, FLOOR((if (ENC_INS='' OR ENC_INS IS NULL,0,1) 
	 + if (ENC_OR='' OR ENC_OR IS NULL,0,1) 
	 + if (ENC_ORDATE='' OR ENC_ORDATE IS NULL,0,1) 
	 + if (ENC_AMOUNT=0 OR ENC_AMOUNT IS NULL,0,1))/4) as `IS_COMPLETE`

	from tbl_mcpr_details where mcpr_id=$MCPR_ID;
") or die(mysqli_error());

	$cnt=0;
while ($rr=mysqli_fetch_array($res_sql_completeness_check ,MYSQLI_ASSOC)){
    $IS_COMPLETE 		 = $r['IS_COMPLETE']; 


}
*/



//CHECK FOR DUPLICATES
$res_data_sql = "
	SELECT 
	  tbl_mcpr_details.ENC_OR
	FROM
	  tbl_mcpr_details 
	  INNER JOIN
	  installment_ledger	 
	  ON installment_ledger.ORno = tbl_mcpr_details.ENC_OR 
	WHERE tbl_mcpr_details.MCPR_ID = $MCPR_ID 
";

$res_data = mysqli_query($con,$res_data_sql) or die(mysqli_error());

$msg = "The following OR/PR already used. Please check payment details. <br><b>";

$cnt=1;
while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)){
    $ENC_OR 		 = $r['ENC_OR']; 
    $msg.="$cnt. <b>$ENC_OR</b> <BR>";
	$cnt++;
}
if ($cnt==1){
	echo "**success**";
} else {
	echo "**failed**|$msg";	
}

mysqli_free_result($res_data);

include '../dbclose.php';



?>