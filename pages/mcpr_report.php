
<?php
    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:1900);
    $selectedMonth = (isset($_REQUEST['selectedMonth'])?$_REQUEST['selectedMonth']:1);
    $selectedBranch = (isset($_REQUEST['selectedBranch'])?$_REQUEST['selectedBranch']:'0|blank');
    $selectedBranchName = explode('|', $selectedBranch)[1];
    $selectedBranchID = explode('|', $selectedBranch)[0];


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
    <div class="col-lg-6">
        <h1 class="page-header">MCPR Reports<br>
            <?php
                if ($selectedBranchName != 'blank') {
                    echo "<small>of $selectedBranchName for the month of ".$arr_month[$selectedMonth]." $selectedYear</small>";
                }
            ?>
            

        </h1>
    </div>
    <div class="col-lg-6">
    <BR><BR>
                    <?php

                    echo "
                         <span class=\" pull-right\">
                            <a href=\"#\" type=\"button\" 
                            class=\"btn btn-success btn-md $REP_MCPR_GENERATE_DISABLER \"
                            data-toggle=\"modal\" 
                            data-target=\"#mcpr_period_select_modal\"                                                
                            id = btnLoadMCPRModal
                            target=_blank
                            >
                            <i class=\"fa fa-plus\" ></i> New MCPR</a>
                         </span>
                    ";


                    ?>


    </div>
</div>



<div class="panel panel-default" id=filter_panel >
  <div class="panel-heading">Period Covered Filter</div>
    <div class="panel-body">
        <div class="row"  id=filter1>
          <div class="form-row" >

        <form action='index.php' method="GET" name="mcpr_getdata">

            <div class="form-group col-md-2">
              <label for="selectedYear">Year</label>
                <select class="form-control" id="selectedYear" name="selectedYear"  required>
                <?php
                    $res_mcpr_years = mysqli_query($con,"SELECT DISTINCT `YEAR` FROM tbl_activities;") or die(mysqlI_error());
                    echo "<option value=\"\">Select</option>";
                    while ($r=mysqli_fetch_array($res_mcpr_years,MYSQLI_ASSOC)) {
                        $mcpr_year = $r['YEAR'];
                        echo "<option value=\"$mcpr_year\">$mcpr_year</option>";                
                    }
                ?>
                </select>
            </div>

            <div class="form-group col-md-2">
              <label for="selectedMonth">Month</label>
                <select class="form-control" id="selectedMonth" name="selectedMonth" required>
                </select>
            </div>

            <div class="form-group col-md-2">
              <label for="selectedBranch">Branch</label>
                <select class="form-control" id="selectedBranch" name="selectedBranch" required>
                </select>
            </div>

            <input type="hidden" name="page" value="mcpr_report"></input>
            <input type="hidden" name="fltrd" value="1"></input>

            <div class="form-group col-md-2">
                  <font size=3> &nbsp;</font><br>
                  <input type="submit" class="btn btn-info" value="DISPLAY"></input>
            </div>

        </form>

          </div><!--ROW ENDS-->
       </div> <!--  filter panel -->



