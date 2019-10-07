<?php

include '../dbconnect.php';

$p_year = (isset($_REQUEST['year'])?$_REQUEST['year']:'');
$p_month = (isset($_REQUEST['month'])?$_REQUEST['month']:'');
$p_branch_id = (isset($_REQUEST['branch_id'])?$_REQUEST['branch_id']:'');

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
$objPHPExcel->getProperties()->setCreator("DMCPI - KORONADAL")
                             ->setLastModifiedBy("is.dmcpi.com")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("DMCPI INCENTIVES");


// sheet 1: agent Incentives ----------------------------------------------------------------------------------------------

$res_agent = mysqli_query($con, "SELECT * FROM `vAgentShareList` WHERE `month`=$p_month AND `year`=$p_year AND BranchID=$p_branch_id ORDER BY agent") or die(mysqli_error());

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'AGENT ID')
            ->setCellValue('B1', 'AGENT NAME')
            ->setCellValue('C1', 'INITIALS')
            ->setCellValue('D1', 'GROSS')
            ->setCellValue('E1', 'NUMBER OF CLIENTS')
            ->setCellValue('F1', 'REG. INCENTIVES')
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
                ->setCellValue('C'.$row_index, $r['INITIALS'])
                ->setCellValue('D'.$row_index, $r['Amount_Paid'])
                ->setCellValue('E'.$row_index, $r['Number_of_clients'])
                ->setCellValue('F'.$row_index, $r['AgentShareAmount'])
                ->setCellValue('G'.$row_index, $r['Month'])
                ->setCellValue('H'.$row_index, $r['Year']);
}

$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("Agent Incentives");

//auto size column
foreach(range('A','I') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

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

// sheet 2: bm Incentives ----------------------------------------------------------------------------------------------

$res_bm  = mysqli_query($con, "SELECT * FROM vbmsharelist WHERE `year` = $p_year AND `month`=$p_month AND BranchID=$p_branch_id") or die(mysqli_error());


$objPHPExcel->createSheet(1);           
$objPHPExcel->setActiveSheetIndex(1); // This is the second required line
$objPHPExcel->getActiveSheet()->setTitle('BM Incentives');

$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'BM ID')
            ->setCellValue('B1', 'BRANCH MANAGER')
            ->setCellValue('C1', 'GROSS')
            ->setCellValue('D1', 'NUMBER OF CLIENTS')
            ->setCellValue('E1', 'REG. INCENTIVES')
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
                ->setCellValue('F'.$row_index, $r['Month'])
                ->setCellValue('G'.$row_index, $r['Year']);

}
$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("BM Incentives");

//auto size column
foreach(range('A','G') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

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

$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$row_last_index)->applyFromArray($styleArray);
unset($styleArray);

// sheet 3: ffso Overriding Incentives ----------------------------------------------------------------------------------------------

