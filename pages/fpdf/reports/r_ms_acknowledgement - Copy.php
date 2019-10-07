<?php

$from = (isset($_REQUEST['from'])?$_REQUEST['from']:'none');
$to = (isset($_REQUEST['to'])?$_REQUEST['to']:'none');


require('../fpdf.php');

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


    $pdf->SetFont('Times','B',15);
    $pdf->Cell(80);
    $pdf->Cell(30,10,'ACKNOWLEDGEMENT OF MEMORIAL SERVICES RENDERED',0,0,'C');
    $pdf->Ln(20);
	
	$pdf->SetFont('Arial','',11);
    $pdf->Cell(50,10,'DATE OF DECEASED: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(0,-10,'_____________________________________________________________',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'ADDRESS: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'_____________________________________________________________',0,1);


	$pdf->Ln(6);
    $pdf->Cell(50,10,'DATE DIED: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'_______________ BM: ________________ AGENT: __________________',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'CONTACT PERSON: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'_______________ RELATION: ____________ CONTACT#: ____________',0,1);


	$pdf->Ln(6);
    $pdf->Cell(50,10,'DATE PULL-OUT: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'____________________ PULLED-OUT BY: _________________________',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'DATE DELIVERED: ',0,1);
    $pdf->setX(70);
   $pdf->Cell(80,-10,'____________________ DELIVERED BY: __________________________',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'BURIAL DATE: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'____________________  ',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'IMBALMED AT: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'____________________',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'# OF DAYS OF EMBALMING: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'____________________',0,1);

	$pdf->Ln(6);
    $pdf->Cell(50,10,'EMBALMED BY: ',0,1);
    $pdf->setX(70);
    $pdf->Cell(80,-10,'____________________',0,1);


	$pdf->Ln(20);
    $pdf->Cell(50,10,'NOTE:',0,1);
    $pdf->setX(114);
    $pdf->Cell(80,-10,'NET PAY:',0,1);


    //-----------------------------------------------------------------------------------]
    $pdf->setXY(114,66);    $pdf->Cell(0,10,'Plan Type',0,1);    
    $pdf->SetTextColor(255,0,0);	//rbg color red
    $pdf->setXY(140,66);    $pdf->Cell(0,10,'<Plan Type>  ',0,1);

	$pdf->SetTextColor(0);
    $pdf->setXY(114,66+6);    $pdf->Cell(0,10,'Casket',0,1);    
    $pdf->setXY(140,66+6);    $pdf->Cell(0,10,'<casket type>  ',0,1);


    
    $pdf->SetFont('Arial','',9);
	$pdf->setXY(114,77);$pdf->Cell(0,10,'tarpaulin/Flower/Vigil Prayer',0,1,'C');  
	$pdf->setXY(114,77);$pdf->Cell(0,10+10,'Burial Service/D-attire/1 Dispenser',0,1,'C');  
	$pdf->setXY(114,77);$pdf->Cell(0,10+20,'10 Gallons water/M-lapida',0,1,'C');  
	$pdf->setXY(114,77);$pdf->Cell(0,10+30,'Fresh flower upon delivery',0,1,'C');  

    $pdf->SetFont('Arial','',11);
	$pdf->setXY(114,77);$pdf->Cell(0,100,'SERVICE ACKNOWLEDGE BY:',0,1,'C');  
	$pdf->setXY(114,77);$pdf->Cell(0,115,'_____________________________',0,1,'C');  
	$pdf->setXY(114,77);$pdf->Cell(0,125,'DATE: ________TIME: _________',0,1,'C');  

	$pdf->Output();
?>
