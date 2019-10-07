<?php
$paramYear  = (isset($_REQUEST['year'])?$_REQUEST['year']:0);//2018;
$paramMonth = (isset($_REQUEST['month'])?$_REQUEST['month']:0);//8;;
$paramBranchID  = (isset($_REQUEST['branch_id'])?$_REQUEST['branch_id']:0);
$paramBranch  = (isset($_REQUEST['branch'])?$_REQUEST['branch']:'no data');
$array_remittance = array();
$trace_mode = 0;


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
                             ->setCategory("DMCPI BANCH REPORT");

$objReader = PHPExcel_IOFactory::createReader("Excel2007");
$objPHPExcel = $objReader->load('br_template.xlsx');

$classification = "";
//select Branch Report Sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWorksheet = $objPHPExcel->getActiveSheet();
$objWorksheet->getPageSetup()->setFitToWidth(1);
$objWorksheet->getPageSetup()->setFitToHeight(0);

$sql = "

SELECT
    `installment_ledger`.`Member_Code`
    , `members_profile`.`ENTRY_ID`
    , UPPER(CONCAT(`members_profile`.`Lname`  ,', ', `members_profile`.`Fname` ,' ', IF(`members_profile`.`Mname`='','', CONCAT(MID(`members_profile`.`Mname`,1,1),'.')))) AS Member
    , UPPER(`members_profile`.`Address`) AS Address 
    , `members_account`.`Date_of_membership` AS DOI
    , `agent_profile`.`Initials` AS Agent_Initials
    , UPPER(CONCAT(`agent_profile`.`Last_name`  ,', ', `agent_profile`.`First_name` ,' ', IF(`agent_profile`.`Middle_Name`='','', CONCAT(MID(`agent_profile`.`Middle_Name`,1,1),'.')))) AS Agent
    , `branch_details`.`Branch_Name`
    , `packages`.`Plan_Code` AS Plan
    , `installment_ledger`.`ORdate`
    , `installment_ledger`.`ORno`
    , SUM(`installment_ledger`.`Amt_Due`) AS `Amount`
    , `installment_ledger`.`Br_period_covered`
    , `installment_ledger`.`Installment_no_pc`
    , IFNULL(SUM(`tbl_sharecomputation`.`BMShareAmount`),0) + IFNULL(SUM(`tbl_sharecomputation`.`oi_bm`),0) AS `branch_share`
    , IFNULL(SUM(`tbl_sharecomputation`.`AgentShareAmount`),0) + IFNULL(SUM(`tbl_sharecomputation`.`oi_ffso`),0) AS `agent_share`
    , IFNULL(SUM(`installment_ledger`.`Amt_Due`),0) - IFNULL(SUM(`tbl_sharecomputation`.`BMShareAmount`),0) + IFNULL(SUM(`tbl_sharecomputation`.`oi_bm`),0) + IFNULL(SUM(`tbl_sharecomputation`.`AgentShareAmount`),0) + IFNULL(SUM(`tbl_sharecomputation`.`oi_ffso`),0) AS `net_remittance`
