<?php
ini_set('display_errors', 1);
include '../../dbconnect.php';

include '../../dbclose.php';
$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'none');
$link = mysql_connect($con_host,$con_username,$con_password);
mysql_select_db($con_database);



$res_data = mysql_query("

SELECT DISTINCT
  `members_profile`.`Member_Code`        AS `Member_Code`,
  `members_profile`.`Fname`              AS `Fname`,
  `members_profile`.`Mname`              AS `Mname`,
  `members_profile`.`Lname`              AS `Lname`,
  ((((`members_profile`.`Lname` + ',  ') + `members_profile`.`Fname`) + ' ') + `members_profile`.`Mname`) AS `Fullname`,
  `members_profile`.`Nname`              AS `Nname`,
  `members_profile`.`Sex`                AS `Sex`,
  `members_profile`.`Status`             AS `Status`,
  `members_profile`.`Address`            AS `Address`,
  `members_profile`.`IDno`               AS `IDno`,
  `members_profile`.`Bdate`              AS `Bdate`,
  `members_profile`.`Age`                AS `Age`,
  `members_profile`.`Bplace`             AS `Bplace`,
  `members_profile`.`Occupation`         AS `Occupation`,
  `members_profile`.`Religion`           AS `religion`,
  `members_profile`.`Pname`              AS `pname`,
  `members_profile`.`Page`               AS `page`,
  `members_profile`.`Prelation`          AS `prelation`,
  `members_profile`.`Pcontactno`         AS `pcontactno`,
  `members_profile`.`CAddress`           AS `CollectionAddress`,
  `members_profile`.`Mcontactno`         AS `mcontactno`,
  `members_profile`.`Bname`              AS `bname`,
  `members_profile`.`Bbdate`             AS `bbdate`,
  `members_profile`.`Bage`               AS `bage`,
  `members_profile`.`Brelation`          AS `brelation`,
  `members_profile`.`Bstatus`            AS `bstatus`,
  `members_profile`.`Bcontactno`         AS `bcontactno`,
  `members_profile`.`Dname1`             AS `dname1`,
  `members_profile`.`Dbdate1`            AS `dbdate1`,
  `members_profile`.`Dage1`              AS `dage1`,
  `members_profile`.`Drelation1`         AS `drelation1`,
  `members_profile`.`Dstatus1`           AS `dstatus1`,
  `members_profile`.`Dname2`             AS `dname2`,
  `members_profile`.`Dbdate2`            AS `dbdate2`,
  `members_profile`.`Dage2`              AS `dage2`,
  `members_profile`.`Drelation2`         AS `drelation2`,
  `members_profile`.`Dstatus2`           AS `dstatus2`,
  `members_profile`.`Dname3`             AS `dname3`,
  `members_profile`.`Dbdate3`            AS `dbdate3`,
  `members_profile`.`Dage3`              AS `dage3`,
  `members_profile`.`Drelation3`         AS `drelation3`,
  `members_profile`.`Dstatus3`           AS `dstatus3`,
  `members_profile`.`Dname4`             AS `dname4`,
  `members_profile`.`Dbdate4`            AS `dbdate4`,
  `members_profile`.`Dage4`              AS `dage4`,
  `members_profile`.`Drelation4`         AS `drelation4`,
  `members_profile`.`Dstatus4`           AS `dstatus4`,
  `packages`.`Plan_Code`                 AS `plan_code`,
  `packages`.`form_number`               AS `form_number`,
  `members_account`.`No_of_units`        AS `no_of_units`,
  `agent_profile`.`Initials`             AS `agent`,
  `agent_profile`.`AgentID`              AS `agent_id`,
  CONCAT(`agent_profile`.`First_name`,' ',LEFT(`agent_profile`.`Middle_Name`,1),'. ',`agent_profile`.`Last_name`) AS `agent_fullname`,
  `members_account`.`Insurance_Type`     AS `insurance_type`,
  `members_account`.`Date_of_membership` AS `date_of_membership`,
  `members_account`.`Current_term`       AS `current_term`,
  `members_account`.`Account_Status`     AS `account_status`,
  `members_account`.`Remarks`            AS `remarks`,
  `agent_profile_ao`.`Initials`          AS `AO`,
  `bd`.`Branch_Manager`                  AS `branch_manager`,
  `bd`.`BManager_Initials`               AS `BManager_Initials`,
  `members_account`.`PRdate`             AS `PRdate`,
  `members_account`.`PRno`               AS `PRno`,
  `members_account`.`ORdate`             AS `ORdate`,
  `members_account`.`ORno`               AS `ORno`,
  `members_account`.`Amount`             AS `amount`,
  `agentfullname`.`An`                   AS `AgentName`,
  `aofullname`.`An`                      AS `AOname`,
  `planname`.`Plan_name`                 AS `plan_name`,
  `bd`.`Branch_Name`                     AS `Branch_name`,
  `packages`.`Plan_id`                   AS `Plan_id`
FROM `branch_details`
JOIN `members_account`
JOIN `branch_details` `bd`
ON `members_account`.`BranchManager` = `bd`.`Branch_ID`
JOIN `agent_profile`
ON `members_account`.`AO` = `agent_profile`.`AgentID`
JOIN `agent_profile` `agent_profile_ao`
ON `members_account`.`AgentID` = `agent_profile_ao`.`AgentID`
JOIN `packages`
ON `members_account`.`Plan_id` = `packages`.`Plan_id`
JOIN `members_profile`
ON `members_account`.`Member_Code` = `members_profile`.`Member_Code`
JOIN `agentfullname`
ON `members_account`.`Member_Code` = `agentfullname`.`Member_Code`
JOIN `aofullname`
ON `members_account`.`Member_Code` = `aofullname`.`Member_Code`
JOIN `planname`
ON `members_account`.`Member_Code` = `planname`.`Member_Code`
WHERE `members_account`.Member_Code = '$Member_Code'

",$link);
$r=mysql_fetch_array($res_data,MYSQLI_ASSOC);
$form_number = $r['form_number']; 
$Plan_id = $r['Plan_id']; 
//echo "$form_number $Plan_id";

if ($form_number == ''){
	echo "Template not found! Please Upload your Policy Form tempalte."  ;
	return;
}

$res_variables = mysql_query("SELECT * FROM form_details WHERE Plan_id = '$Plan_id'",$link);

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
	function validateDate($date, $format = 'Y-m-d')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
	    return $d && $d->format($format) === $date;
	}

}


$pdf = new PDF();


$pdf->AddPage('P',Array(215.9, 330.2)); //8.5x13
$pdf->Image("forms/$form_number.jpg",0,0,216,0,'','');
$pdf->SetLeftMargin(11);



while ($rr=mysql_fetch_array($res_variables,MYSQL_NUM)) {

        $id 		= $rr[0];
        $field 		= $rr[2];
        $font 		= $rr[3];
        $font_size 	= $rr[4];
        $font_style = $rr[5];
        $x 			= $rr[6];
        $y 			= $rr[7];

        //echo $r[$field]."<br>";

        $label = $r[$field];

        //check label is a date 
		if ($pdf->validateDate($label)){
			$label=date( "m/d/Y", strtotime($label));
		}else if ($field == 'Sex'){
			$label = substr($label, 0,1);
		}
		$label = strtoupper($label);

$pdf->SetFont($font,$font_style,$font_size);
$pdf->SetFontSize($font_size);
$pdf->setXY($x,$y);$pdf->write(5,$label);

}

$pdf->Output('I','policy.explode(delimiter, string)');
	

mysql_free_result($res_data);
mysql_close($link);



?>
