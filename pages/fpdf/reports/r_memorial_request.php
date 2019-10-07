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

$html = 'You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';

$pdf = new PDF();
// First page

$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13
$pdf->SetFont('Arial','',10);

//$pdf->Write(5,"Date: ________________ \n\n");
$pdf->WriteHTML("
Date: ___________<br><br>
<b>THE MANAGER</b><br>
DMCSM<br>
Koronadal City<br>
<br>
Sir/Ma'am:<br><br>I would like to request in your good office to please render the memorial services of late ______________________ of Purok ______________________ Barangay _______________  Municipality of  ______________ Died last ______________ in ______________ his/her birthaday is ______________ enclosed herewith his/her death certificate. <br><br>
I choose memorial services worth P __________________________<br>
Type of casket __________________________<br>
Days of embalming __________________________<br>
memorial discount __________________________<br>
Others ______________________________________________________________________________________<br>
______________________________________________________________________________________<br>

 <br>
<b>Net amount payable P</b> _____________________________<br><br><b>Conditions:</b><br><br>    1. That the remaining net payable will be paid 3 days before burial date.
    <br>    2. That, we will provide the following documents required by the office 3 days after signing the contract

 <br><pre>      </pre>        * Policy
 <br><pre>      </pre>        * Receipt
 <br><pre>      </pre>        * Kapag sa Ospital namatay mag dala nang Physical Statement
 <br><pre>      </pre>        * Death Certificate na rehistrado sa Local Civil Registrar
<br><pre>      </pre>        * Kapag sa bahay namatay magdala ng Barangay Certificate
<br><pre>      </pre>        * Magdala ng dalawang xerox kopya ng valid ID's
<br><pre>      </pre>        * <u>Para sa asawa na makikinabang</u>

<br><pre>                   </pre>        > Mag dala ng Marriage Contract at kung walang Marriage Contract Certification na lang sa baranggay
<br><pre>                             </pre>na kayo'y mag asawa.

<br><pre>      </pre>        * <u>Para sa mga anak, kapatid na lalaki at kapatid na babae na makikinanabang</u>

<br><pre>                   </pre>        > Mag dala ng Birth Certificate ng makikinanabang


<br><pre>      </pre>        * <u>Ang makikinabang ay pipirma sa mga sumusunod na mga dokumento</u>

<br><pre>      </pre>                     a.       Release Waiver and Quit Claim
<br><pre>      </pre>                     b.       Acknowledgement of Benefits
<br><pre>      </pre>                     c.       Claimant Statement




 <br>    3. That before requesting burial services be sure that your schedule has beed approved by DMCSM office 10 days before 
        burial.
 <br>    4. Final request for burial services should be done in the office of DMCSM 7 days before burial.
 <br>    5. That, the company is not liable of any failure of services if we fail to comply even one of the conditions stated above.

             <br><b><pre>                </pre>I HEREBY ACKNOWLEDGE THAT I HAVE RECEIVED THE STEPS IN FILLING BURIAL SCHEDULE FROM DIAMOND MEMORIAL CARE OFFICE. I UNDERSTAND THAT IF I FAIL TO FOLLOW THE STEPS WE ARE WILLING TO PAY AN ADDITIONAL PAYMENT OF PHP 2,500.00 MINIMUM (DEPEND UPPON THE DISTANCE) FOR BURIAL SERVICES.</b><br>
 <br>
Memorial services requested by ____________________________ Relation: ______________ CP No. ______________<br>
                                                        (Signature over printed name)<br><br>
<b>NOTE: MEMORIAL SERVICES SHOULD BE REQUESTED BY THE IMMEDIATE FAMILY</b><br><br><br>
Interview conducted by: ____________________________            Approved by: ____________________________<br>

	");



/*
$pdf->SetX(10);
$pdf->MultiCell(190,4,"",0,'J',0);

$pdf->SetFont('','U');
$link = $pdf->AddLink();
$pdf->Write(5,'',$link);
$pdf->SetFont('');


// Second page
$pdf->AddPage();
$pdf->SetLink($link);
$pdf->Image('logo.png',10,12,30,0,'','http://www.fpdf.org');
$pdf->SetLeftMargin(11);
$pdf->SetFontSize(14);
$pdf->WriteHTML($html);
*/


$pdf->Output('I','policy.pdf');

?>
