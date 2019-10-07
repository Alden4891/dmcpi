
<?php

    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:1900);
    $selectedMonth = (isset($_REQUEST['selectedMonth'])?$_REQUEST['selectedMonth']:1);
    $fltrd = isset($_REQUEST['fltrd'])?1:0;


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
        <h1 class="page-header">Manila Reports 
        <?php
        if ($fltrd==1){
            $monthname = $arr_month[$selectedMonth];
            echo " for $monthname $selectedYear";
        }
        ?></h1>
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
                $res_filter = mysqli_query($con,"SELECT DISTINCT YEAR(date_of_membership) AS 'YEAR' FROM members_account WHERE YEAR(date_of_membership) > 2000 ORDER BY date_of_membership DESC;") or die(mysqlI_error());
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
          <label for="selectedMonth">Month</label>
            <select class="form-control" id="selectedMonth" name="selectedMonth"  required>
            </select>
        </div>
            <input type="hidden" name="page" value="manila_report"></input>
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
                            <th>BRANCH</th>
                            <th>BRANCH HEAD</th>
                            <th>NO OF CLIENTS</th>
                            <th width="50px">Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $res_branches = mysqli_query($con, "
                            SELECT
                                `branch_details`.Branch_ID,
                                `branch_details`.`Branch_Name` AS BRANCH,
                                `branch_details`.Branch_Manager,
                                 COUNT(`members_account`.`Member_Code`) AS CLIENT_COUNT
                            FROM
                                `dmcpi1_dmcsm`.`members_account`
                                INNER JOIN `dmcpi1_dmcsm`.`branch_details` 
                                    ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                            WHERE YEAR(`members_account`.`Date_of_membership`)=$selectedYear 
                                AND MONTH(`members_account`.`Date_of_membership`) = $selectedMonth
                            GROUP BY                                 
                                `branch_details`.Branch_ID,
                                `branch_details`.`Branch_Name` 

                            ") or die(mysqli_error());
                            $cnt = 0 ;
                            while ($r=mysqli_fetch_array($res_branches,MYSQLI_ASSOC)) {
                                $cnt+=1;
                                $Branch_ID = $r['Branch_ID']; 
                                $BRANCH = $r['BRANCH']; 
                                $Branch_Manager = $r['Branch_Manager']; 
                                $CLIENT_COUNT = $r['CLIENT_COUNT']; 

                                echo "
                                    <tr class=\"\">
                                        <td class=\"even gradeC\"> $cnt</td>
                                        <td>$BRANCH</td>
                                        <td>$Branch_Manager</td>
                                        <td>$CLIENT_COUNT</td>
                                        <td>
                                            <a href=\"xls/xlsdl_mnla_report.php?year=$selectedYear&month=$selectedMonth&branch_id=$Branch_ID&branch=$BRANCH\" 
                                            target=_blank class=\"btn  btn-xs btn-success btn-circle\"><i class=\"glyphicon glyphicon-file\"> DOWNLOAD</i></a>
                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_branches);
                            
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


    $('#selectedYear').change(function(){
        // select distinct MONTH(date_of_membership) as 'MONTH', MONTHNAME(date_of_membership) as 'MONTHNAME' 
        // from members_account where year(date_of_membership) = 2018 order by date_of_membership;

        var selectedYear = $(this).val();
        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "members_account",
                valueMember:  "distinct MONTH(date_of_membership)",
                displayMember:  "MONTHNAME(date_of_membership)",
                condition: "YEAR(date_of_membership) ="+selectedYear+" ORDER BY date_of_membership",
            },
            success: function(response) {
                //console.log(response);
                $('#selectedMonth').html(response);

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