FROM
    `dmcpi1_dmcsm`.`installment_ledger`
    INNER JOIN `dmcpi1_dmcsm`.`members_account` 
        ON (`installment_ledger`.`Member_Code` = `members_account`.`Member_Code`)
    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
        ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
    INNER JOIN `dmcpi1_dmcsm`.`agent_profile` 
        ON (`members_account`.`AgentID` = `agent_profile`.`AgentID`)
    INNER JOIN `dmcpi1_dmcsm`.`packages` 
        ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
    INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
        ON (`members_profile`.`Member_Code` = `installment_ledger`.`Member_Code`)
    LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation`
        ON (`tbl_sharecomputation`.`ORno` = `installment_ledger`.`ORno`)
 

WHERE `branch_details`.`Branch_ID` = $paramBranchID
	AND YEAR(`installment_ledger`.`ORdate`) =$paramYear 
	AND MONTH(`installment_ledger`.`ORdate`)=$paramMonth
GROUP BY `installment_ledger`.`Member_Code`, `members_profile`.`ENTRY_ID`, `members_profile`.`Fname`, `members_profile`.`Mname`, `members_profile`.`Lname`, `members_profile`.`Address`, `members_account`.`Date_of_membership`, `agent_profile`.`First_name`, `agent_profile`.`Middle_Name`, `agent_profile`.`Last_name`, `branch_details`.`Branch_Name`, `packages`.`Plan_Code`, `installment_ledger`.`ORdate`, `installment_ledger`.`ORno`, `installment_ledger`.`Br_period_covered`, `installment_ledger`.`Installment_no_pc`, `installment_ledger`.`ORdate`
ORDER BY `agent_profile`.`AgentID`, 
	`agent_profile`.`Last_name`,
	`agent_profile`.`First_name`,

	`members_profile`.`Lname`, 
	`members_profile`.`Fname`, 
	`members_profile`.`Mname`
;";

//echo "$sql";

$res_data = mysqli_query($con,$sql); 
$max_entry = mysqli_num_rows($res_data);

$select_monthname = intToMonth($paramMonth);
$basedate = "$paramYear-$paramMonth-15";

//** FILL HEADER ------------------------------------------------------------
$objWorksheet->getCell('A4')->setValue("MEMBERS COLLECTED FOR THE MONTH OF ".strtoupper(intToMonth($paramMonth))." $paramYear");
$objWorksheet->getCell('B6')->setValue("BRANCH: $paramBranch");
$objWorksheet->getCell('G6')->setValue(intToMonth($paramMonth)." $paramYear");

	$entry_index = 0;
	$cnt=0;
	$entry_count = 1;
	$startrow=8;
	$page_number=1;
	$first_page_row_limit = 18;
	$middle_pages_row_limit = 24;
	$last_page_row_limit = 24;
	$total_amount_per_page = 0;
	$total_agent_share = 0;
	$total_branch_share = 0;
	$total_net_amount = 0;
	$current_agent = "";
	//echo "$sql";
	$objWorksheet->setBreak('L1',PHPExcel_Worksheet::BREAK_COLUMN);
	$first_header_agent_isset = 0;

	$break1=0;
	$break2=0;
	$break3=0;


	while ($r = mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {

	if ($trace_mode==1)	echo "<br>row: $cnt->";

		if ($first_header_agent_isset==0) {
//			$objWorksheet->getCell('C6')->setValue("AGENT: ".$r['Agent']);
			$objWorksheet->getCell('C6')->setValue($r['Agent']);
			$first_header_agent_isset=1;
			//echo "test!".$r['Agent'];
		}


		$total_amount_per_page+=$r['Amount'];
		$total_branch_share+=$r['branch_share'];
		$total_agent_share+=$r['agent_share'];
		$total_net_amount+=$r['net_remittance'];

		if ($current_agent <> "" 
			&& $current_agent <> $r['Agent'] 
			&& $entry_index > 0
			){
			$break1 = 1;


			//remove last added total becuase it belong to the next table 
			$total_amount_per_page-=$r['Amount'];
			$total_branch_share-=$r['branch_share'];
			$total_agent_share-=$r['agent_share'];
			$total_net_amount-=$r['net_remittance'];


			if ($trace_mode==1)	echo "Agent break [$entry_index/$max_entry]->";
			//add row break
			$objWorksheet->setBreak('A'.($startrow+$cnt),PHPExcel_Worksheet::BREAK_ROW);
			
			//print total amount per page
			$objWorksheet->getCell('H'.($startrow+$cnt))->setValue("TOTAL1: ");
			$objWorksheet->getCell('I'.($startrow+$cnt))->setValue($total_amount_per_page);
			$objWorksheet->getCell('K'.($startrow+$cnt))->setValue("Page $page_number");
			$classification = "";


			
			$array_remittance[] = array(
					"page_number" => $page_number, 
					"total_amount_per_page" => $total_amount_per_page, 
					"entry_count" => $entry_count-1,
					"classification" => $classification,
					"total_branch_share" => $total_branch_share,
					"total_agent_share" => $total_agent_share,
					"total_net_amount" => $total_net_amount
			);

			//fill color
			$objWorksheet->getStyle('H'.($startrow+$cnt).":K".($startrow+$cnt))->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFFC00');

			$current_agent = $r['Agent'];

			//separate each agent table 
			$cnt+=2;
			$objWorksheet->insertNewRowBefore($startrow+$cnt,2); 

			//copy header
			//MERGE
			$objPHPExcel->getActiveSheet()->mergeCells('C'.($startrow+$cnt-1).":F".($startrow+$cnt-1));
			$objPHPExcel->getActiveSheet()->mergeCells('G'.($startrow+$cnt-1).":K".($startrow+$cnt-1));

			//FONT SIZE TO 12
			//CENTER G-ROW1 & ALL-ROW2
 			$objPHPExcel->getActiveSheet()->getStyle('A'.($startrow+$cnt-1).":K".($startrow+$cnt))->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($startrow+$cnt-1).":K".($startrow+$cnt))->getFont()->setSize(12);
		    
		    $header_style1 = array(
		        'alignment' => array(
		            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        )
		    );
		    $objPHPExcel->getActiveSheet()->getStyle('G'.($startrow+$cnt-1))->applyFromArray($header_style1);
		    $objPHPExcel->getActiveSheet()->getStyle('A'.($startrow+$cnt).":K".($startrow+$cnt))->applyFromArray($header_style1);

			//set header
			$objWorksheet->getCell('B'.($startrow+$cnt-1))->setValue("BRANCH: ".$paramBranch);
			$objWorksheet->getCell('C'.($startrow+$cnt-1))->setValue("AGENT: ".$r['Agent']);
			$objWorksheet->getCell('G'.($startrow+$cnt-1))->setValue(intToMonth($paramMonth)." $paramYear");
			$objWorksheet->getRowDimension($startrow+$cnt-1)->setRowHeight(20);

			$objWorksheet->getCell('A'.($startrow+$cnt))->setValue("#");
			$objWorksheet->getCell('B'.($startrow+$cnt))->setValue("NAME");
			$objWorksheet->getCell('C'.($startrow+$cnt))->setValue("ADDRESS");
			$objWorksheet->getCell('D'.($startrow+$cnt))->setValue("DOI");
			$objWorksheet->getCell('E'.($startrow+$cnt))->setValue("AGENT");
			$objWorksheet->getCell('F'.($startrow+$cnt))->setValue("PT");
			$objWorksheet->getCell('G'.($startrow+$cnt))->setValue("PR DATE");
			$objWorksheet->getCell('H'.($startrow+$cnt))->setValue("PR #");
			$objWorksheet->getCell('I'.($startrow+$cnt))->setValue("AMT");
			$objWorksheet->getCell('J'.($startrow+$cnt))->setValue("PC");
			$objWorksheet->getCell('K'.($startrow+$cnt))->setValue("INS #");
			$objWorksheet->getRowDimension($startrow+$cnt)->setRowHeight(20);

			//add spacing & reset summission of total to 0
			$cnt+=1;

			$total_amount_per_page=0;
			$total_branch_share=0;
			$total_agent_share=0;
			$total_net_amount=0;
			$entry_count = 1;
			$page_number+=1;

			//return the original result.
			$total_amount_per_page+=$r['Amount'];
			$total_branch_share+=$r['branch_share'];
			$total_agent_share+=$r['agent_share'];
			$total_net_amount+=$r['net_remittance'];


		} else  if ((($cnt) == $first_page_row_limit) || 
			(($cnt) > $first_page_row_limit && ($entry_count-1) == $middle_pages_row_limit) ){
			if ($trace_mode==1)	echo "next page break->";
			$break2 = 1;
			//add row break
			$objWorksheet->setBreak('A'.($startrow+$cnt),PHPExcel_Worksheet::BREAK_ROW);
			
			//print total amount per page
			$objWorksheet->getCell('H'.($startrow+$cnt))->setValue("TOTAL2: ");
			$objWorksheet->getCell('I'.($startrow+$cnt))->setValue($total_amount_per_page);
			$objWorksheet->getCell('K'.($startrow+$cnt))->setValue("Page $page_number");
			$objWorksheet->getRowDimension($startrow+$cnt)->setRowHeight(20);

			$array_remittance[] = array(
					"page_number" => $page_number, 
					"total_amount_per_page" => $total_amount_per_page, 
					"entry_count" => $entry_count-1,
					"classification" => $classification,
					"total_branch_share" => $total_branch_share,
					"total_agent_share" => $total_agent_share,
					"total_net_amount" => $total_net_amount
			);

			$objWorksheet->getStyle('H'.($startrow+$cnt).":K".($startrow+$cnt))->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFFF00');

			//add spacing & reset summission of total to 0
			$cnt+=1;
			$total_amount_per_page=0;
			$total_branch_share=0;
			$total_agent_share=0;
			$total_net_amount=0;
			$entry_count = 1;
			$page_number+=1;
		} 

		$objWorksheet->getCell('A'.($startrow+$cnt))->setValue($entry_count);
		$objWorksheet->getCell('B'.($startrow+$cnt))->setValue($r['Member']);
		$objWorksheet->getCell('C'.($startrow+$cnt))->setValue($r['Address']);
		$objWorksheet->getCell('D'.($startrow+$cnt))->setValue(date_format(date_create($r['DOI']),"m/d/Y"));

		$objWorksheet->getCell('E'.($startrow+$cnt))->setValue($r['Agent_Initials']);
		$objWorksheet->getCell('F'.($startrow+$cnt))->setValue($r['Plan']);
		$objWorksheet->getCell('G'.($startrow+$cnt))->setValue($r['ORdate']);
		$objWorksheet->getCell('H'.($startrow+$cnt))->setValue($r['ORno']);
	
		$objWorksheet->getCell('I'.($startrow+$cnt))->setValue($r['Amount']);
		$objWorksheet->getCell('J'.($startrow+$cnt))->setValue($r['Br_period_covered']);
		$objWorksheet->getCell('K'.($startrow+$cnt))->setValue($r['Installment_no_pc']);
		$objWorksheet->getRowDimension($startrow+$cnt)->setRowHeight(20);

		$cnt+=1;
		$entry_count+=1;
		$entry_index+=1;

		if ($entry_index == $max_entry){
			if ($trace_mode==1)	echo "last page break->";
			$break3 = 1;

			//add row break
			$objWorksheet->setBreak('A'.($startrow+$cnt),PHPExcel_Worksheet::BREAK_ROW);
			
			//print total amount per page
			$objWorksheet->getCell('H'.($startrow+$cnt))->setValue("TOTAL3: ");
			$objWorksheet->getCell('I'.($startrow+$cnt))->setValue($total_amount_per_page);
			$objWorksheet->getCell('K'.($startrow+$cnt))->setValue("Page $page_number");

			$objWorksheet->getRowDimension($startrow+$cnt)->setRowHeight(20);
			$objWorksheet->getStyle('H'.($startrow+$cnt).":K".($startrow+$cnt))->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFFF00');

			$array_remittance[] = array(
					"page_number" => $page_number, 
					"total_amount_per_page" => $total_amount_per_page, 
					"entry_count" => $entry_count-1,
					"classification" => $classification,
					"total_branch_share" => $total_branch_share,
					"total_agent_share" => $total_agent_share,
					"total_net_amount" => $total_net_amount
			);


			//add spacing & reset summission of total to 0
			//$cnt+=1;
			//$total_amount_per_page=0;
			//$total_branch_share=0;
			//$total_agent_share=0;
			//$total_net_amount=0;
			//$entry_count = 1;
			//$page_number+=1;


		} 

		if ($current_agent == ""){
			$current_agent = $r['Agent'];
		}

	$break1=0;
	$break2=0;
	$break3=0;



	} //WHILE

		$last_row_number=($startrow+$cnt-1);
		//SET BORDERS
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

		$objPHPExcel->getActiveSheet()->getStyle("A$startrow:K$last_row_number")->applyFromArray($styleArray);
		unset($styleArray);

		//paper size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);

		//SET PRINT AREA
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea("A1:K".($last_row_number+1));

//** Remittance Report ------------------------------------------------------

$startrow = 9;
$objPHPExcel->setActiveSheetIndex(1);
$entry_index = 0;

//print_r($array_remittance);


	$objPHPExcel->getActiveSheet()->getCell('A6')->setValue("BRANCH: $paramBranch");

foreach ($array_remittance as $key ) {

	$objPHPExcel->getActiveSheet()->getCell('A'.($entry_index+$startrow))->setValue($key['page_number']);
	$objPHPExcel->getActiveSheet()->getCell('B'.($entry_index+$startrow))->setValue($key["total_amount_per_page"]);
	$objPHPExcel->getActiveSheet()->getCell('C'.($entry_index+$startrow))->setValue($key["entry_count"]);
	$objPHPExcel->getActiveSheet()->getCell('D'.($entry_index+$startrow))->setValue($key["classification"]);
	$objPHPExcel->getActiveSheet()->getCell('E'.($entry_index+$startrow))->setValue($key["total_branch_share"]);
	$objPHPExcel->getActiveSheet()->getCell('F'.($entry_index+$startrow))->setValue($key["total_agent_share"]);
	$objPHPExcel->getActiveSheet()->getCell('G'.($entry_index+$startrow))->setValue($key["total_net_amount"]);

	$entry_index+=1;
}

$objPHPExcel->setActiveSheetIndex(0);


//** LOAD -------------------------------------------------------------------


mysqli_free_result($res_data);
include '../dbclose.php';

$filename = "BR_$paramBranch-$paramMonth-$paramYear.xlsx";

if ($trace_mode!=1) {
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header("Content-Disposition: attachment;filename=\"$filename\"");
	header('Cache-Control: max-age=0'); 
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 2099 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
}	



//echo "$sql";


exit;




?>