<?php
require('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
function Header()
{
    // Title
    $this->SetFont('Arial','',18);
    $this->Cell(0,6,'Branch Report',0,1,'C');
   // $this->Ln(10);
    $this->SetFont('Arial','',10);
    $this->Cell(0,6,'Collection as of May 2018',0,1,'C');
    $this->Ln(10);

    // Ensure table header is printed
    parent::Header();
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

// Connect to database
$link = mysqli_connect('localhost','root','pass@word1','dmcsm');

$pdf = new PDF();
$pdf->SetFont('Arial','',10);   
//$pdf->AddPage('L',Array(215.9, 330.2)); //8.5x13
$pdf->AddPage('L','A4'); 

// First table: output all columns
//$pdf->Table($link,"SELECT * FROM branch_report WHERE period_year=2013 and period_Covered='May' ORDER BY prdate");
//$pdf->AddPage();
// Second table: specify 3 columns
$pdf->AddCol('Fullname',80,'Name','L');
$pdf->AddCol('Plan_Code',25,'Plan','C');
$pdf->AddCol('Agent',20,'Agent','C');
$pdf->AddCol('Member_Code',30,'Mem. Code','L');
$pdf->AddCol('Br_Installment_No',10,'Ins','L');
$pdf->AddCol('Br_Period_Covered',20,'Br Cov.','L');
$pdf->AddCol('PRdate',30,'PR Date','L');
$pdf->AddCol('PRno',20,'PR#','L');
$pdf->AddCol('Br_Amt',20,'Amount','R');
//$pdf->AddCol('Period_Year',20,'Year','C');
//$pdf->AddCol('Period_Covered',20,'Month','C');


$prop = array('HeaderColor'=>array(255,150,100),
            'color1'=>array(210,245,255),
            'color2'=>array(255,255,210),
            'padding'=>2);
$pdf->Table($link,"SELECT * FROM branch_report WHERE period_year=2013 and period_Covered='May' ORDER BY prdate",$prop);
$pdf->Output();
?>