$res_agent_oi = mysqli_query($con,"
SELECT
      `agent_profile`.`AgentID`
    , `agent_profile`.`Initials`
    , UCASE(CONCAT(`agent_profile`.`Last_name`,', ',`agent_profile`.`First_name`,' ',SUBSTR(`agent_profile`.`Middle_Name`,1,1),'.')) AS `AGENT`
    , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `GROSS`
    , SUM(`tbl_sharecomputation`.`oi_ffso`) AS `OI`
    , YEAR(`tbl_sharecomputation`.ordate)  AS `Year`
    , MONTHNAME(`tbl_sharecomputation`.ordate)  AS `Month`
 
FROM
    `dmcpi1_dmcsm`.`tbl_sharecomputation`
    INNER JOIN `dmcpi1_dmcsm`.`agent_profile` 
        ON (`tbl_sharecomputation`.`oi_ffso_id` = `agent_profile`.`AgentID`)
WHERE (`tbl_sharecomputation`.`BranchID` =  $p_branch_id
    AND YEAR(ORdate) = $p_year
    AND MONTH(ORdate) = $p_month);
") or die(mysqli_error());


$objPHPExcel->createSheet(2);           
$objPHPExcel->setActiveSheetIndex(2); // This is the second required line
$objPHPExcel->getActiveSheet()->setTitle('FFSO OI');

$objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A1', 'AGENT ID')
            ->setCellValue('B1', 'AGENT (FFSO)')
            ->setCellValue('C1', 'INITIALS')
            ->setCellValue('D1', 'GROSS')
            ->setCellValue('E1', 'OVERRIDING INC.')
            ->setCellValue('F1', 'MONTH')
            ->setCellValue('G1', 'YEAR');


$row_last_index = 0;
$row_index=1;
while ($r=mysqli_fetch_array($res_agent_oi,MYSQLI_ASSOC)) {
    $row_index += 1;
    $objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue('A'.$row_index, $r['AgentID'])
                ->setCellValue('B'.$row_index, $r['AGENT'])
                ->setCellValue('C'.$row_index, $r['Initials'])
                ->setCellValue('D'.$row_index, $r['GROSS'])
                ->setCellValue('E'.$row_index, $r['OI'])
                ->setCellValue('F'.$row_index, $r['Month'])
                ->setCellValue('G'.$row_index, $r['Year']);

}
$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("FFSO OI");

//auto size column
foreach(range('A','G') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

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


// sheet 4: bm overriding Incentives ----------------------------------------------------------------------------------------------

$res_bm_oi = mysqli_query($con,"
SELECT
      `branch_details`.`Branch_ID`
    , `branch_details`.`Branch_Name`
    , `branch_details`.`Branch_Manager`
    , SUM(`tbl_sharecomputation`.`Amount_Paid`) AS `GROSS`
    , SUM(`tbl_sharecomputation`.`oi_bm`) AS `OI`
    , YEAR(`tbl_sharecomputation`.`ORdate`) AS `Year`
    , month(`tbl_sharecomputation`.`ORdate`) AS `Month`
  
FROM
    `dmcpi1_dmcsm`.`tbl_sharecomputation`
    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
        ON (`tbl_sharecomputation`.`oi_bm_id` = `branch_details`.`Branch_ID`)
WHERE (`tbl_sharecomputation`.`BranchID` =$p_branch_id
    AND YEAR(ORdate) =$p_year
    AND MONTH(ORdate) =$p_month);
") or die(mysqli_error());


$objPHPExcel->createSheet(3);           
$objPHPExcel->setActiveSheetIndex(3); // This is the second required line
$objPHPExcel->getActiveSheet()->setTitle('BM OI');

$objPHPExcel->setActiveSheetIndex(3)
            ->setCellValue('A1', 'BANCH ID')
            ->setCellValue('B1', 'BRANCH NAME')
            ->setCellValue('C1', 'HEAD')
            ->setCellValue('D1', 'GROSS')
            ->setCellValue('E1', 'OVERRIDING INC.')
            ->setCellValue('F1', 'MONTH')
            ->setCellValue('G1', 'YEAR');


$row_last_index = 0;
$row_index=1;
while ($r=mysqli_fetch_array($res_bm_oi,MYSQLI_ASSOC)) {
    $row_index += 1;
    $objPHPExcel->setActiveSheetIndex(3)
                ->setCellValue('A'.$row_index, $r['Branch_ID'])
                ->setCellValue('B'.$row_index, $r['Branch_Name'])
                ->setCellValue('C'.$row_index, $r['Branch_Manager'])
                ->setCellValue('D'.$row_index, $r['GROSS'])
                ->setCellValue('E'.$row_index, $r['OI'])
                ->setCellValue('F'.$row_index, $r['Month'])
                ->setCellValue('G'.$row_index, $r['Year']);

}
$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("BM OI");

//auto size column
foreach(range('A','G') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');

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





// finalizing ------------------------------------------------------------------------------------------------------------
mysqli_free_result($res_agent);
mysqli_free_result($res_bm);
mysqli_free_result($res_agent_oi);
mysqli_free_result($res_bm_oi);

include '../dbclose.php';

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'."DMCPI_Incentives_".$p_year."_".$p_month.'.xlsx"');
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