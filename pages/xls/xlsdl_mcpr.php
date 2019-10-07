<?php
$ParamYear  = (isset($_REQUEST['year'])?$_REQUEST['year']:1900);//2018;
$MCPR_ID  = (isset($_REQUEST['MCPR_ID'])?$_REQUEST['MCPR_ID']:0);//8;
$paramMonth = (isset($_REQUEST['month'])?$_REQUEST['month']:1);//8;;
$encoder_name = (isset($_REQUEST['encoder_name'])?$_REQUEST['encoder_name']:1);//8;;

/*
--
150 client = fullflidge
burial = 5% and 5%
else = 10%

--payment
add advanced payment option
add option to edit ornumber only by the encoder

--mcpr
** generate mcpr per branch
** for encoder = access only the agent assoc with him/her

name client
address 
DOI -> reg date
agent 
plan
or date
or no
amount
30days
60days

*/

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
    die('This example should only be run from a Web Browser');

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
                             ->setCategory("MCPR");

$objReader = PHPExcel_IOFactory::createReader("Excel2007");
$objPHPExcel = $objReader->load('mcpr_template.xlsx');
$objWorksheet = $objPHPExcel->getActiveSheet();

$res_agentinfo = mysqli_query($con,"SELECT * FROM tbl_mcpr WHERE MCPR_ID=$MCPR_ID;"); 

$rr = mysqli_fetch_array($res_agentinfo,MYSQLI_ASSOC);
$txtBranch = $rr["BRANCH"];
$txtAgent = $rr["AGENT"];
$res_data = mysqli_query($con,"SELECT * FROM tbl_mcpr_details WHERE MCPR_ID=$MCPR_ID;"); 
$selectedPeriod = date("Y-m-d",strtotime("$ParamYear-$paramMonth-15"));

$txtYear = $ParamYear;
$txtMonth = date('F', strtotime("+0 month", strtotime($selectedPeriod)));

$txtNextYear = date('Y', strtotime("+1 month", strtotime($selectedPeriod)));
$txtNexMonth = date('F', strtotime("+1 month", strtotime($selectedPeriod)));

$txtPrevYear = date('Y', strtotime("-1 month", strtotime($selectedPeriod)));
$txtPrevMonth = date('F', strtotime("-1 month", strtotime($selectedPeriod)));

//** FILL HEADER ------------------------------------------------------------
$objWorksheet->getCell('A4')->setValue("COLLECTORS GUIDE FOR THE MONTH OF $txtMonth $txtYear");
$objWorksheet->getCell('B5')->setValue("BRANCH: $txtBranch");
$objWorksheet->getCell('C5')->setValue("AGENT: $txtAgent");
$objWorksheet->getCell('G5')->setValue("COLL. PERFORMANCE FOR THE MO. OF $txtPrevMonth $txtPrevYear");
$objWorksheet->getCell('L5')->setValue("$txtYear $txtMonth Collection");

//** PLAN CATEGORY ----------------------------------------------------------
/*
$objPHPExcel->getActiveSheet()->mergeCells('A7:B7');
	//SET PLAN COLOR
	$objPHPExcel->getActiveSheet()->getStyle('A7:B7')->getFill()
	->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	->getStartColor()->setARGB('FFFF0000');
	//SET FONTSIZE
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); 
	$objWorksheet->getCell('A7')->setValue('SAMPLE PLAN');
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:S7');
*/

	$cnt=0;
	$prev_plan="";
	$plan_count=0;
	$entry_count = 1;
	$startrow=7;

	while ($r = mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
		$client = $r['CLIENT'];
		$DOI = $r['DOI_ORG'];
		$ADDRESS = $r['ADDRESS'];
		$AGENT = $r['AGENT'];
		$Plan_Code = $r['Plan_Code'];
		$Plan_name = $r['Plan_name'];
		$INS = $r['INS'];
		$ORdate = $r['ORdate'];
		$ORno = $r['ORno'];
		$Br_Amt = $r['Br_Amt'];
		$PC = $r['PC'];
		$col_ins = $r['COL_INS'];
		$col_pc  = $r['COL_PC'];
		$col_30  = $r['COL_30'];
		$col_60  = $r['COL_60'];

		if ($Plan_Code != $prev_plan) {
			$prev_plan = $Plan_Code;
			$plan_row = ($startrow+$cnt);
	
			//format plans
			$objPHPExcel->getActiveSheet()->mergeCells("A$plan_row:B$plan_row");

			//SET PLAN COLOR
			$objPHPExcel->getActiveSheet()->getStyle("A$plan_row:B$plan_row")->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFFF00');
			//FONT SIZE
			//$objPHPExcel->getDefaultStyle()->getFont()->setBold(true); 
			$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); 
			$objWorksheet->getCell("A$plan_row")->setValue($Plan_name);
			$cnt+=1;		
		}  

		$objWorksheet->getCell('A'.($startrow+$cnt))->setValue($entry_count);
		$objWorksheet->getCell('B'.($startrow+$cnt))->setValue($client);
		$objWorksheet->getCell('C'.($startrow+$cnt))->setValue($DOI);
		$objWorksheet->getCell('D'.($startrow+$cnt))->setValue($ADDRESS);
		$objWorksheet->getCell('E'.($startrow+$cnt))->setValue($AGENT);
		$objWorksheet->getCell('F'.($startrow+$cnt))->setValue($Plan_Code);

		$objWorksheet->getCell('G'.($startrow+$cnt))->setValue($INS);
		$objWorksheet->getCell('H'.($startrow+$cnt))->setValue($ORdate);
		$objWorksheet->getCell('I'.($startrow+$cnt))->setValue($ORno);
		$objWorksheet->getCell('J'.($startrow+$cnt))->setValue($Br_Amt);
		$objWorksheet->getCell('K'.($startrow+$cnt))->setValue($PC);

		$objWorksheet->getCell('L'.($startrow+$cnt))->setValue($col_ins);
		$objWorksheet->getCell('P'.($startrow+$cnt))->setValue($col_pc);
		$objWorksheet->getCell('R'.($startrow+$cnt))->setValue($col_30);
		$objWorksheet->getCell('S'.($startrow+$cnt))->setValue($col_60);

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

		//TOTAL
		$objWorksheet->getCell('N'.($last_row_number+1))->setValue("TOTAL: ______________________________________________________");

		//PRINT FOOTER
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&l PREPARED BY:  '.$encoder_name.' 
																		 &c Page &P/&N'.chr(10).chr(13).'CERTIFIED CORRECT :  ________________________ 
																		 &r APPROVED BY: __________________________'.chr(10).chr(13));

		//paper size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

		//SET PRINT AREA
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea("A1:S".($last_row_number+4));

//** LOAD -------------------------------------------------------------------

mysqli_free_result($res_data);
include '../dbclose.php';
$mm = $txtMonth;

$filename = "MCPR_".$txtAgent."_".$mm."_$txtYear.xlsx";


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

/*



                                                                        Page 1                                                 TOTAL:__________________________________







PREPARED BY:  AUBREY D. PENDON                    CERTIFIED CORRECT :  ________________________                                     APPROVED BY: HONEY CHEER G. CUBA                  





*/





?>