<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>BRANCH</th>
                            <th>AGENT</th>
                            <th>MONTH</th>
                            <th>YEAR</th>
                            <th>GENERATED BY</th>
                            <th>DATE CREATED</th>
                            <th width="">Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $res_data = mysqli_query($con,"

                                SELECT MCPR_ID
                                    , BRANCH_ID
                                    , BRANCH
                                    , AGENT
                                    , UPPER(MONTHNAME(CONCAT(`YEAR`,'-',`MONTH`,'-15'))) AS `MONTH`
                                    , `MONTH` AS `MONTHNO`
                                    , YEAR AS `YEAR` 
                                    , DATE_CREATED
                                    , encoder_name AS `USER`
                                    , AGENT_ID
                                FROM tbl_mcpr
                                WHERE 
                                    `BRANCH_ID` = $selectedBranchID AND 
                                    `YEAR`=$selectedYear AND 
                                    `MONTH`=$selectedMonth
                                LIMIT 0,50
                                ;

                                ;

                            ") or die(MYSQLI_ERROR());
                            $cnt = 0 ;
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $cnt+=1;
                                $MCPR_ID = $r['MCPR_ID']; 
                                $BRANCH = $r['BRANCH']; 
                                $AGENT = $r['AGENT']; 
                                $MONTH = $r['MONTH']; 
                                $YEAR = $r['YEAR'];
                                $DATE_CREATED = $r['DATE_CREATED'];
                                $CREATED_BY = $r['USER'];
                                $AGENT_ID = $r['AGENT_ID'];
                                $MONTHNO = $r['MONTHNO'];

                                
                                echo "
                                    <tr class=\"\">
                                        <td class=\"even gradeC\"> $MCPR_ID</td>
                                        <td>$BRANCH</td>
                                        <td>$AGENT</td>
                                        <td>$MONTH</td>
                                        <td>$YEAR</td>
                                        <td>$CREATED_BY</td>
                                        <td>$DATE_CREATED</td>
                                        <td>

                                            <a 
                                            href=\"xls/xlsdl_mcpr.php?year=$YEAR&month=$MONTHNO&MCPR_ID=$MCPR_ID&encoder_name=$user_fullname\" 
                                            data-toggle=\"tooltip\" 
                                            data-placement=\"left\" 
                                            title=\"Download MCPR as ms-excel document\"         
                                            class=\"btn btn-success btn-circle  btn-xs $REP_MCPR_DOWNLOAD_DISABLER  \"
                                            ><i class=\"glyphicon glyphicon-download\"></i></a>

                                            <a href=\"xls/xlsdl_mcpr_offline.php?year=$YEAR&month=$MONTHNO&MCPR_ID=$MCPR_ID&encoder_name=$user_fullname\" 
                                            data-toggle=\"tooltip\" 
                                            data-placement=\"left\" 
                                            title=\"Download MCPR for offline encoding\"         
                                            class=\"btn btn-info btn-circle  btn-xs $REP_MCPR_OFFLINE_DOWNLOAD_DISABLER \"><i class=\"glyphicon glyphicon-download\"></i></a>

   
                                            <a href=\"#\" 
                                            disabled=true
                                            data-toggle=\"tooltip\" data-placement=\"left\" title=\"Delete MCPR!\"         
                                            class=\"btn btn-danger btn-circle  btn-xs $REP_MCPR_DELETE_DISABLER\"><i class=\"glyphicon glyphicon-remove\"

                                            ></i></a>

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

<!--script src="../vendor/jquery/jquery.min.js"></script-->

    <div class="modal fade" id="mcpr_period_select_modal" tabindex="-1" role="dialog" aria-labelledby="mcpr_period_select_modal_label">
      <div class="modal-dialog" role="document" style="width:400px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="mcpr_period_select_modal_label">Select Period</h4>
          </div>
          <div class="modal-body">
                <div class="form-group">
                    <label for="p_year" class="col-sm-3 control-label">YEAR</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="p_year" name="p_year">
                            <?php 
                                //TODO: BASE ON ENCODING SESSIONS
                                $res_es = mysqli_query($con,"SELECT DISTINCT `YEAR` FROM tbl_activities;");
                                echo "<option value=\"-1\" selected>SELECT</option>";
                                while ($r=mysqli_fetch_array($res_es,MYSQLI_ASSOC)) {
                                    $year = $r["YEAR"];
                                     echo "<option value=\"$year\">$year</option>";
                                    /*
                                    if (date("Y") == $year) {
                                        echo "<option value=\"$year\" selected>$year</option>";
                                    } else {
                                        echo "<option value=\"$year\">$year</option>";
                                    } 
                                    */                                  
                                }


                            ?>

                        </select>                                                   
                    </div>


                </div>
                <br><br>
                <div class="form-group">
                    <label for="p_month" class="col-sm-3 control-label">MONTH</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="p_month" name="p_month">
                        <!--?php
                            $cur_monthno=date('m');
                            foreach ($arr_month as $key => $value) {
                                if ($cur_monthno == $key) {
                                    echo "<option value=$key selected>$value</option>";      
                                }else{
                                    echo "<option value=$key>$value</option>";      
                                }
                            }
                        ?-->

                        </select>                                                   
                    </div> 
                </div> 
                <br><br>

                <div class="form-group">
                    <label for="p_branch" class="col-sm-3 control-label">BRANCH</label>
                    <div class="col-sm-9">
                        <select class="form-control" id=p_branch required>
                        <option value="">Select</option>
                        <?php
                        $res_branch = mysqli_query($con, "CALL sp_mcpr_getbranch;") or die(mysqli_error());

                             while ($r=mysqli_fetch_array($res_branch,MYSQLI_ASSOC)) { 
                                $value = $r["Branch_ID"];
                                $name = $r["Branch_Name"];
                                $wa = $r["WA"];
                                $woa = $r["WOA"];

                                $branch_manager = $r["BRANCH_MANAGER"];
                                echo "<option value=\"$value|$wa|$woa\">$name</option>";
                            }
                            mysqli_free_result($res_branch);
                        ?>                                                        
                        </select>

                    </div> 
                </div> 
                <br><br>


                <!--div class="form-group">
                    <label for="p_agent" class="col-sm-3 control-label">AGENT</label>
                    <div class="col-sm-9">
                    <select class="form-control" id=p_agent  required>
                      <option value="">Select</option>

                    </select>

                    </div> 
                </div> 
                <br><br-->

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id=btnGenerateMCPR>GENERATE</button>
            <!--button type="button" class="btn btn-primary">POST</button-->
          </div>
        </div>
      </div>
    </div>
    



<script>

$(document).on('click', '#btnLoadMCPRModal', function(e){
    e.preventDefault();
    $('#AgentID').val($(this).attr('agentid')); 
}); 

$('#selectedYear').change(function(){
  //SELECT DISTINCT `MONTHNO`, MONTHNAME(CONCAT(`YEAR`,'-',`monthno`,'-15')) FROM tbl_activities WHERE `year`=2019;


    var selectedYear = $(this).val();
    $.ajax({  
        type: 'POST',
        url: './proc/getComboData.php', 
        data: { 
            tableName: "tbl_activities",
            valueMember:  "DISTINCT `MONTHNO`",
            displayMember:  "MONTHNAME(CONCAT(`YEAR`,'-',`monthno`,'-15'))",
            condition: "`YEAR`="+selectedYear+";",
        },
        success: function(response) {
            console.log(response);
            $('#selectedMonth').html(response);

        }
    });

}); 

$('#p_year').change(function(){
    var selectedYear = $(this).val();
    $.ajax({  
        type: 'POST',
        url: './proc/getComboData.php', 
        data: { 
            tableName: "tbl_activities",
            valueMember:  "DISTINCT `MONTHNO`",
            displayMember:  "MONTHNAME(CONCAT(`YEAR`,'-',`monthno`,'-15'))",
            condition: "`YEAR`="+selectedYear+";",
        },
        success: function(response) {
            console.log(response);
            $('#p_month').html(response);

        }
    });

}); 


$('#selectedMonth').change(function(){
    //TODO: based on session id


    //SELECT BRANCH_ID, BRANCH FROM tbl_mcpr WHERE `YEAR`=2018 AND `MONTH`=12 GROUP BY BRANCH_ID, BRANCH;

    var selectedYear = $('#selectedYear').val();
    var selectedMonth = $(this).val();

    $.ajax({  
        type: 'POST',
        url: './proc/getComboData.php', 
        data: { 
            tableName: "tbl_mcpr",
            valueMember:  "CONCAT(`BRANCH_ID`,'|',`BRANCH`)",
            displayMember:  "BRANCH",
            condition: "`YEAR`="+selectedYear+" AND `MONTH`="+selectedMonth+" GROUP BY BRANCH_ID, BRANCH",
        },
        success: function(response) {
            console.log(response);
            $('#selectedBranch').html(response);

        }
    });

});





$(document).on('click', '#btnGenerateMCPR', function(e){
    e.preventDefault();
    //var p_agent = $('#p_agent').val();
    var p_year = $('#p_year').val();
    var p_month = $('#p_month').val();
    var encoder_name = "<?=$user_fullname?>";
    var user_id = "<?=$user_id?>";
    var p_branch = $('#p_branch').val();

    var branch_id = p_branch.split('|')[0];

        $.ajax({  
            type: 'GET',
            url: './proc/getvalue2.php', 
            data: { 
                field: 'count(*)',
                table:'tbl_mcpr',
                where:'`year`='+p_year+' and `month`='+p_month+' and branch_id='+branch_id
            },
            success: function(response) {
                var strarray=response.split('|');
                var row_count = parseInt(strarray[0]);
                if (row_count>0){
                    if(confirm('MCPR already exists! Do you want to overwrite it?')==false){
                        return;
                    }
                }



                $.ajax({  
                    type: 'GET',
                    url: './proc/generate_mcpr_proc.php', 
                    data: { 
                        year:p_year,
                        month:  p_month,
                        //AgentID:  p_agent,
                        p_branch: p_branch,
                        encoder_name: encoder_name,
                        user_id: user_id,
                    },
                    success: function(response) {
                        //prompt('res: ',response);
                        console.log(response);
                        //$('#p_agent').html(response);
                          if (response.indexOf("**prompt**")>-1) {
                            var strarray=response.split('|');
                            alert(strarray[1]);
                          }
                          else if (response.indexOf("**success**") > -1){
                            alert("Done!");
                            window.location = "index.php?page=mcpr_report";
                          }
                    }
                });
            }
        });

}); 

/*
$('#p_branch').on('change',function(e){    
    var Branch_ID = $(this).val();
    if (Branch_ID != '' && Branch_ID > 0){

        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "v_branchagents",
                valueMember:  "AgentID",
                displayMember:  "Agent2",
                condition: "Branch_ID = " + Branch_ID,
            },
            success: function(response) {
                //prompt('res: ',response);
                // console.log(response);
                 $('#p_agent').html(response);

            }
        });
    }
});
*/

$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});





</script>

