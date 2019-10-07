<?php  
include '../dbconnect.php';

try
{

	$Plan_name=isset($_REQUEST['Plan_name'])?$_REQUEST['Plan_name']:'';
	$Plan_id=isset($_REQUEST['Plan_id'])?$_REQUEST['Plan_id']:'';
	$Plan_Code=isset($_REQUEST['Plan_Code'])?$_REQUEST['Plan_Code']:'';
	$Eligibility=isset($_REQUEST['Eligibility'])?$_REQUEST['Eligibility']:'';
	$Payment_mode=isset($_REQUEST['Payment_mode'])?$_REQUEST['Payment_mode']:'';
	$Amount=isset($_REQUEST['Amount'])?$_REQUEST['Amount']:'';
	$Coverage=isset($_REQUEST['Coverage'])?$_REQUEST['Coverage']:'';
	$Term=isset($_REQUEST['Term'])?$_REQUEST['Term']:'';
	$Constability=isset($_REQUEST['Constability'])?$_REQUEST['Constability']:'';
	$Agent_Share_1st=isset($_REQUEST['Agent_Share_1st'])?$_REQUEST['Agent_Share_1st']:'';
	$Agent_Share_2nd=isset($_REQUEST['Agent_Share_2nd'])?$_REQUEST['Agent_Share_2nd']:'';
	$BM_Share_1st=isset($_REQUEST['BM_Share_1st'])?$_REQUEST['BM_Share_1st']:'';
	$BM_Share_2nd=isset($_REQUEST['BM_Share_2nd'])?$_REQUEST['BM_Share_2nd']:'';
	$Applied_Date=isset($_REQUEST['Applied_Date'])?$_REQUEST['Applied_Date']:'';

  //basic incentives
	$Const_BM_Share=isset($_REQUEST['Const_BM_Share'])?$_REQUEST['Const_BM_Share']:'0';
	$Const_Agent_Share=isset($_REQUEST['Const_Agent_Share'])?$_REQUEST['Const_Agent_Share']:'0';
  $Comp_Constant=isset($_REQUEST['Comp_Constant'])?$_REQUEST['Comp_Constant']:'';
  $benefits_desc=isset($_REQUEST['benefits_desc'])?$_REQUEST['benefits_desc']:'';

  //overiding incentives
  $oi_computation=isset($_REQUEST['oi_computation'])?$_REQUEST['oi_computation']:'';
  $oi_ffso_percentage=isset($_REQUEST['oi_ffso_percentage'])?$_REQUEST['oi_ffso_percentage']:'';
  $oi_ffso_fixed=isset($_REQUEST['oi_ffso_fixed'])?$_REQUEST['oi_ffso_fixed']:'';
  $oi_bm_percentage=isset($_REQUEST['oi_bm_percentage'])?$_REQUEST['oi_bm_percentage']:'';
  $oi_bm_fixed=isset($_REQUEST['oi_bm_fixed'])?$_REQUEST['oi_bm_fixed']:'';
  

  //print_r($_REQUEST);
  //return;
	if($_REQUEST["save_mode"] == "update")
	{

		$result = mysqli_query($con,"
			UPDATE packages
				SET
					`Plan_name`='$Plan_name',
					`Plan_Code`='$Plan_Code',
					`Eligibility`='$Eligibility',
					`Payment_mode`='$Payment_mode',
					`Amount`='$Amount',
					`Coverage`='$Coverage',
					`Term`='$Term',
					`Constability`='$Constability',
					`Agent_Share_1st`='$Agent_Share_1st',
					`Agent_Share_2nd`='$Agent_Share_2nd',
					`BM_Share_1st`='$BM_Share_1st',
					`BM_Share_2nd`='$BM_Share_2nd',
					`Applied_Date`='$Applied_Date',
					`Const_BM_Share`='$Const_BM_Share',
					`Const_Agent_Share`='$Const_Agent_Share',
					`Comp_Constant`='$Comp_Constant',
          `benefits_desc`='$benefits_desc',
          `oi_computation`='$oi_computation',
          `oi_ffso_percentage`='$oi_ffso_percentage',
          `oi_ffso_fixed`='$oi_ffso_fixed',
          `oi_bm_fixed`='$oi_bm_fixed',
          `oi_bm_percentage`='$oi_bm_percentage'
			WHERE `Plan_id`='$Plan_id';
			");

		if (mysqli_affected_rows($con) > 0){
			
			$result = mysqli_query($con,"
                        SELECT
                          packages.Plan_id,
                          packages.Plan_name,
                          packages.Plan_Code,
                          packages.Eligibility,
                          packages.Payment_mode,
                          packages.Amount,
                          packages.Coverage,
                          packages.Term,
                          packages.Constability,
                          packages.Agent_Share_1st,
                          packages.Agent_Share_2nd,
                          packages.BM_Share_1st,
                          packages.BM_Share_2nd,
                          packages.Applied_Date,
                          packages.Comp_Constant,
                          packages.Const_BM_Share,
                          packages.Const_Agent_Share,
                          packages.benefits_desc,
                          COUNT(members_account.Member_Code) AS ClientCount
                        FROM members_account
                          RIGHT OUTER JOIN packages
                            ON members_account.Plan_id = packages.Plan_id
                        GROUP BY packages.Plan_id,
                                 packages.Plan_name,
                                 packages.Plan_Code,
                                 packages.Eligibility,
                                 packages.Payment_mode,
                                 packages.Amount,
                                 packages.Coverage,
                                 packages.Term,
                                 packages.Constability,
                                 packages.Agent_Share_1st,
                                 packages.Agent_Share_2nd,
                                 packages.BM_Share_1st,
                                 packages.BM_Share_2nd,
                                 packages.Applied_Date,
                                 packages.Comp_Constant,
                                 packages.Const_BM_Share,
                                 packages.Const_Agent_Share,
                                 packages.benefits_desc
			HAVING Plan_id = $Plan_id
                        ORDER BY packages.Plan_id DESC
			");
			$r = mysqli_fetch_array($result);

            $Plan_id = $r['Plan_id']; 
            $Plan_name = $r['Plan_name']; 
            $Plan_Code = $r['Plan_Code']; 
            $Eligibility = $r['Eligibility']; 
            $Payment_mode = $r['Payment_mode']; 
            $Amount = $r['Amount'];
            $Coverage = $r['Coverage'];
            $Term = $r['Term'];
            $Constability = $r['Constability'];
            
            $Agent_Share_1st = $r['Agent_Share_1st'];
            $Agent_Share_2nd     = $r['Agent_Share_2nd'];
            $BM_Share_1st    = $r['BM_Share_1st'];
            $BM_Share_2nd    = $r['BM_Share_2nd'];
            $Applied_Date    = $r['Applied_Date'];
            $Comp_Constant   = $r['Comp_Constant'];
            $Const_BM_Share  = $r['Const_BM_Share'];
            $Const_Agent_Share   = $r['Const_Agent_Share'];
            $benefits_desc = $r['benefits_desc'];

            $ClientCount = $r['ClientCount'];

            $row = "
                <tr id=row$Plan_id>
                    <td class=\"even gradeC\"> $Plan_Code</td>
                    <td>$Plan_name</td>
                    <td>$Eligibility</td>
                    <td>$Payment_mode</td>
                    <td>$Amount</td>
                    <td>$Coverage</td>
                    <td>$Term</td>
                    <td>$Constability</td>
                    <td>
                        <a href=\"#?Plan_id=$Plan_id\" class=\"btn btn-xs btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"
                            Plan_id =\"$Plan_id\"
                            Plan_name =\"$Plan_name\"
                            Plan_Code =\"$Plan_Code\"
                            Eligibility =\"$Eligibility\"
                            Payment_mode =\"$Payment_mode\"
                            Amount =\"$Amount\"
                            Coverage =\"$Coverage\"
                            Term =\"$Term\"
                            Constability =\"$Constability\"
                            Agent_Share_1st =\"$Agent_Share_1st\"
                            Agent_Share_2nd     =\"$Agent_Share_2nd\"
                            BM_Share_1st    =\"$BM_Share_1st\"
                            BM_Share_2nd    =\"$BM_Share_2nd\"
                            Applied_Date    =\"$Applied_Date\"
                            Comp_Constant   =\"$Comp_Constant\"
                            Const_BM_Share  =\"$Const_BM_Share\"
                            Const_Agent_Share   =\"$Const_Agent_Share\"
                            ClientCount = \"$ClientCount\"
                            benefits_desc = \"$benefits_desc\"

                        >

                        <i class=\"glyphicon glyphicon-edit\"></i></a>
                        <a href=\"#?Plan_id=$Plan_id\" 
                        Plan_id=$Plan_id
                        ClientCount=\"$ClientCount\" 
                        id=btnagentdelete 
                        class=\"btn btn-xs btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                    </td>
            </tr>

            ";

			echo "**success**|".$row;

		}else{
			echo "**noChanges**";
		}

		
	}
	
	else if($_REQUEST["save_mode"] == "insert")
	{



		//Insert record into database
		$result = mysqli_query($con,"

		INSERT INTO packages (
			Plan_name, 
			Plan_Code, 
			Eligibility, 
			Payment_mode, 
			Amount, 
			Coverage, 
			Term, 
			Constability, 
			Agent_Share_1st, 
			Agent_Share_2nd, 
			BM_Share_1st, 
			BM_Share_2nd, 
			Applied_Date, 
			Const_BM_Share, 
			Const_Agent_Share, 
			Comp_Constant,
      oi_computation,
      oi_bm_fixed,
      oi_bm_percentage,
      oi_ffso_fixed,
      oi_ffso_percentage
      )
		  VALUES (
		  	'$Plan_name', 
		  	'$Plan_Code', 
		  	'$Eligibility', 
		  	'$Payment_mode', 
		  	'$Amount', 
		  	'$Coverage', 
		  	'$Term', 
		  	'$Constability', 
		  	'$Agent_Share_1st', 
		  	'$Agent_Share_2nd', 
		  	'$BM_Share_1st', 
		  	'$BM_Share_2nd', 
		  	'$Applied_Date', 
		  	'$Const_BM_Share', 
		  	'$Const_Agent_Share', 
		  	'$Comp_Constant',
        '$oi_computation',
        '$oi_bm_fixed',
        '$oi_bm_percentage',
        '$oi_ffso_fixed',
        '$oi_ffso_percentage'		  	
      );

		");

		if (mysqli_affected_rows($con) > 0){
			//$result = mysqli_query($con,"SELECT * FROM packages WHERE Plan_id = LAST_INSERT_ID();");
			$result = mysqli_query($con,"
                        SELECT
                          packages.Plan_id,
                          packages.Plan_name,
                          packages.Plan_Code,
                          packages.Eligibility,
                          packages.Payment_mode,
                          packages.Amount,
                          packages.Coverage,
                          packages.Term,
                          packages.Constability,
                          packages.Agent_Share_1st,
                          packages.Agent_Share_2nd,
                          packages.BM_Share_1st,
                          packages.BM_Share_2nd,
                          packages.Applied_Date,
                          packages.Comp_Constant,
                          packages.Const_BM_Share,
                          packages.Const_Agent_Share,
                          COUNT(members_account.Member_Code) AS ClientCount
                        FROM members_account
                          RIGHT OUTER JOIN packages
                            ON members_account.Plan_id = packages.Plan_id
                        GROUP BY packages.Plan_id,
                                 packages.Plan_name,
                                 packages.Plan_Code,
                                 packages.Eligibility,
                                 packages.Payment_mode,
                                 packages.Amount,
                                 packages.Coverage,
                                 packages.Term,
                                 packages.Constability,
                                 packages.Agent_Share_1st,
                                 packages.Agent_Share_2nd,
                                 packages.BM_Share_1st,
                                 packages.BM_Share_2nd,
                                 packages.Applied_Date,
                                 packages.Comp_Constant,
                                 packages.Const_BM_Share,
                                 packages.Const_Agent_Share
						HAVING Plan_id = LAST_INSERT_ID()
                        ORDER BY packages.Plan_id DESC
			");
			$r = mysqli_fetch_array($result);

            $Plan_id = $r['Plan_id']; 
            $Plan_name = $r['Plan_name']; 
            $Plan_Code = $r['Plan_Code']; 
            $Eligibility = $r['Eligibility']; 
            $Payment_mode = $r['Payment_mode']; 
            $Amount = $r['Amount'];
            $Coverage = $r['Coverage'];
            $Term = $r['Term'];
            $Constability = $r['Constability'];
            
            $Agent_Share_1st = $r['Agent_Share_1st'];
            $Agent_Share_2nd     = $r['Agent_Share_2nd'];
            $BM_Share_1st    = $r['BM_Share_1st'];
            $BM_Share_2nd    = $r['BM_Share_2nd'];
            $Applied_Date    = $r['Applied_Date'];
            $Comp_Constant   = $r['Comp_Constant'];
            $Const_BM_Share  = $r['Const_BM_Share'];
            $Const_Agent_Share   = $r['Const_Agent_Share'];

            $ClientCount = $r['ClientCount'];

            $row = "
                <tr id=row$Plan_id>
                    <td class=\"even gradeC\"> $Plan_Code</td>
                    <td>$Plan_name</td>
                    <td>$Eligibility</td>
                    <td>$Payment_mode</td>
                    <td>$Amount</td>
                    <td>$Coverage</td>
                    <td>$Term</td>
                    <td>$Constability</td>
                    <td>
                        <a href=\"#?Plan_id=$Plan_id\" class=\"btn btn-success btn-xs btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"
                            Plan_id =\"$Plan_id\"
                            Plan_name =\"$Plan_name\"
                            Plan_Code =\"$Plan_Code\"
                            Eligibility =\"$Eligibility\"
                            Payment_mode =\"$Payment_mode\"
                            Amount =\"$Amount\"
                            Coverage =\"$Coverage\"
                            Term =\"$Term\"
                            Constability =\"$Constability\"
                            Agent_Share_1st =\"$Agent_Share_1st\"
                            Agent_Share_2nd     =\"$Agent_Share_2nd\"
                            BM_Share_1st    =\"$BM_Share_1st\"
                            BM_Share_2nd    =\"$BM_Share_2nd\"
                            Applied_Date    =\"$Applied_Date\"
                            Comp_Constant   =\"$Comp_Constant\"
                            Const_BM_Share  =\"$Const_BM_Share\"
                            Const_Agent_Share   =\"$Const_Agent_Share\"
                            ClientCount = \"$ClientCount\"

                        >

                        <i class=\"glyphicon glyphicon-edit\"></i></a>
                        <a href=\"#?Plan_id=$Plan_id\" 
                        Plan_id=$Plan_id
                        ClientCount=\"$ClientCount\" 
                        id=btnagentdelete 
                        class=\"btn btn-xs btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                    </td>
            </tr>

            ";

			echo "**success**|".$row;


		}else{
			echo "**failed**";
		}



		
	}

	else if($_GET["save_mode"] == "delete")
	{

		$result = mysqli_query($con,"DELETE FROM packages WHERE `Plan_id`='$Plan_id';");
		if (mysqli_affected_rows($con) > 0){
			echo "**success**";
		}else{
			echo "**failed**";
		}

	}

	//Close database connection
	mysqli_close($con);

}
catch(Exception $ex)
{
	echo "**failed**";
}
	
?>