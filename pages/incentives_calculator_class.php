<?php


class incentives_calculator { 

	/**
	 * Sets up the default properties
	 */

	var $PLAN_ID = 0;
	var $BM_ID = 0;
	var $AGENT_ID  = 0;
	var $COSTANT_COMPUTATION  = 0;
	var $MAINOFFICE = 0;
	var $BM_SHARE_AMOUNT = 0;
	var $AG_SHARE_AMOUNT = 0;
	var $BM_SHARE_RATE = 0;
	var $AG_SHARE_RATE = 0;
	var $BM_SHARE_FIXED_AMOUNT=0;
	var $AG_SHARE_FIXED_AMOUNT=0;
	var $BM_SHARE_COMP_MODE = '';
	var $AG_SHARE_COMP_MODE = '';
	var $SHARE_COMP_SQL = '';
	var $MODE_OF_COMPUTATION = '';
	var $SHARE_COMP_SQL_ROW='';
	var $SHARE_COMP_SQL_ROWS='';
	var $comp_date = '';
	var $amount = 0;
	var $month = 'Jan';
	var $year = 0;
	var $last_installment_no = 0;
	var $next_installment_no = 0;
	var $Period_No = 0;
	var $term  = 0;
	var $db_Const_Agent_Share = 0;
	var $db_Const_BM_Share = 0;
	var $db_BM_Share_1st=0;
	var $db_Agent_Share_1st=0;
	var $db_BM_Share_2nd=0;
	var $db_Agent_Share_2nd=0;
	var $sql = '';



	public function __construct() {
		@ini_set( 'memory_limit', -1);
		@set_time_limit( 0 );		
		
		$this->PLAN_ID = 0;
		$this->BM_ID = 0;
		$this->AGENT_ID  = 0;
		$this->COSTANT_COMPUTATION  = 0;
		$this->MAINOFFICE = 0;

		$this->BM_SHARE_AMOUNT = 0;
		$this->AG_SHARE_AMOUNT = 0;

		$this->BM_SHARE_RATE = 0;
		$this->AG_SHARE_RATE = 0;
		$this->BM_SHARE_FIXED_AMOUNT=0;
		$this->AG_SHARE_FIXED_AMOUNT=0;
		$this->BM_SHARE_COMP_MODE = '';
		$this->AG_SHARE_COMP_MODE = '';
		$this->SHARE_COMP_SQL = '';
		$this->MODE_OF_COMPUTATION = '';
		$this->SHARE_COMP_SQL_ROW='';
		$this->SHARE_COMP_SQL_ROWS='';

		$this->comp_date = date('Y-m-15');
		$this->amount = 0;
		$this->month = 'Jan';
		$this->year = 0;
		$this->last_installment_no = 0;
		$this->next_installment_no = 0;

		$this->Period_No = 0;
		$this->term  = 0;

		//set property
		$this->db_Const_Agent_Share = 0;
		$this->db_Const_BM_Share = 0;
		$this->db_BM_Share_1st=0;
		$this->db_Agent_Share_1st=0;
		$this->db_BM_Share_2nd=0;
		$this->db_Agent_Share_2nd=0;


		$this->sql = '';

	}

