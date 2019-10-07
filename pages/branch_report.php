
<?php

    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:1900);
    $selectedBranch = (isset($_REQUEST['selectedBranch'])?$_REQUEST['selectedBranch']:1);
    $fltrd = isset($_REQUEST['fltrd'])?1:0;
    $branch = (isset($_REQUEST['branch'])?'of '.$_REQUEST['branch']:'');

    $arr_month = array('1'  => 'January' 
                      ,'2'  => 'February' 
                      ,'3'  => 'March' 
                      ,'4'  => 'April' 
                      ,'5'  => 'May' 
                      ,'6'  => 'June' 
                      ,'7'  => 'July' 
                      ,'8'  => 'August' 
                      ,'9'  => 'September' 
                      ,'10' => 'October' 
                      ,'11' => 'November' 
                      ,'12' => 'December'
    );
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
        <?php

            if ($selectedYear!=1900) {
                echo "$selectedYear Branch Reports of $branch";
            }else{
                echo "Branch Reports";                
            }

        ?>
        

        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="panel panel-default" id=filter_panel >
  <div class="panel-heading"> Filter</div>
    <div class="panel-body">

    <div class="row" id=filter>
      <form action='index.php' method="GET" name="non_mcpr_getdata">

      <div class="form-row" >

        <div class="form-group col-md-2">
          <label for="selectedYear">Year</label>
            <select class="form-control" id="selectedYear" name=selectedYear  required>
            <?php
                $res_filter = mysqli_query($con,"SELECT DISTINCT `YEAR` FROM tbl_activities ORDER BY `YEAR` DESC;") or die(mysqlI_error());
                echo "<option value=\"\">Select</option>";
                while ($r=mysqli_fetch_array($res_filter,MYSQLI_ASSOC)) {
                    $year = $r['YEAR'];
                    echo "<option value=\"$year\">$year</option>";                
                }
                mysqli_free_result($res_filter);
            ?>
            </select>
        </div>
        <div class="form-group col-md-2">
          <label for="selectedBranch">Branch</label>
            <select class="form-control" id="selectedBranch" name="selectedBranch"  required>
            </select>
        </div>
            <input type="hidden" name="page" value="branch_report"></input>
            <input type="hidden" name="branch" id="branch" value="" ></input>
                        <input type="hidden" name="fltrd" value="1"></input>

        <div class="form-group col-md-2">
              <font size=3> &nbsp;</font><br>
              <input type="submit" class="btn btn-info" value="DISPLAY"></input>
        </div>
        </div><!--ROW ENDS 2-->
        </form>
    </div> <!-- filter2 -->

  </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PERIOD</th>
                            <th>GROSS</th>
                            <th>BRANCH SHARE</th>
                            <th>AGENT COMMISSION</th>
                            <th>NET REMITTANCE</th>
                            <th width="50px">Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 

                            $br_sql = "


/*                            
                            SELECT
                                 `branch_details`.`Branch_Name`
                                , MONTH(installment_ledger.ordate) AS MONTHNO
                                , concat(MONTHNAME(installment_ledger.ordate),' ', year(installment_ledger.ordate)) as PERIOD
                                , ifnull(SUM(installment_ledger.Amt_Due),0) AS GROSS
                                , IFNULL(sum(tbl_sharecomputation.BMShareAmount),0) + IFNULL(sum(tbl_sharecomputation.oi_bm),0) as BranchShare
                                , IFNULL(sum(tbl_sharecomputation.AgentShareAmount),0) + IFNULL(sum(tbl_sharecomputation.oi_ffso),0) as AgentCom
                                , IFNULL(SUM(installment_ledger.Amt_Due),0) 
                                  - IFNULL(sum(tbl_sharecomputation.BMShareAmount),0) 
                                  - IFNULL(sum(tbl_sharecomputation.oi_bm),0)
                                  - IFNULL(SUM(tbl_sharecomputation.AgentShareAmount),0) 
                                  - IFNULL(SUM(tbl_sharecomputation.oi_ffso),0) 
                                as NetRemittance
                            FROM
                                `dmcpi1_dmcsm`.`members_account`
                                INNER JOIN `dmcpi1_dmcsm`.`installment_ledger` 
                                    ON (`members_account`.`Member_Code` = `installment_ledger`.`Member_Code`)
                                INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
                                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                                left join `dmcpi1_dmcsm`.`tbl_sharecomputation`
                                    on (installment_ledger.ORno = `tbl_sharecomputation`.`ORno`)
                            WHERE (year(installment_ledger.ORdate) =$selectedYear
                                AND `members_account`.`BranchManager` =$selectedBranch
                            )
                            GROUP BY `branch_details`.`Branch_Name`,  MONTH(installment_ledger.ordate), YEAR(installment_ledger.ordate)
                            ORDER BY MONTH(installment_ledger.ordate) DESC
                             ;
*/


