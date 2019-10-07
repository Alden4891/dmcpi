<?php
$paramYear  = (isset($_REQUEST['year'])?$_REQUEST['year']:0);//2018;
$paramMonth = (isset($_REQUEST['month'])?$_REQUEST['month']:0);//8;;
$paramBranchID  = (isset($_REQUEST['branch_id'])?$_REQUEST['branch_id']:0);
$paramBranch  = (isset($_REQUEST['branch'])?$_REQUEST['branch']:'no data');


//print_r($_REQUEST);
//return;

include '../dbconnect.php';

function monthToInt($month){
  $date = date_parse($month);
  return $date['month'];
}

function intToMonth($monthNum){
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	return  $dateObj->format('F'); 	
}

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Alden A. Quiñones")
                             ->setLastModifiedBy("Nothing")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("DMCPI MANILA REPORT");

$objReader = PHPExcel_IOFactory::createReader("Excel2007");
$objPHPExcel = $objReader->load('manila_report_template2.xlsx');
$objWorksheet = $objPHPExcel->getActiveSheet();

$sql = "
SELECT
  bd.Branch_Name AS 'Branch',
  members_profile.Member_Code,
  UPPER(CONCAT(members_profile.Fname,' ',IFNULL(MID(members_profile.Mname,1,1),''),'. ', members_profile.Lname)) AS 'Member',
  members_profile.Bdate,
  members_profile.Age,
  members_profile.Sex,
  members_profile.Status AS CIVIL_STAT,
  members_profile.Address,
  packages.Plan_Code AS PLAN,
  ma.Date_of_membership AS DOI,
  ma.Amount,
  ap.Initials AS 'AGENT',
  members_profile.Bname,
  members_profile.Bbdate,
  members_profile.Brelation,
  
  il.ORno,
  il.ORdate,
  il.Br_Amt AS 'AMOUNT',
  il.Br_period_covered,
  il.Installment_no_pc

FROM members_account ma
  INNER JOIN members_profile
    ON ma.Member_Code = members_profile.Member_Code
  INNER JOIN packages
    ON packages.Plan_id = ma.Plan_id
  INNER JOIN branch_details bd
    ON bd.Branch_ID = ma.BranchManager
  INNER JOIN agent_profile ap
    ON ma.AgentID = ap.AgentID
  INNER JOIN installment_ledger il
    ON il.Member_Code = ma.Member_Code
   
WHERE 
	MONTH(ma.Date_of_membership)=$paramMonth
	AND il.Installment_No = 1
	AND YEAR(ma.Date_of_membership)=$paramYear
	AND ma.BranchManager = $paramBranchID
ORDER BY Member

	;";

//echo "$sql";
$res_data = mysqli_query($con,$sql); 

$select_monthname = intToMonth($paramMonth);
$basedate = "$paramYear-$paramMonth-15";

//** FILL HEADER ------------------------------------------------------------
$objWorksheet->getCell('A6')->setValue("as of $select_monthname $paramYear");
$objWorksheet->getCell('A7')->setValue("BRANCH: $paramBranch");
$objWorksheet->getCell('O9')->setValue("$select_monthname $paramYear");


	$cnt=0;
	$entry_count = 1;
	$startrow=12;
	
	while ($r = mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {

		//get age
 		 $date = new DateTime($r['Bdate']);
		 $now = new DateTime($basedate);
		 $interval = $now->diff($date);
		 $age = $interval->y;


		$objWorksheet->getCell('B'.($startrow+$cnt))->setValue($entry_count);
		$objWorksheet->getCell('C'.($startrow+$cnt))->setValue($r['Member']);
		$objWorksheet->getCell('D'.($startrow+$cnt))->setValue(date_format(date_create($r['Bdate']),"Y/m/d"));
		$objWorksheet->getCell('E'.($startrow+$cnt))->setValue( $age	); //getAge($r['Bdate'],$basedate) 
		$objWorksheet->getCell('F'.($startrow+$cnt))->setValue($r['Sex']);
		$objWorksheet->getCell('G'.($startrow+$cnt))->setValue($r['CIVIL_STAT']);
		$objWorksheet->getCell('H'.($startrow+$cnt))->setValue($r['Address']);

		$objWorksheet->getCell('I'.($startrow+$cnt))->setValue($r['Bname']);
		$objWorksheet->getCell('J'.($startrow+$cnt))->setValue(date_format(date_create($r['Bbdate']),"Y/m/d"));
		$objWorksheet->getCell('K'.($startrow+$cnt))->setValue($r['Brelation']);
		$objWorksheet->getCell('L'.($startrow+$cnt))->setValue(date_format(date_create($r['DOI']),"Y/m/d"));
		$objWorksheet->getCell('M'.($startrow+$cnt))->setValue($r['AGENT']);
		$objWorksheet->getCell('N'.($startrow+$cnt))->setValue($r['PLAN']);

		$objWorksheet->getCell('O'.($startrow+$cnt))->setValue(date_format(date_create($r['ORdate']),"Y/m/d"));
		$objWorksheet->getCell('P'.($startrow+$cnt))->setValue($r['ORno']);
		$objWorksheet->getCell('Q'.($startrow+$cnt))->setValue($r['AMOUNT']);
		$objWorksheet->getCell('R'.($startrow+$cnt))->setValue($r['Br_period_covered']);
		$objWorksheet->getCell('S'.($startrow+$cnt))->setValue($r['Installment_no_pc']);


		//echo date_format(date_create($r['Bbdate']),"Y/m/d")."|";


		//$objWorksheet->getCell('J'.($startrow+$cnt))->setValue($r['Amount']);


		$cnt+=1;
		$entry_count+=1;
	}

		$last_row_number=($startrow+$cnt-1);
		//SET BORDERS
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$objPHPExcel->getActiveSheet()->getStyle("A$startrow:S$last_row_number")->applyFromArray($styleArray);
		unset($styleArray);

		//paper size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

		//SET PRINT AREA
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea("A1:S".($last_row_number+4));

//** LOAD -------------------------------------------------------------------

mysqli_free_result($res_data);
include '../dbclose.php';

$filename = "MR_$paramBranch-$paramMonth-$paramYear.xlsx";



// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=\"$filename\"");
header('Cache-Control: max-age=0'); 
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 2099 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');


exit;




?>