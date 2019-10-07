<?php  
$user_id = $_COOKIE['user_id'];
include '../dbconnect.php';




//get encoding session id ---------------------------------------------------------------------------------
//note: negative value means late encoding 
$active_session_id = 0;
$res_session_id = mysqli_query($con,"SELECT IF (date_end < NOW(),ID*-1,ID) AS session_id FROM tbl_activities WHERE isactive=1;");
if (mysqli_num_rows($res_session_id) > 0) {
	$row_session = mysqli_fetch_row($res_session_id);
	$active_session_id = $row_session[0];
}

$MCPR_ID   =  (isset($_REQUEST['MCPR_ID'])?$_REQUEST['MCPR_ID']:''); 

$res_data_sql = "
	SELECT 
	  tbl_mcpr_details.MCPR_EID,
	  tbl_mcpr_details.Member_Code,
	  members_account.Date_of_membership AS DOI, 
	  members_account.No_of_units AS UNITS,
	  tbl_mcpr_details.ENC_AMOUNT,
	  tbl_mcpr_details.ENC_DATEENCODED,
	  tbl_mcpr_details.ENC_INS,
	  tbl_mcpr_details.ENC_OR,
	  tbl_mcpr_details.ENC_ORDATE,
	  tbl_mcpr_details.ENC_PC

	FROM
	  tbl_mcpr_details 
	  INNER JOIN
	  members_account 
	  ON members_account.Member_Code = tbl_mcpr_details.Member_Code 
	WHERE MCPR_ID = $MCPR_ID
	AND (NOT tbl_mcpr_details.ENC_AMOUNT IS NULL AND tbl_mcpr_details.ENC_AMOUNT!=0)
	AND (NOT tbl_mcpr_details.ENC_DATEENCODED IS NULL AND tbl_mcpr_details.ENC_DATEENCODED != '')
	AND (NOT tbl_mcpr_details.ENC_INS IS NULL AND tbl_mcpr_details.ENC_INS != '')
	AND (NOT tbl_mcpr_details.ENC_OR IS NULL AND tbl_mcpr_details.ENC_INS != '')
	AND (NOT tbl_mcpr_details.ENC_ORDATE IS NULL)

";



$res_data = mysqli_query($con,$res_data_sql) or die(mysqli_error());

$sqls = "";

while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)){


    $MCPR_EID 		 = $r['MCPR_EID']; 
    $Member_Code 	 = $r['Member_Code'];
	$DOI 			 = $r['DOI'];
    $ENC_AMOUNT 	 = $r['ENC_AMOUNT'];
    $ENC_DATEENCODED = $r['ENC_DATEENCODED'];
    $ENC_INS 		 = $r['ENC_INS'];
    $ENC_OR 		 = $r['ENC_OR'];
    $ENC_ORDATE 	 = $r['ENC_ORDATE'];
    $ENC_PC 		 = $r['ENC_PC'];
    $UNITS  		 = $r['UNITS'];

    $INS_COUNT		= getInsCount($ENC_INS);
    $INS_START		= getInsStart($ENC_INS);
    $INS_END		= getInsEnd($ENC_INS);

    for ($i=$INS_START; $i <= $INS_END ; $i++) { 

		$Installment_No   =$i;
		$Installment_no_pc=$ENC_INS;
		$Period_Covered   =getPeriodCovered($DOI,$i);
		$Period_No        =getPeriodNo($DOI,$i);
		$Period_Year      =getPeriodYear($DOI,$i);
		$Amt_Due          =$ENC_AMOUNT/$INS_COUNT;
		$Units            =$UNITS;
		$Term             =ceil($i / 12);
		$Br_period_covered=getBRPeriodCovered($DOI,$ENC_INS);
		$Br_installment_no=1;
		$Br_Amt 		  =$ENC_AMOUNT;
		$PRdate			  =$ENC_ORDATE;
		$PRno 			  =$ENC_OR;
		$ORdate 		  =$ENC_ORDATE;
		$ORno  			  =$ENC_OR;
		$Remarks 		  ="OFFLINE ENCODED";
		$date_posted      =date('Y-m-d');
		$date_encoded     =$ENC_DATEENCODED;
		$DueDate          =getOverdueDate($DOI,$i);
		$DeactivationDate =getDeactivationDate($DOI,$i);

		//installment_ledger

	$sqls.="
 INSERT INTO installment_ledger (
  Member_Code,
  Installment_No,
  Installment_no_pc,
  Period_Covered,
  Period_No,
  Period_Year,
  Amt_Due,
  Units,
  Term,
  Br_period_covered,
  Br_installment_no,
  Br_Amt,
  PRdate,
  PRno,
  ORdate,
  ORno,
  Remarks,
  date_posted,
  date_encoded,
  encoded_by,
  DueDate,
  DeactivationDate,
  enc_session_id
) 
VALUES
  (
    '$Member_Code',
    '$Installment_No',
    '$Installment_no_pc',
    '$Period_Covered',
    '$Period_No',
    '$Period_Year',
    '$Amt_Due',
    '$Units',
    '$Term',
    '$Br_period_covered',
    '$Br_installment_no',
    '$Br_Amt',
    '$PRdate',
    '$PRno',
    '$ORdate',
    '$ORno',
    '$Remarks',
    '$date_posted',
    '$date_encoded',
    '$user_id',
    '$DueDate',
    '$DeactivationDate',
    '$active_session_id'
  ) ;

 		
		";	
    }
}