SELECT `branch_details`.`Branch_Name`, 
       tbl_activities.MONTHNO                                       AS MONTHNO, 
       CONCAT(udf_inttomonthname(tbl_activities.MONTHNO), ' ', tbl_activities.YEAR)     AS PERIOD, 
       IFNULL(SUM(installment_ledger.amt_due), 0)     AS GROSS, 
       IFNULL(SUM(tbl_sharecomputation.bmshareamount), 0) 
       + IFNULL(SUM(tbl_sharecomputation.oi_bm), 0)   AS BranchShare, 
       IFNULL(SUM(tbl_sharecomputation.agentshareamount), 0) 
       + IFNULL(SUM(tbl_sharecomputation.oi_ffso), 0) AS AgentCom, 
       IFNULL(SUM(installment_ledger.amt_due), 0) - 
       IFNULL(SUM( 
       tbl_sharecomputation.bmshareamount), 0) - 
       IFNULL(SUM(tbl_sharecomputation.oi_bm), 0) - IFNULL(SUM( 
       tbl_sharecomputation.agentshareamount), 0) - 
       IFNULL(SUM(tbl_sharecomputation.oi_ffso), 0)   AS NetRemittance 
FROM   `dmcpi1_dmcsm`.`members_account` 
       INNER JOIN `dmcpi1_dmcsm`.`installment_ledger` 
               ON ( `members_account`.`member_code` = 
                    `installment_ledger`.`member_code` ) 
       INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
               ON ( `members_account`.`branchmanager` = 
                    `branch_details`.`branch_id` ) 
       INNER JOIN `dmcpi1_dmcsm`.`tbl_activities` 
              ON ( tbl_activities.ID = `installment_ledger`.`enc_session_id` ) 
       LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
              ON ( installment_ledger.orno = `tbl_sharecomputation`.`orno` ) 
              
              
WHERE  ( 
         tbl_activities.`YEAR` = $selectedYear
        AND `members_account`.`branchmanager` =$selectedBranch 
) 
GROUP  BY `branch_details`.`branch_name`, 
          tbl_activities.MONTHNO, 
          tbl_activities.YEAR 
ORDER  BY tbl_activities.MONTHNO DESC; 





                            ";
                            

                            //echo " [$br_sql]";

                            $res_data = mysqli_query($con, $br_sql) or die(mysqli_error());
                            $cnt = 0 ;
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $cnt+=1;
                                $MONTHNO = $r['MONTHNO']; 
                                $PERIOD = $r['PERIOD']; 
                                $GROSS = $r['GROSS']; 
                                $BranchShare = $r['BranchShare']; 
                                $AgentCom = $r['AgentCom']; 
                                $NetRemittance = $r['NetRemittance']; 
                                $Branch_Name= $r['Branch_Name'];

                                echo "
                                    <tr class=\"\">
                                        <td class=\"even gradeC\"> $cnt</td>
                                        <td>$PERIOD</td>
                                        <td>$GROSS</td>
                                        <td>$BranchShare</td>
                                        <td>$AgentCom</td>
                                        <td>$NetRemittance</td>

                                        <td>
                                            <a href=\"xls/xlsdl_br_report.php?year=$selectedYear&month=$MONTHNO&branch_id=$selectedBranch&branch=$Branch_Name\" 
                                            target=_blank class=\"btn  btn-xs btn-success btn-circle\"><i class=\"glyphicon glyphicon-file\"> DOWNLOAD</i></a>
                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_data);
                            
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>





<script>

    $('#selectedBranch').change(function(){
    	//SELECT `branch_details`.`Branch_Name` FROM `branch_details`  where `branch_details`.`Branch_ID` = 1;
        var Branch_ID = $(this).val();
       $.ajax({  
            type: 'GET',
            url: './proc/getvalue2.php', 
            data: { 
                where:'`branch_details`.`Branch_ID` = ' + Branch_ID,
                table:'`branch_details`',
                field:'`branch_details`.`Branch_Name`'
            },
            success: function(response) {
                //alert(response);
                var strarray=response.split('|');
 				//console.log(strarray[0]);               
 				$('#branch').val(strarray[0]);

 /*				
                if (strarray[0]!='0' || strarray[0]>0){
                  alert('The OR number you entered already exists in the database.');
                  $('#cliregistrationform_submit').prop('disabled',true);                                    
                }else{
                  $('#cliregistrationform_submit').prop('disabled',false);
                }
 */  
            }
        });    
   }); 



    $('#selectedYear').change(function(){

        var selectedYear = $(this).val();
        $.ajax({  
            type: 'GET',
            url: './proc/getComboDataDJO.php', 
            data: { 
                tableName: "members_account",
                valueMember:  "`branch_details`.`Branch_ID`",
                displayMember:  "`branch_details`.`Branch_Name`",
                condition: "(year(`installment_ledger`.ORdate) ="+selectedYear+")",
                joint1: "INNER JOIN `dmcpi1_dmcsm`.`installment_ledger` ON (`members_account`.`Member_Code` = `installment_ledger`.`Member_Code`)",
                joint2: "INNER JOIN `dmcpi1_dmcsm`.`branch_details` ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)",
                joint3: "INNER JOIN `dmcpi1_dmcsm`.`tbl_activities` ON (`tbl_activities`.`ID` = `installment_ledger`.`enc_session_id`)",
                order: "`branch_details`.`Branch_Name`",

            },
            success: function(response) {
                console.log(response);
                $('#selectedBranch').html(response);

            }
        });

    }); 



$(document).on('click', '#btnLoadData', function(e){
    e.preventDefault();
    $('#branch').val($(this).attr('branch')); 
    $('#branch_id').val($(this).attr('branch_id')); 
}); 


$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});

</script>

