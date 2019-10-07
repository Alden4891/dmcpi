<?php
require('mysql_table.php');

$year = isset($_REQUEST['year'])?$_REQUEST['year']:'';
$month = isset($_REQUEST['month'])?$_REQUEST['month']:'';
$sub_totals = isset($_REQUEST['sub_totals'])?$_REQUEST['sub_totals']:'';
$user_fullname = isset($_REQUEST['user'])?$_REQUEST['user']:'';

$sub_totals = explode("|", $sub_totals);
$sub_gross = $sub_totals[0];
$sub_basiccom= $sub_totals[1];
$sub_net= $sub_totals[2];

$sub_nsgross= $sub_totals[3];
$sub_nsbasiccom= $sub_totals[4];
$sub_nsnet= $sub_totals[5];

class PDF extends PDF_MySQL_Table
{
function Header($month=9,$year=2018)
{
    $monthName = strtoupper(date("F", mktime(0, 0, 0, $month, 10)));
    $this->Image('./images/header.jpg',10.9,12,194,20,'','http://dmcpi.com');


    // Title
    $this->SetFont('Arial','B',8);
    $this->Ln(23);
    $this->Cell(0,6,"STATEMENT OF OPERATION FOR THE MONTH OF $monthName $year",0,1,'C');
   // $this->Ln(10);
    $this->SetFont('Arial','',8);
    $this->Cell(0,6,'(BASED ON PARTIAL CUT OFF MCRP)',0,1,'C');
    $this->Ln(5);

    // Ensure table header is printed
    // parent::Header();
}
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }
}

include "../../dbconnect.php";
// Connect to database

$pdf = new PDF();
$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13
$pdf->Header($month,$year);


$pdf->SetFont('Times','',8);   
$pdf->AddCol('Branch_Name',28+15,'BRANCH','L');
$pdf->AddCol('Branch_Head',28+15,'BRANCH HEAD','L');
$pdf->AddCol('Gross',18,'GROSS SUB.','R');
$pdf->AddCol('Basic_Com',18,'BASIC COM.','R');
$pdf->AddCol('Net_Amount',18,'NET.','R');
$pdf->AddCol('NS_Gross',18,'GROSS SUB.','R');
$pdf->AddCol('NS_Basic_Com',18,'BASIC COM.','R');
$pdf->AddCol('NS_Net_Amount',18,'NET.','R');

$prop = array('HeaderColor'=>array(255,150,100),
            'color1'=>array(255,255,255),
            'color2'=>array(255,255,255),
            'padding'=>0);
$pdf->Table($con,"call sp_soo_bybm($year,$month);",$prop);

$pdf->SetFont('Arial','B',8);
$pdf->Ln(5);

$pdf->Cell(28,6,"",0,0,'L');
$pdf->Cell(28,6,"",0,0,'L');
$pdf->Cell(30,6,"TOTAL: ",0,0,'R');

$pdf->Cell(18,6,"$sub_gross",0,0,'R');
$pdf->Cell(18,6,"$sub_basiccom",0,0,'R');
$pdf->Cell(18,6,"$sub_net",0,0,'R');

$pdf->Cell(18,6,"$sub_nsgross",0,0,'R');
$pdf->Cell(18,6,"$sub_nsbasiccom",0,0,'R');
$pdf->Cell(18,6,"$sub_nsnet",0,0,'R');

$pdf->Ln(20);
$pdf->SetFont('Arial','',8);
$pdf->Cell(28,6,"PREPARED BY:",0,0,'L');
$pdf->Cell(60,6,"",0,0,'L');
$pdf->Cell(28,6,"APPROVED BY:",0,0,'L');

$pdf->Ln(10);
$pdf->Cell(20,6,"",0,0,'L');
$pdf->Cell(28,6,strtoupper($user_fullname),0,0,'L');
$pdf->Cell(60,6,"",0,0,'L');
$pdf->Cell(28,6,"MERLYN SUPERIO",0,0,'L');

$pdf->Ln(10);
$pdf->Cell(23,6,"",0,0,'L');
$pdf->Cell(28,6,"FINANCE HEAD",0,0,'L');
$pdf->Cell(56,6,"",0,0,'L');
$pdf->Cell(28,6,"GENERAL MANAGER",0,0,'L');

$pdf->Output();
include "../../dbclose.php";

?>