if ($sqls!=""){
	$sqls.="UPDATE tbl_mcpr_details	SET ENC_VALIDATED = 1 WHERE MCPR_ID=$MCPR_ID;";
} 

if (mysqli_multi_query($con,$sqls)){
	echo "**success**";
} else {
	echo "**failed**";	
}

mysqli_free_result($res_data);

include '../dbclose.php';

	function getOverdueDate($DOI,$INS){
		$doi_year = date('Y', strtotime("+$INS months", strtotime($DOI)));
		$doi_month = date('m', strtotime("+$INS months", strtotime($DOI)));
		return date('Y-m-d', strtotime("+1 months", strtotime("$doi_year-$doi_month-16")));
	}
	function getDeactivationDate($DOI,$INS){
		$doi_year = date('Y', strtotime("+$INS months", strtotime($DOI)));
		$doi_month = date('m', strtotime("+$INS months", strtotime($DOI)));
		return date('Y-m-d', strtotime("+2 months", strtotime("$doi_year-$doi_month-16")));
	}


	function getPeriodNo($doi,$ins){
		   $ins-=1;
		   return date('m', strtotime("+$ins months", strtotime("$doi")));
	}
	function getPeriodYear($doi,$ins){
		   $ins-=1;
		   return date('Y', strtotime("+$ins months", strtotime("$doi")));
	}

  function getBRPeriodCovered($DOI,$INS_RANGE){
	  $ENC_INS=$INS_RANGE;
	  $ENC_INS1="";
	  $ENC_INS2="";
	  $INS_COUNNT=0;

	  if (substr_count($ENC_INS,"-")==1){
	  	  $ARR_INS=explode("-", $ENC_INS);
	  	  $ENC_INS1=$ARR_INS[0];
	  	  $ENC_INS2=$ARR_INS[1];
 	  	  return getPeriodCovered2($DOI,$ENC_INS1).'-'.getPeriodCovered2($DOI,$ENC_INS2);
	  }else{

	  	 return getPeriodCovered2($DOI,$ENC_INS);
	  }
  }

  function getPeriodCovered2($doi,$ins){
  	   $ins-=1;
  	   return date('M y', strtotime("+$ins months", strtotime("$doi")));
  }

  function getPeriodCovered($doi,$ins){
  	   $ins-=1;
  	   return date('M', strtotime("+$ins months", strtotime("$doi")));
  }

  function getInsStart($INS_RANGE){
  	 return explode("-", $INS_RANGE)[0];
  }
  function getInsEnd($INS_RANGE){
	  $ENC_INS=$INS_RANGE;
	  $ENC_INS1="";
	  $ENC_INS2="";
	  if (substr_count($ENC_INS,"-")==1){
	  	  $ARR_INS=explode("-", $ENC_INS);
	  	  return $ARR_INS[1];
	  }else{
		  return $ENC_INS;	  	
	  }
  }

  function getInsCount($INS_RANGE){
	  $ENC_INS=$INS_RANGE;
	  $ENC_INS1="";
	  $ENC_INS2="";
	  $INS_COUNNT=0;

	  if (substr_count($ENC_INS,"-")==1){

	  	  $ARR_INS=explode("-", $ENC_INS);
	  	  $ENC_INS1=$ARR_INS[0];
	  	  $ENC_INS2=$ARR_INS[1];

	  }
	  return $ENC_INS2 - $ENC_INS1 + 1; 
  }



?>