	public function compute(){
		$this->month = date('M', strtotime("+0 month", strtotime($this->comp_date)));
		$this->year  = date('Y', strtotime("+0 month", strtotime($this->comp_date))); //YYYY
		$this->next_installment_no = $this->last_installment_no+1;
		$this->Period_No = date('m', strtotime($this->month));
		$this->term = ceil($this->next_installment_no / 12);

		$this->console_write('this->COSTANT_COMPUTATION',$this->COSTANT_COMPUTATION);
		$this->console_write('this->MAINOFFICE',$this->MAINOFFICE);
		$this->console_write('this->next_installment_no',$this->next_installment_no);
		$this->console_write('this->db_BM_Share_1st',$this->db_BM_Share_1st);
		$this->console_write('this->db_Agent_Share_1st',$this->db_Agent_Share_1st);
		$this->console_write('this->db_BM_Share_2nd',$this->db_BM_Share_2nd);
		$this->console_write('this->db_Agent_Share_2nd',$this->db_Agent_Share_2nd);




		if ($this->COSTANT_COMPUTATION == 1){
			$this->BM_SHARE_RATE=0;
			$this->AG_SHARE_RATE=0;
			if ($this->MAINOFFICE==1){
				$this->BM_SHARE_FIXED_AMOUNT=0;
				$this->AG_SHARE_FIXED_AMOUNT=$this->db_Const_Agent_Share+$this->db_Const_BM_Share;				
			}else{
				$this->BM_SHARE_FIXED_AMOUNT=$this->db_Const_BM_Share;
				$this->AG_SHARE_FIXED_AMOUNT=$this->db_Const_Agent_Share;				
			}
			$this->BM_SHARE_AMOUNT = $this->BM_SHARE_FIXED_AMOUNT;
			$this->AG_SHARE_AMOUNT = $this->AG_SHARE_FIXED_AMOUNT;
			$this->MODE_OF_COMPUTATION = 'CONSTANT';
		}else{ //percetage
			$this->BM_SHARE_FIXED_AMOUNT=0;
			$this->AG_SHARE_FIXED_AMOUNT=0;
			if ($this->next_installment_no<13){
				if ($this->MAINOFFICE==1){
					$this->BM_SHARE_COMP_MODE='';
					$this->AG_SHARE_COMP_MODE='1ST';
					$this->BM_SHARE_RATE = 0;
					//$this->AG_SHARE_RATE = $this->db_BM_Share_1st+$this->db_Agent_Share_1st;	
					$this->AG_SHARE_RATE = $this->db_Agent_Share_1st;	

				}else{
					$this->BM_SHARE_COMP_MODE='1ST';
					$this->AG_SHARE_COMP_MODE='1ST';
					$this->BM_SHARE_RATE = $this->db_BM_Share_1st; 
					$this->AG_SHARE_RATE = $this->db_Agent_Share_1st; 			
				}
			}else{
				if ($this->MAINOFFICE==1){
					$this->BM_SHARE_COMP_MODE='';
					$this->AG_SHARE_COMP_MODE='2ND';
					$this->BM_SHARE_RATE = 0;
					//$this->AG_SHARE_RATE = $this->db_BM_Share_2nd+$this->db_Agent_Share_2nd;		
					$this->AG_SHARE_RATE = $this->db_Agent_Share_2nd;		

				}else{
					$this->BM_SHARE_COMP_MODE='2ND';
					$this->AG_SHARE_COMP_MODE='2ND';
					$this->BM_SHARE_RATE = $this->db_BM_Share_2nd;
					$this->AG_SHARE_RATE = $this->db_Agent_Share_2nd;									
				}
			}
			$this->BM_SHARE_AMOUNT = $this->amount * $this->BM_SHARE_RATE/100.0;
			$this->AG_SHARE_AMOUNT = $this->amount * $this->AG_SHARE_RATE/100.0;
			$this->MODE_OF_COMPUTATION = 'PERCENTAGE';
		}
		return $this->amount - ($this->BM_SHARE_AMOUNT + $this->AG_SHARE_AMOUNT);
	}

	//GETS

	public function getYearCovered(){
		return $this->year;
	}
	public function getMonthCovered(){
		return $this->month;
	}
	public function getPeriodNo(){
		return $this->Period_No;
	}
	public function getInstallmentNo(){
		return $this->next_installment_no;
	}
	public function getCurrentTerm(){
		return $this->term;
	}


	public function isInMainOffice(){		
		return ($this->MAINOFFICE==1?'true':'false');
	}		
	public function getPeriodPaidCount(){		
		return $this->next_installment_no;
	}					
	public function getModeOfComputation(){		
		return $this->MODE_OF_COMPUTATION;
	}	
	public function getBMComputationMode(){		
		return $this->BM_SHARE_COMP_MODE;
	}
	public function getAGComputationMode(){		
		return $this->AG_SHARE_COMP_MODE;
	}

	public function getBMShareRate(){		
		return $this->BM_SHARE_RATE;
	}
	public function getAGShareRate(){		
		return $this->AG_SHARE_RATE;
	}	
	public function getBMShareAmount(){		
		return $this->BM_SHARE_AMOUNT;
	}
	public function getAGShareAmount(){		
		return $this->AG_SHARE_AMOUNT;
	}


	
	public function setdbBMInitialShareRate($value){
		$this->db_BM_Share_1st = $value;
	}
	public function setdbAgentInitialShareRate($value){
		$this->db_Agent_Share_1st = $value;
	}
	public function setdbBMShareRate($value){
		$this->db_BM_Share_2nd = $value;
	}
	public function setdbAgentShareRate($value){
		$this->db_Agent_Share_2nd = $value;
	}

