<?php

$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'none');

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

	function writeText($x,$y, $text, $font='Arial',$style='', $size=11){
		$this->SetFont($font,$style,$size);
		$this->Cell($x);
		$this->Cell($x,$y,$text);
	}
}

$pdf = new PDF();



$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13




$pdf->SetFont('Arial','',10);

$pdf->Image('forms/185150.jpg',0,0,216,0,'','');
$pdf->SetLeftMargin(11);

#H L1 *

$pdf->SetFontSize(10);
$pdf->setXY(40,51);$pdf->write(5,"Lname");
$pdf->setXY(83,51);$pdf->write(5,"Fname");
$pdf->setXY(120,51);$pdf->write(5,"Mname");
$pdf->setXY(150,51);$pdf->write(5,"\"Nname\"");
$pdf->setXY(170,51);$pdf->write(5,"Sex");
$pdf->setXY(180,51);$pdf->write(5,"Status");

#H L2 *
$pdf->setXY(40,58.4);$pdf->write(5,"Member_Address");
$pdf->setXY(168,58.4);$pdf->write(5,"IDno");

#H L3 *
$pdf->setXY(27,66);$pdf->write(5,"Bdate");
$pdf->setXY(58.5,66);$pdf->write(5,"Age");
$pdf->setXY(87,66);$pdf->write(5,"Bplace");
$pdf->setXY(140,66);$pdf->write(5,"Occupation");
$pdf->setXY(179,66);$pdf->write(5,"religion");

#H L4 *
$pdf->setXY(35,71);$pdf->write(5,"pname");
$pdf->setXY(94,71);$pdf->write(5,"page");
$pdf->setXY(118,71);$pdf->write(5,"prelation");
$pdf->setXY(170,71);$pdf->write(5,"pcontactno");

#H L5 *
$pdf->setXY(40,75.6);$pdf->write(5,"CollectionAddress");
$pdf->setXY(165,75.6);$pdf->write(5,"mcontactno");

#H L6 *
$pdf->setXY(170,87);$pdf->write(5,"bcontactno");

#H L7 *
$pdf->setXY(86,92);$pdf->write(5,"bbdate");
$pdf->setXY(117,92);$pdf->write(5,"bage");
$pdf->setXY(140,92);$pdf->write(5,"brelation");
$pdf->setXY(179,92);$pdf->write(5,"religion"); //b_religion

#F L1 *
$pdf->setXY(15,261);$pdf->write(5,"agent_fullname");
$pdf->setXY(64,261);$pdf->write(5,"agent_id");
$pdf->setXY(95,261);$pdf->write(5,"agent"); //initial
$pdf->setXY(118,261);$pdf->write(5,"branch_manager");
$pdf->setXY(149,261);$pdf->write(5,"BManager_Initials");

#F L2 *
$pdf->setXY(40,271);$pdf->write(5,"ORdate");
$pdf->setXY(70,271);$pdf->write(5,"ORno");
$pdf->setXY(115,271);$pdf->write(5,"ORdate");
$pdf->setXY(147,271);$pdf->write(5,"ORno");
$pdf->setXY(187,271);$pdf->write(5,"amount");

#F L3 *
$pdf->setXY(88.2,278);$pdf->write(5,"ORdate");
$pdf->setXY(123,278);$pdf->write(5,"CollectionAddress");



$pdf->Output('I','policy.pdf');

?>
