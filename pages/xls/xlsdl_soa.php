<?php

include '../dbconnect.php';

$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'');

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
                             ->setCategory("SOA");


$res_data  = mysqli_query($con, "call sp_soa('$Member_Code','');") or die(mysqli_error());

$r=mysqli_fetch_array($res_data,MYSQLI_ASSOC);
$fullname = $r['Fullname'];

// sheet 1: 
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A1', 'Statement of Account')


            ->setCellValue('A3', 'Member Code: ')
            ->setCellValue('A4', 'Name')
            ->setCellValue('A5', 'Address')
            ->setCellValue('A6', 'AGENT')
            ->setCellValue('A7', 'PLAN')

            ->setCellValue('B3', $Member_Code)
            ->setCellValue('B4', $fullname)
            ->setCellValue('B5', $r['Address'])
            ->setCellValue('B6', $r['Agent'])
            ->setCellValue('B7', $r['Plan_Code'])

            ->setCellValue('A9', 'No.')
            ->setCellValue('B9', 'Amount Due')
            ->setCellValue('C9', 'Overdue')
            ->setCellValue('D9', 'OR Number')
            ->setCellValue('E9', 'OR Date')
            ->setCellValue('F9', 'Amount Paid')
            ->setCellValue('G9', 'Remarks')
            ->setCellValue('H9', 'Period Covered')
            ;

$row_last_index = 0;
$row_index=9;
mysqli_data_seek($res_data, 0);
while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
    $row_index += 1;
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$row_index, $r['Installment_No'])
                ->setCellValue('B'.$row_index, $r['Amt_Due'])
                ->setCellValue('C'.$row_index, $r['Over_Due'])
                ->setCellValue('D'.$row_index, $r['OrNo'])
                ->setCellValue('E'.$row_index, $r['OrDate'])
                ->setCellValue('F'.$row_index, $r['Amt_Due'])
                ->setCellValue('G'.$row_index, $r['Remarks'])
                ->setCellValue('H'.$row_index, $r['Installment_Period_Covered'].' '.$r['Installment_Period_Year']);

}
$row_last_index = $row_index;
$objPHPExcel->getActiveSheet()->setTitle("SOA-$Member_Code");

//auto size column
foreach(range('A','H') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
//format columns
$objPHPExcel->getActiveSheet()->getStyle('B10:B'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('C10:C'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
$objPHPExcel->getActiveSheet()->getStyle('F10:F'.$row_last_index)->getNumberFormat()->setFormatCode('#,##0.00_);[Red](#,##0.00)');
//$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$row_last_index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//format header
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:H9')->getFont()->setBold(true);

//SET BORDERS
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A9:H'.$row_last_index)->applyFromArray($styleArray);
unset($styleArray);

$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');



mysqli_free_result($res_data);

include '../dbclose.php';




// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SOA_'.$Member_Code.'_'.$fullname.'.xlsx"');
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