	public function setdbConstAgentShare($value){
		$this->db_Const_Agent_Share = $value;
	}
	public function setdbConstBMShare($value){
		$this->db_Const_BM_Share = $value;		
	}

	public function setLastInstallmentNo($value){
		$this->last_installment_no = $value;
	}

	public function setORDate($value){
		$this->comp_date = date('Y-m-15',  strtotime($value));
	}
	public function setAmountPaid($value){
		$this->amount = $value;
	}
	public function setPlanID($value){
		$this->PLAN_ID = $value;
	}
	public function setBM_ID($value){
		$this->BM_ID = $value;
	}
	public function setAgent_ID($value){
		$this->AGENT_ID = $value;
	}
	public function setConstantComputation($value){
		$this->COSTANT_COMPUTATION = $value;
	}
	public function setMainOffice($value){
		$this->MAINOFFICE = $value;
	}
	public function console_write($var, $value){
		echo "[$var]= $value;";
	}

}



?>


<?php

## TEST SCRIPT --------------------------------------------------------------------------
/*		
	include_once('incentives_calculator_class.php');

	$res_computation = mysqli_query($con,"
	SELECT
	    `members_account`.`BranchManager`
	    , `members_account`.`AgentID`
	    , `packages`.`Plan_id`
	    , `packages`.`Agent_Share_1st`
	    , `packages`.`Agent_Share_2nd`
	    , `packages`.`BM_Share_1st`
	    , `packages`.`BM_Share_2nd`
	    , `packages`.`Comp_Constant`
	    , `packages`.`Const_BM_Share`
	    , `packages`.`Const_Agent_Share`
	    , `branch_details`.`mainoffice`
	FROM
	    `dmcpi1_dmcsm`.`members_account`
	    INNER JOIN `dmcpi1_dmcsm`.`members_profile` 
	        ON (`members_account`.`Member_Code` = `members_profile`.`Member_Code`)
	    INNER JOIN `dmcpi1_dmcsm`.`packages` 
	        ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
	    INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
	        ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
	WHERE (`members_profile`.`Member_Code` ='RO0227003970');
   ");

	$comp = mysqli_fetch_array($res_computation,MYSQLI_ASSOC);
	$calc = new incentives_calculator();
	$calc->setPlanID($comp['Plan_id']);
	$calc->setBM_ID($comp['BranchManager']);
	$calc->setAgent_ID($comp['AgentID']);
	$calc->setConstantComputation($comp['Comp_Constant']);
	$calc->setMainOffice($comp['mainoffice']);

	$calc->setdbConstBMShare($comp['Const_BM_Share']);
	$calc->setdbConstAgentShare($comp['Const_Agent_Share']);

	$calc->setdbBMInitialShareRate($comp['BM_Share_1st']);
	$calc->setdbAgentInitialShareRate($comp['Agent_Share_1st']);
	$calc->setdbBMShareRate($comp['BM_Share_2nd']);
	$calc->setdbAgentShareRate($comp['Agent_Share_2nd']);

	//LOOP THRU PAYMENTS
	$calc->setORDate('2018-9-12');
	$calc->setAmountPaid(275);
	$calc->setLastInstallmentNo(12);
	$netAmount = $calc->compute();

	echo "netAmount            :".$netAmount.'<br>';
	echo 'isInMainOffice       :'.$calc->isInMainOffice().'<br>';		
	echo 'getPeriodPaidCount   :'.$calc->getPeriodPaidCount().'<br>';		
	echo 'getModeOfComputation :'.$calc->getModeOfComputation().'<br>';		
	echo 'getBMComputationMode :'.$calc->getBMComputationMode().'<br>';		
	echo 'getAGComputationMode :'.$calc->getAGComputationMode().'<br>';		
	echo 'getBMShareRate       :'.$calc->getBMShareRate().'<br>';		
	echo 'getAGShareRate       :'.$calc->getAGShareRate().'<br>';		
	echo 'getBMShareAmount     :'.$calc->getBMShareAmount().'<br>';		
	echo 'getAGShareAmount     :'.$calc->getAGShareAmount().'<br>';

*/

?>