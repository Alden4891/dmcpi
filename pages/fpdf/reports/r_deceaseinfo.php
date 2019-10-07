<?php

$from = (isset($_REQUEST['from'])?$_REQUEST['from']:'none');
$to = (isset($_REQUEST['to'])?$_REQUEST['to']:'none');


require('../fpdf/fpdf.php');

class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
	// HTML parser
	$html = str_replace("\n",' ',$html);
	$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
	foreach($a as $i=>$e)
	{
		if($i%2==0)
		{
			// Text
			if($this->HREF)
				$this->PutLink($this->HREF,$e);
			else
				$this->Write(5,$e);
		}
		else
		{
			// Tag
			if($e[0]=='/')
				$this->CloseTag(strtoupper(substr($e,1)));
			else
			{
				// Extract attributes
				$a2 = explode(' ',$e);
				$tag = strtoupper(array_shift($a2));
				$attr = array();
				foreach($a2 as $v)
				{
					if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
						$attr[strtoupper($a3[1])] = $a3[2];
				}
				$this->OpenTag($tag,$attr);
			}
		}
	}
}

function OpenTag($tag, $attr)
{
	// Opening tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,true);
	if($tag=='A')
		$this->HREF = $attr['HREF'];
	if($tag=='BR')
		$this->Ln(5);
}

function CloseTag($tag)
{
	// Closing tag
	if($tag=='B' || $tag=='I' || $tag=='U')
		$this->SetStyle($tag,false);
	if($tag=='A')
		$this->HREF = '';
}

function SetStyle($tag, $enable)
{
	// Modify style and select corresponding font
	$this->$tag += ($enable ? 1 : -1);
	$style = '';
	foreach(array('B', 'I', 'U') as $s)
	{
		if($this->$s>0)
			$style .= $s;
	}
	$this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
	// Put a hyperlink
	$this->SetTextColor(0,0,255);
	$this->SetStyle('U',true);
	$this->Write(5,$txt,$URL);
	$this->SetStyle('U',false);
	$this->SetTextColor(0);
}
}

$html = '';

$pdf = new PDF();
// First page

$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13


    $pdf->SetFont('Arial','UB',15);
    $pdf->Cell(80);
    $pdf->Cell(30,10,'DECEASED INFORMATION',0,0,'C');
    $pdf->Ln(20);
	
	$pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,'Date: ________________________________________________________________________________ ',0,1);
    $pdf->Cell(0,10,'Name: _______________________________________________________________________________ ',0,1);
    $pdf->Cell(0,10,'Address: _____________________________________________________________________________ ',0,1);
    $pdf->Cell(0,10,'Date of birth: __________________________________________________________________________ ',0,1);
    $pdf->Cell(0,10,'Date of death: _________________________________________________________________________ ',0,1);
    $pdf->Cell(0,10,'Plan type: __________________________________ Status: ____________________________________ ',0,1);
    $pdf->Cell(0,10,'Beneficiary: ________________________________ Relation: __________________________________ ',0,1);

    $pdf->Ln(10);

	$pdf->SetFont('Times','U',12);
    $pdf->Cell(80);
    $pdf->Cell(30,10,'"WE LOVE YOU AND WE WILL BE MISSING YOU FOREVER"',0,0,'C');
    $pdf->Ln(10);
    $pdf->Cell(0,10,'                                              ',0,0,'C');


    $pdf->Ln(20);
	$pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,'WIFE/HUSBAND: ______________________________________            GRAND CHILDREN :',0,1);
    $pdf->Cell(0,5,'CHILDREN:',0,1);


    $pdf->Ln(120);
    $pdf->Cell(0,5,'I hereby certify that all information above is true and correct.',0,1);
    $pdf->Ln(10);
    $pdf->Cell(0,10,'_____________________________',0,0,'R');
    $pdf->Cell(0,20,'Signature over printed name      ',0,0,'R');



$pdf->Output('I','deceased_information.pdf');
?>
