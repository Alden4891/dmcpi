<?php
/**
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

include '../dbconnect.php';

//$p_year = (isset($_REQUEST['year'])?$_REQUEST['year']:'');
//$p_month = (isset($_REQUEST['month'])?$_REQUEST['month']:'');
//$branch_id = (isset($_REQUEST['branch_id'])?$_REQUEST['branch_id']:'');

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
/*

function intToMonth($monthNum){
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  return  $dateObj->format('F');  
}
*/
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
/*
// Set document properties
$objPHPExcel->getProperties()->setCreator("Alden A. Quiñones")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


$res_agent = mysqli_query($con, "

  SELECT
      `agent_profile`.AgentID
      , UCASE(CONCAT(`agent_profile`.`Last_name`,', ',`agent_profile`.`First_name`,' ',SUBSTR(`agent_profile`.`Middle_Name`,1,1),'.')) AS `AGENT`
      ,`agent_profile`.Initials AS `Initials`
      , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `Amount_Paid`
      , SUM(`tbl_sharecomputation`.`NoOfPeriodPaid`) AS `NoOfPeriodPaid`
      , SUM(`tbl_sharecomputation`.`AgentShareAmount`) AS `AgentShareAmount`
      , MONTH(`tbl_sharecomputation`.`ordate`) AS `Month`
      , YEAR(`tbl_sharecomputation`.`ordate`) AS `Year`
  FROM
      `dmcpi1_dmcsm`.`agent_profile`
      INNER JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
          ON (`agent_profile`.`AgentID` = `tbl_sharecomputation`.`AgentID`)
  WHERE (YEAR(`tbl_sharecomputation`.`ordate`)= $p_year
      AND MONTH(`tbl_sharecomputation`.`ordate`) = $p_month
      AND  tbl_sharecomputation.`BranchID` = $branch_id
      )
  GROUP BY `agent_profile`.AgentID,`agent_profile`.`Last_name`, `agent_profile`.First_name, `agent_profile`.Middle_Name, `agent_profile`.Initials
  HAVING (`AgentShareAmount` > 0)
  ORDER BY `tbl_sharecomputation`.`Year` DESC, `tbl_sharecomputation`.`PeriodNo` DESC, `AGENT` ;


") or die(mysqli_error());


$res_bm  = mysqli_query($con, "

  SELECT
      `branch_details`.`Branch_ID`
      , `branch_details`.`Branch_Manager`
      , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `Amount_Paid`
      , SUM(`tbl_sharecomputation`.`NoOfPeriodPaid`) AS `NoOfPeriodPaid`
      , SUM(`tbl_sharecomputation`.`BMShareAmount`) AS `BMShareAmount`
      , MONTH(`tbl_sharecomputation`.`ordate`) AS `Month`
      , YEAR(`tbl_sharecomputation`.`ordate`) AS `Year`
  FROM
      `dmcpi1_dmcsm`.`branch_details`
      INNER JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
          ON (`branch_details`.`Branch_ID` = `tbl_sharecomputation`.`BranchID`)
  WHERE (YEAR(`tbl_sharecomputation`.`ordate`)= $p_year
      AND MONTH(`tbl_sharecomputation`.`ordate`)= $p_month
      AND  `tbl_sharecomputation`.`BranchID` = $branch_id
      )
  GROUP BY 
  `branch_details`.`Branch_ID`, 
  `branch_details`.`Branch_Manager`, 
  MONTH(`tbl_sharecomputation`.`ordate`), 
  YEAR(`tbl_sharecomputation`.`ordate`)
  HAVING (`BMShareAmount` >0)
  ORDER BY `year` DESC, periodno DESC, branch_manager;


") or die(mysqli_error());



// sheet 1: agent periodic share ----------------------------------------------------------------------------------------------
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'AGENT ID')
            ->setCellValue('B1', 'AGENT NAME')
            ->setCellValue('C1', 'INITIALS')
            ->setCellValue('D1', 'BASE AMOUNT')
            ->setCellValue('E1', 'NO. OF PAYMENT')
            ->setCellValue('F1', 'SHARE AMOUNT')
            ->setCellValue('G1', 'MONTH')
            ->setCellValue('H1', 'YEAR')
            ;

$row_last_index = 0;
$row_index=1;
while ($r=mysqli_fetch_array($res_agent,MYSQLI_ASSOC)) {
    $AgentID=$r['AgentID'];
    $row_index += 1;
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$row_index, $r['AgentID'])
                ->setCellValue('B'.$row_index, $r['AGENT'])
                ->setCellValue('C'.$row_index, $r['Initials'])
                ->setCellValue('D'.$row_index, $r['Amount_Paid'])
                ->setCellValue('E'.$row_index, $r['NoOfPeriodPaid'])
                ->setCellValue('F'.$row_index, $r['AgentShareAmount'])
                ->setCellValue('G'.$row_index, intToMonth($r['Month']))
                ->setCellValue('H'.$row_index, $r['Year']);

}
$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("Agent Periodic Share");

//auto size column
foreach(range('A','H') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//format header
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

//SET BORDERS
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$row_last_index)->applyFromArray($styleArray);
unset($styleArray);



// sheet 2: bm periodic share ----------------------------------------------------------------------------------------------
$objPHPExcel->createSheet(1);           
$objPHPExcel->setActiveSheetIndex(1); // This is the second required line
$objPHPExcel->getActiveSheet()->setTitle('BM Share');

$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'BM ID')
            ->setCellValue('B1', 'BRANCH MANAGER')
            ->setCellValue('C1', 'BASE AMOUNT')
            ->setCellValue('D1', 'NUMBER OF CLIENTS')
            ->setCellValue('E1', 'SHARE AMOUNT')
            ->setCellValue('F1', 'MONTH')
            ->setCellValue('G1', 'YEAR');


$row_last_index = 0;
$row_index=1;
while ($r=mysqli_fetch_array($res_bm,MYSQLI_ASSOC)) {
    $row_index += 1;
    $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue('A'.$row_index, $r['Branch_ID'])
                ->setCellValue('B'.$row_index, $r['Branch_Manager'])
                ->setCellValue('C'.$row_index, $r['Amount_Paid'])
                ->setCellValue('D'.$row_index, $r['NoOfPeriodPaid'])
                ->setCellValue('E'.$row_index, $r['BMShareAmount'])
                ->setCellValue('F'.$row_index, intToMonth($r['Month']))
                ->setCellValue('G'.$row_index, $r['Year']);

}
$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("BM Periodic Share");

//auto size column
foreach(range('A','G') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//format header
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

//SET BORDERS
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$row_last_index)->applyFromArray($styleArray);
unset($styleArray);

mysqli_free_result($res_agent);
mysqli_free_result($res_bm);

include '../dbclose.php';

*/


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="'."DMCSM_PeriodicShares_".$p_year."_".$p_month.'.xlsx"');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;

?>