<?php

	$search_criteria = (isset($_REQUEST['search_criteria'])?strtolower($_REQUEST['search_criteria']):'');
	$search_agent = (isset($_REQUEST['search_agent'])?strtolower($_REQUEST['search_agent']):'');
	$search_plan = (isset($_REQUEST['search_plan'])?strtolower($_REQUEST['search_plan']):'');




	include '../dbconnect.php';






	$res = mysqli_query($con, "

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
WHERE packages.Plan_Code LIKE '%$search_criteria%'
OR packages.Plan_name LIKE '%$search_criteria%'
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
ORDER BY packages.Plan_id DESC


	") or die(mysqli_error());

	$row_count = mysqli_num_rows($res);
	if ($row_count==0){
		echo "**failed**";
	}else{


		$table_rows = "";

		while ($r=mysqli_fetch_array($res,MYSQLI_ASSOC)) {
      $Plan_id = $r['Plan_id']; 
      $Plan_name = $r['Plan_name']; 
      $Plan_Code = $r['Plan_Code']; 
      $Eligibility = $r['Eligibility']; 
      $Payment_mode = $r['Payment_mode']; 
      $Amount = $r['Amount'];
      $Coverage = $r['Coverage'];
      $Term = $r['Term'];
      $Constability = $r['Constability'];
			$row_template = "
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
                  <a href=\"?Plan_id=$Plan_id\" class=\"btn btn-success btn-circle\" id=btnagentedit><i class=\"glyphicon glyphicon-edit\"></i></a>
                  <a href=\"?Plan_id=$Plan_id\" class=\"btn btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

              </td>
      </tr>


			";
			$table_rows.=$row_template;
		}

		echo "**success**|$table_rows|$row_count";
		

	}
	mysqli_free_result($res);
    include '../dbclose.php';

?>