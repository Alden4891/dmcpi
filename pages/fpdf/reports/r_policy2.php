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

include '../../dbconnect.php';
$Member_Code = (isset($_REQUEST['Member_Code'])?isset($_REQUEST['Member_Code']):'');
$res_data = mysqli_query($con,"SELECT * FROM membership_form WHERE Member_Code = '$Member_Code'");

$r=mysqli_fetch_array($res_data,MYSQLI_ASSOC);

$form_number = 'N'.$r['formq_number']; 
$Plan_id = 'P'.$r['Plan_id']; 
echo "$form_number $Plan_id";

/*
$res_variables = mysqli_query($con,"SELECT * FROM form_details WHERE Plan_id = '$Plan_id'");

$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13
$pdf->Image("forms/$form_number.jpg",0,0,216,0,'','');
$pdf->SetLeftMargin(11);

while ($r=mysqli_fetch_array($res_variables,MYSQLI_NUM)) {

        $id = $r['id'];
        $field = $r['field'];
        $font = $r['font'];
        $font_size = $r['font_size'];
        $font_style = $r['font_style'];
        $x = $r['x'];
        $y = $r['y'];




}
$pdf->SetFont('Arial','',10);
$pdf->SetFontSize(10);
$pdf->setXY(40,51);$pdf->write(5,'['.$form_number.']');
$pdf->Output('I','policy.explode(delimiter, string)');
//-------------------------------------------------------------------------------------
*/


$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13
$pdf->SetLeftMargin(11);


$str = "Lname,Arial,10,,40,51|Fname,Arial,10,,38,51";
$str = explode("|", $str);
foreach ($str as $key => $value) {
	
	$str2 = explode(",", $value);
	$label =  $str2[0];
	$font =   $str2[1];
	$fsize =  $str2[2];
	$fstyle = $str2[3];
	$xcoor =  $str2[4];
	$ycoor =  $str2[5];



	$pdf->SetFont($font,'',10);
	$pdf->SetFontSize($fsize);
	$pdf->setXY($xcoor,$ycoor);$pdf->write(5,$label);
}

	$pdf->Output('I','policy.pdf');

//echo $str[0];

//$pdf->SetFont('Arial','',10);
//$pdf->SetFontSize(10);
//$pdf->setXY(40,51);$pdf->write(5,'['.$form_number.']');
//$pdf->Output('I','policy.pdf');

	

mysqli_free_result($res_data);
include '../../dbclose.php';



?>
