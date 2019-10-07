
<?php


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











require('mysql_table.php');

class PDF extends PDF_MySQL_Table
{
function Header()
{
    // Title
    $this->SetFont('Arial','',18);
    $this->Cell(0,6,'MCPR Report',0,1,'C');
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
$pdf->AddPage('L',Array(215.9, 330.2)); //8.5x13

$pdf->SetFont('Times','',10);   
//$pdf->AddPage('L','A4'); 

$pdf->AddCol('Member_Code',20,'PR#','L');
$pdf->AddCol('Fullname',60,'Name','L');
$pdf->AddCol('Address',80,'','L');
$pdf->AddCol('Agent',20,'','L');
$pdf->AddCol('Plan_Code',20,'Plan','L');
$pdf->AddCol('Amt_Due',20,'Amt. Due','L');
$pdf->AddCol('Over_Due',20,'Over Due','L');
$pdf->AddCol('OrDate',20,'O.R. Date','L');
$pdf->AddCol('OrNo',20,'O.R. No.','L');
$pdf->AddCol('Rec_Amt',20,'Amount','L');


$prop = array('HeaderColor'=>array(255,150,100),
            'color1'=>array(210,245,255),
            'color2'=>array(255,255,210),
            'padding'=>2);
$pdf->Table($link,"SELECT * FROM mcpr_report WHERE Installment_Period_Covered = 'Nov' AND Installment_Period_Year = 2018 ORDER BY member_code, ordate",$prop);
$pdf->Output();
?>


