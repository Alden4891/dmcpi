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
$offset = 0;
	for ($i=0;$i<2;$i++){
		$offset = 155 * $i;
		if ($i == 1) {
			$pdf->setY(165);
		}

		$pdf->Image('./images/header.jpg',10,12+$offset,195,20,'','http://www.fpdf.org');

	    $pdf->SetFont('Times','B',15);
	    $pdf->Cell(80);
	    $pdf->Cell(30,10+45,'ACKNOWLEDGEMENT OF MEMORIAL SERVICES RENDERED',0,0,'C');
	    $pdf->Ln(15);
		
		$pdf->SetFont('Arial','',10);
	    $pdf->Cell(50,9+45,'DATE OF DECEASED: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(0,-9-45,'_____________________________________________________________',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'ADDRESS: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'_____________________________________________________________',0,1);


		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'DATE DIED: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'_______________ BM: ________________ AGENT: __________________',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'CONTACT PERSON: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'_______________ RELATION: ____________ CONTACT#: ____________',0,1);


		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'DATE PULL-OUT: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'____________________ PULLED-OUT BY: _________________________',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'DATE DELIVERED: ',0,1);
	    $pdf->setX(70);
	   $pdf->Cell(80,-9-45,'____________________ DELIVERED BY: __________________________',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'BURIAL DATE: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'____________________  ',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'IMBALMED AT: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'____________________',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'# OF DAYS OF EMBALMING: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'____________________',0,1);

		$pdf->Ln(6);
	    $pdf->Cell(50,9+45,'EMBALMED BY: ',0,1);
	    $pdf->setX(70);
	    $pdf->Cell(80,-9-45,'____________________',0,1);


		$pdf->Ln(20);
	    $pdf->Cell(50,9+35,'NOTE:',0,1);
	    $pdf->setX(114);
	    $pdf->Cell(80,-9-35,'NET PAY:',0,1);


	    //-----------------------------------------------------------------------------------]
	    $pdf->setXY(114,66+18+$offset);    $pdf->Cell(0,9,'Plan Type',0,1);    
	    $pdf->SetTextColor(255,0,0);	//rbg color red
	    $pdf->setXY(140,66+18+$offset);    $pdf->Cell(0,9,'<Plan Type>  ',0,1);

		$pdf->SetTextColor(0);
	    $pdf->setXY(114,72+18+$offset);    $pdf->Cell(0,9,'Casket',0,1);    
	    $pdf->setXY(140,72+18+$offset);    $pdf->Cell(0,9,'<casket type>  ',0,1);


	    
	    $pdf->SetFont('Arial','',9);
		$pdf->setXY(114,77+18+$offset);$pdf->Cell(0,9,'tarpaulin/Flower/Vigil Prayer',0,1,'C');  
		$pdf->setXY(114,81+18+$offset);$pdf->Cell(0,9,'Burial Service/D-attire/1 Dispenser',0,1,'C');  
		$pdf->setXY(114,85+18+$offset);$pdf->Cell(0,9,'10 Gallons water/M-lapida',0,1,'C');  
		$pdf->setXY(114,89+18+$offset);$pdf->Cell(0,9,'Fresh flower upon delivery',0,1,'C');  

	    $pdf->SetFont('Arial','',11);
		$pdf->setXY(114,117+12+$offset);$pdf->Cell(0,9,'SERVICE ACKNOWLEDGE BY:',0,1,'C');  
		$pdf->setXY(114,127+12+$offset);$pdf->Cell(0,9,'_____________________________',0,1,'C');  
		$pdf->setXY(114,133+12+$offset);$pdf->Cell(0,9,'DATE: ________TIME: _________',0,1,'C');  


	}

	$pdf->Output('I','acknowledgement_of_service.pdf');
?>
