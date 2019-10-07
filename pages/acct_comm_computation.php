<?php
    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:1900);
    $selectedMonth = (isset($_REQUEST['selectedMonth'])?$_REQUEST['selectedMonth']:1);
    $selectedEncSessionID = (isset($_REQUEST['selectedEncSessionID'])?$_REQUEST['selectedEncSessionID']:0);

    $MCPR_ID = (isset($_REQUEST['mcpr_id'])?$_REQUEST['mcpr_id']:0);
    $fltrd = isset($_REQUEST['fltrd'])?1:0;

?>

<div class="row">
    <div class="col-lg-10">
        <h1 class="page-header">Commission and Incentives Computation</h1>
    </div>
    <div class="col-lg-2">
       <BR><BR>
       <span class=" pull-right">
       <!--a href="#" type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#share_generation_modal"><i class="fa fa-plus" ></i> New</a-->
       </span>
    </div>
</div>



<?php
    if ($fltrd==1) {

        $f_mode = "";
        $f_mcpr_id = "";
        $f_mcpr_month = "";
        $f_mcpr_year = "";
        $f_mcpr_agent = "";
        $f_mcpr_branch = "";

        $filter_data = "";

        if ($MCPR_ID>0) {
            $res_mcpr_data = mysqli_query($con, "SELECT * FROM tbl_mcpr WHERE mcpr_id = $MCPR_ID;");
            $fr = mysqli_fetch_array($res_mcpr_data,MYSQLI_ASSOC);
            $fr_agent  = $fr['AGENT'];
            $fr_branch  = $fr['BRANCH'];

            $f_mode = "BASE ON MCPR";
            $f_mcpr_id = "$MCPR_ID";
            $f_mcpr_month = $arrMonths[$selectedMonth];
            $f_mcpr_year = "$selectedYear";
            $f_mcpr_agent = "$fr_agent";
            $f_mcpr_branch = "$fr_branch";


            $filter_data = "
                <dl class=\"dl-horizontal\">
                  <dt>MODE</dt><dd>$f_mode</dd>
                  <dt>MCPR ID</dt><dd>$f_mcpr_id</dd>
                  <dt>MONTH</dt><dd>$f_mcpr_month</dd>
                  <dt>YEAR</dt><dd>$f_mcpr_year</dd>
                  <dt>AGENT</dt><dd>$f_mcpr_agent</dd>
                  <dt>BRANCH</dt><dd>$f_mcpr_branch</dd>
                </dl>
            ";
        }else{
            $f_mode = "BASE ON ENCODING SESSION";
            $f_mcpr_month = $arrMonths[$selectedMonth];
            $f_mcpr_year = "$selectedYear";

            $filter_data = "
                <dl class=\"dl-horizontal\">
                  <dt>MODE</dt><dd>$f_mode</dd>
                  <dt>MONTH</dt><dd>$f_mcpr_month</dd>
                  <dt>YEAR</dt><dd>$f_mcpr_year</dd>
                </dl>

            ";


        }


        echo "
        <div class=\"panel panel-default\" id=filter_info_panel>
          <div class=\"panel-heading\">Filter Information
            <a htrf=\"#\" class=\"btn btn-info pull-right btn-xs\" id=newfilter>New Filter</a>
          </div>
            <div class=\"panel-body\">
                $filter_data

                

            </div><!--BODY-->
          
        </div>

        
        ";

    }
?>



<div class="panel panel-default <?=($fltrd==1?'hidden':'')?> " id=filter_panel >
  <div class="panel-heading">Period Covered Filter</div>
    <div class="panel-body">
        <div class="row"  id=filter1>
          <div class="form-row" >

            <div class="form-group col-md-2">
              <label for="source1">FILTER BY</label>
                <select class="form-control" id="source1">

                    <option value=1>MCPR</option>
                    <option value=2>ENCODING SESSION</option>                
                </select>
            </div>
        <form action='index.php' method="GET" name="mcpr_getdata">

            <div class="form-group col-md-2">
              <label for="selectedYear">Year</label>
                <select class="form-control" id="selectedYear" name="selectedYear"  required>
                <?php
                    $res_mcpr_years = mysqli_query($con,"select `YEAR` from tbl_mcpr GROUP BY `YEAR`") or die(mysqlI_error());
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
              <label for="selectedBanch">Branch</label>
                <select class="form-control" id="selectedBanch"  required>
                </select>
            </div>




            <div class="form-group col-md-2">
              <label for="selectedAgent">Agent</label>
                <select class="form-control" id="selectedAgent" name="mcpr_id"  required>
                </select>
            </div>
            <input type="hidden" name="page" value="incentives_computation"></input>
            <input type="hidden" name="fltrd" value="1"></input>

            <div class="form-group col-md-2">
                  <font size=3> &nbsp;</font><br>
                  <!--a href="#" class="btn btn-info" id=btnPeriodFilter>DISPLAY</a-->
                  <input type="submit" class="btn btn-info" value="DISPLAY"></input>
            </div>

        </form>

          </div><!--ROW ENDS-->
       </div> <!--  filter panel -->
    
 

    <div class="row hidden" id=filter2>
      <form action='index.php' method="GET" name="non_mcpr_getdata">

      <div class="form-row" >
        <div class="form-group col-md-2">
          <label for="source2">FILTER BY</label>
            <select class="form-control" id="source2">
                <option value=1>MCPR</option>
                <option value=2>ENCODING SESSION</option>                
            </select>
        </div>


        <div class="form-group col-md-2">
          <label for="selectedYear2">Year*</label>
            <select class="form-control" id="selectedYear2" name=selectedYear  required>
            <?php
                $res_mcpr_years2 = mysqli_query($con,"SELECT DISTINCT YEAR FROM tbl_activities ORDER BY YEAR DESC;") or die(mysqlI_error());
                echo "<option value=\"\">Select</option>";
                while ($r=mysqli_fetch_array($res_mcpr_years2,MYSQLI_ASSOC)) {
                    $year = $r['YEAR'];
                    echo "<option value=\"$year\">$year</option>";                
                }
            ?>
            </select>
        </div>
        <div class="form-group col-md-2">
          <label for="selectedMonth2">Month</label>
            <select class="form-control" id="selectedMonth2" name="selectedMonth"  required>
            </select>
        </div>
            <input type="hidden" name="page" value="incentives_computation"></input>
            <input type="hidden" name="fltrd" value="1"></input>
            <input type="hidden" name="selectedEncSessionID" id="selectedEncSessionID" value="0"></input>

        <div class="form-group col-md-2">
              <font size=3> &nbsp;</font><br>
              <!--a href="#" class="btn btn-info" id=btnPeriodFilter2>DISPLAY</a-->
                  <input type="submit" class="btn btn-info" value="DISPLAY."></input>


        </div>
        </div><!--ROW ENDS 2-->
        </form>
    </div> <!-- filter2 -->



  </div>
</div>


<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Receipts</a></li>
</ul>



<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
<div class="alert alert-info" role="alert">Note: Peach colored rows are payments of members under BM VITO</div>
                        <table width="100%" class="table  table-bordered " id="datatable-buttons2">
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Member_Code</th>
                                    <th>Member</th>                                        
                                    <th>Plan</th>

                                    <th>GROSS</th>
                                    <th>OR No.</th>
                                    <th>OR Date</th>

                                    <th>TOTAL COMM/INC.</th>
                                    <th>NET AMOUNT</th>
                                    <th>OPTIONS</th>

                                    <th class="none">PERIOD COVERED</th>
                                    <th class="none">BM COMMISION</th>
                                    <th class="none">AGENT COMMISSION</th>
                                    <th class="none">BM Overriding Incentives</th>
                                    <th class="none">FFSO Overriding Incentives</th>

                                </tr>
                            </thead>
                            <tbody id="rowcontainer">
                                <?php 


                                   $sql_mcpr = "

                                    SELECT
                                        `tbl_mcpr_details`.`MCPR_EID`
                                        , `tbl_mcpr_details`.`Plan_Code`
                                        , `tbl_mcpr_details`.`Member_Code`
                                        , `tbl_mcpr_details`.`CLIENT` AS `Member`
                                        , `installment_ledger`.`Br_period_covered`
                                        , IFNULL(`tbl_mcpr_details`.`ENC_AMOUNT`,0) AS `GROSS`
                                        , `tbl_mcpr_details`.`ENC_OR` AS ENC_OR
                                        , `tbl_mcpr_details`.`ENC_ORDATE` AS ENC_ORDATE
                                        , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + 
                                          SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + 
                                          SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + 
                                          SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS `TOTAL_INCENTIVES`
                                        , IFNULL(`tbl_mcpr_details`.`ENC_AMOUNT`,0) - 
                                          SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + 
                                          SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + 
                                          SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + 
                                          SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0))  AS `NET`
                                     
                                        , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) AS BM_COM
                                        , SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) AS AG_COM
                                        , SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) AS AG_OI
                                        , SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS BM_OI
                                        , IF(ISNULL(SUM(`tbl_sharecomputation`.`AgentShareAmount`)),0,1) AS 'INC_COMPUTED'
                                        , `members_account`.`BranchManager` AS Branch_ID
                                    FROM
                                        `dmcpi1_dmcsm`.`installment_ledger`
                                        RIGHT JOIN `dmcpi1_dmcsm`.`tbl_mcpr_details` 
                                            ON (`installment_ledger`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
                                        LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
                                            ON (`tbl_sharecomputation`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
                                        LEFT JOIN `dmcpi1_dmcsm`.`members_account`
                                            ON (`members_account`.`Member_Code` = `tbl_mcpr_details`.`Member_Code`)


                                    WHERE (`tbl_mcpr_details`.`MCPR_ID` =$MCPR_ID)
                                    GROUP BY `tbl_mcpr_details`.`MCPR_ID`, `tbl_mcpr_details`.`Plan_Code`, `tbl_mcpr_details`.`Member_Code`, `tbl_mcpr_details`.`CLIENT`, `GROSS`, `tbl_mcpr_details`.`ENC_OR`, `tbl_mcpr_details`.`ENC_ORDATE`
                                    ORDER BY `tbl_mcpr_details`.`MCPR_EID`
                                    ;

                                    ";



                            $sql_nonmcpr = "
                            SELECT
                                `installment_ledger`.`Member_Code`
                                , CONCAT(`members_profile`.`Fname`,' ',`members_profile`.`Mname`,' ',`members_profile`.`Lname`) AS `Member`
                                , `packages`.`Plan_Code`
                                , SUM(`installment_ledger`.`Amt_Due`) AS `GROSS`
                                , `installment_ledger`.`ORno` AS `ENC_OR`
                                , `installment_ledger`.`ORdate` AS `ENC_ORDATE`
                                , `installment_ledger`.`Br_period_covered`
                                , `tbl_sharecomputation`.`BMShareAmount` AS `BM_COM`
                                , `tbl_sharecomputation`.`AgentShareAmount` AS `AG_COM`
                                , `tbl_sharecomputation`.`oi_bm` AS `BM_OI`
                                , `tbl_sharecomputation`.`oi_ffso` AS `AG_OI`
                                ,  SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS TOTAL_INCENTIVES
                                , SUM(IFNULL(`installment_ledger`.`Amt_Due`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS NET
                                , `tbl_sharecomputation`.`Remarks`
                                , `installment_ledger`.`AcctDateApproved`
                                , IF (`installment_ledger`.`AcctDateApproved` IS NULL, 0,1) AS IS_APPROVED
                                , IF (`tbl_sharecomputation`.`BMShareAmount` IS NULL AND `tbl_sharecomputation`.`AgentShareAmount` IS NULL,0,1) AS IS_COMPUTED
                                , IF (`installment_ledger`.`Amt_Due` IS NULL,0,1) AS IS_ENCODED
                                        , IF(ISNULL(SUM(`tbl_sharecomputation`.`AgentShareAmount`)),0,1) AS 'INC_COMPUTED'

                                        , `members_account`.`BranchManager` AS Branch_ID
                            FROM
                                `dmcpi1_dmcsm`.`members_profile`
                                INNER JOIN `dmcpi1_dmcsm`.`installment_ledger` 
                                    ON (`members_profile`.`Member_Code` = `installment_ledger`.`Member_Code`)
                                INNER JOIN `dmcpi1_dmcsm`.`members_account` 
                                    ON (`members_profile`.`Member_Code` = `members_account`.`Member_Code`)
                                INNER JOIN `dmcpi1_dmcsm`.`packages` 
                                    ON (`members_account`.`Plan_id` = `packages`.`Plan_id`)
                                LEFT JOIN `dmcpi1_dmcsm`.`tbl_sharecomputation` 
                                    ON (`tbl_sharecomputation`.`ORno` = `installment_ledger`.`ORno`)
                            WHERE 
                                `installment_ledger`.`enc_session_id`=$selectedEncSessionID 

                                #OLD QUERY
                                #YEAR(`installment_ledger`.`ORdate`)=$selectedYear 
                                #AND MONTH(`installment_ledger`.`ORdate`)=$selectedMonth
                                #AND NOT `installment_ledger`.`ORno` IN (SELECT ENC_OR FROM tbl_mcpr_details WHERE YEAR(ENC_ORDATE)=$selectedYear AND MONTH(ENC_ORDATE)=$selectedMonth)
                            GROUP BY 
                                `installment_ledger`.`Member_Code`
                                , `members_profile`.`Fname`
                                , `members_profile`.`Mname`
                                , `members_profile`.`Lname`
                                , `packages`.`Plan_Code`
                                , `ENC_OR`
                                , `installment_ledger`.`ORdate`
                                , `BM_COM`
                                , `AG_COM`
                                , `BM_OI`
                                , `AG_OI`;

                            "
                            ;


                                    
                                    $sql=($MCPR_ID > 0 ? $sql_mcpr : $sql_nonmcpr);
                                    $res_data = mysqli_query($con,$sql ) or die(mysqli_error());
                                    $cnt=0;

                                    while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                    
                                        $Member_Code = $r['Member_Code']; 
                                        $Fullname = $r['Member']; 
                                        $Plan_Code= $r['Plan_Code'];

                                        $Br_period_covered = $r['Br_period_covered']; 
                                        $GROSS = $r['GROSS'];
                                        $ORno = $r['ENC_OR'];
                                        $ORdate = $r['ENC_ORDATE'];

                                        $BM_Commision= $r['BM_COM'];
                                        $AG_Commision= $r['AG_COM'];
                                        $BM_OI= $r['BM_OI'];
                                        $FFSO_OI= $r['AG_OI'];
                                        $TOTAL_INCENTIVES= $r['TOTAL_INCENTIVES'];
                                        $NET  = $r['NET'];

                                        $Branch_ID = $r['Branch_ID'];
                                        $BM_VITO_ID=17;

                                        $ROW_COLOR = "bgcolor=\"\"";
                                        if ($Branch_ID == $BM_VITO_ID) {
                                            $ROW_COLOR = "bgcolor=\"#FFEFD5\"";
                                        }

                                        $btnCommOption="";
                                        if ($GROSS == 0){
                                            $btnCommOption = "No Payment";
                                        }else if ($r['INC_COMPUTED']==0){
                                            $btnCommOption = "
                                            <button type=\"button\" 
                                            ORno=$ORno 
                                            Member_Code=\"$Member_Code\"
                                            id=btn_comm_compute 
                                            class=\"btn btn-primary btn-sm\"
                                            >COMPUTE</button>";
                                        }else{
                                            $btnCommOption = "
                                            <button type=\"button\" 
                                            ORno=$ORno 

                                            BM_Commision=$BM_Commision
                                            AG_Commision=$AG_Commision
                                            BM_OI=$BM_OI
                                            FFSO_OI=$FFSO_OI
                                            data-toggle=\"modal\" data-target=\"#modal_comm_alter\"

                                            Member_Code=\"$Member_Code\"
                                            id=btn_alter_computation 
                                            class=\"btn btn-primary btn-sm\"
                                            >ALTER</button>";                                            
                                        }
                                        $cnt++;
                                        echo "
                                            <tr id=sharelistdata $ROW_COLOR >
                                                <td class=\"even gradeC\"> $cnt</td>
                                                <td>$Member_Code</td>
                                                <td>$Fullname</td>
                                                <td>$Plan_Code</td>
                                                
                                                <td><div class='pull-right'>$GROSS</div></td>
                                                <td>$ORno</td>
                                                <td>$ORdate</td>
                                                <td>$TOTAL_INCENTIVES</td>
                                                <td>$NET</td>
                                                <td>$btnCommOption</td>

                                                <td>$Br_period_covered</td>
                                                <td>$BM_Commision</td>
                                                <td>$AG_Commision</td>
                                                <td>$BM_OI</td>
                                                <td>$FFSO_OI</td>
                                            </tr>

                                        ";


                                    }
                                    mysqli_free_result($res_data);
                                    
                                ?>

                            </tbody>
                        </table>

                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /.col-lg-12 -->
        </div> <!-- /.row -->
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_comm_alter" tabindex="-1" role="dialog" aria-labelledby="modal_comm_alterLabel">
<form class="form-horizontal">
<input type="hidden" id=selectedOR>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_comm_alterLabel">Manually Modify Incentives Computation</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="txtBMComm" class="control-label col-xs-4">BM Comm.</label> 
            <div class="col-xs-8">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                </div> 
                <input id="txtBMComm" name="txtBMComm" placeholder="Commission of Branch Manager" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtAgentComm" class="control-label col-xs-4">Agent Comm.</label> 
            <div class="col-xs-8">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                </div> 
                <input id="txtAgentComm" name="txtAgentComm" placeholder="Commission of Branch Manager" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtBMOI" class="control-label col-xs-4">BM Overriding Inc.</label> 
            <div class="col-xs-8">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                </div> 
                <input id="txtBMOI" name="txtBMOI" type="text" aria-describedby="txtBMOIHelpBlock" class="form-control">
              </div> 
              <span id="txtBMOIHelpBlock" class="help-block">The Incentive for BM (if the Payee is under directly under the BM)</span>
            </div>
          </div>
          <div class="form-group">
            <label for="txtFFSOOI" class="control-label col-xs-4">FFSO Overriding Inc.</label> 
            <div class="col-xs-8">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-money"></i>
                </div> 
                <input id="txtFFSOOI" name="txtFFSOOI" type="text" class="form-control" aria-describedby="txtFFSOOIHelpBlock">
              </div> 
              <span id="txtFFSOOIHelpBlock" class="help-block">The amount that goes to the FFSO (if the agent is under a FFSO-Agent)</span>
            </div>
          </div> 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id=btnSaveCommAlteration data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</form>

</div>
<script>
    $(document).ready(function() {
        $('#datatable-buttons2').DataTable({
            responsive: true
        });
    });

    var current_row;


    $('#newfilter').on('click',function(e){
        e.preventDefault();
        $('#filter_info_panel').fadeOut(300, function(){
            $('#filter_info_panel').addClass("hidden");        
            $('#filter_panel').removeClass("hidden");
            $('#rowcontainer').html('');
        });

    });

    $('#source1').change(function(){
        //SELECT AGENT_ID, AGENT FROM tbl_mcpr WHERE BRANCH_ID=26 AND `YEAR`=2018 AND `MONTH`=12;
        $('#source2').val($('#source1').val());
        $('#filter2').removeClass('hidden');
        $('#filter1').addClass('hidden');

    });
    $('#source2').change(function(){
        //SELECT AGENT_ID, AGENT FROM tbl_mcpr WHERE BRANCH_ID=26 AND `YEAR`=2018 AND `MONTH`=12;
        $('#source1').val($('#source2').val());
        $('#filter1').removeClass('hidden');
        $('#filter2').addClass('hidden');

    });

    $('#selectedBanch').change(function(){
        //SELECT AGENT_ID, AGENT FROM tbl_mcpr WHERE BRANCH_ID=26 AND `YEAR`=2018 AND `MONTH`=12;

        var selectedYear = $('#selectedYear').val();
        var selectedMonth = $('#selectedMonth').val();
        var selectedBanch = $(this).val();

        $.ajax({  
            type: 'GET',
            url: './proc/getComboDataNs.php', 
            data: { 
                tableName: "tbl_mcpr",
                valueMember:  "`MCPR_ID`",
                displayMember:  "AGENT",
                condition: "`YEAR`="+selectedYear+" AND `MONTH`="+selectedMonth+" AND BRANCH_ID="+selectedBanch+" GROUP BY AGENT_ID, AGENT",
            },
            success: function(response) {
                console.log(response);
                $('#selectedAgent').html(response);

            }
        });

    });


    $('#selectedMonth').change(function(){
        //SELECT BRANCH_ID, BRANCH FROM tbl_mcpr WHERE `YEAR`=2018 AND `MONTH`=12 GROUP BY BRANCH_ID, BRANCH;

        var selectedYear = $('#selectedYear').val();
        var selectedMonth = $(this).val();

        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "tbl_mcpr",
                valueMember:  "`BRANCH_ID`",
                displayMember:  "BRANCH",
                condition: "`YEAR`="+selectedYear+" AND `MONTH`="+selectedMonth+" GROUP BY BRANCH_ID, BRANCH",
            },
            success: function(response) {
                console.log(response);
                $('#selectedBanch').html(response);

            }
        });

    });

    $('#selectedMonth2').change(function(){
        //SELECT id FROM tbl_activities WHERE YEAR=2019 AND monthno=2;
        var selectedYear = $('#selectedYear2').val();
        var selectedMonth = $(this).val();

       $.ajax({  
            type: 'GET',
            url: './proc/getvalue2.php', 
            data: { 
                where:'`tbl_activities`.`YEAR` = ' + selectedYear + ' AND `tbl_activities`.MONTHNO = ' + selectedMonth,
                table:'`tbl_activities`',
                field:'`tbl_activities`.`id`'
            },
            success: function(response) {
                var strarray=response.split('|');
                var selectedEncSessionID = strarray[0];
                $('#selectedEncSessionID').val(selectedEncSessionID);

            }
        });    


    });




    $('#selectedYear2').change(function(){
    //BY ENCODING SESSION: SELECT DISTINCT `MONTHNO`, udf_inttomonthname(`MONTHNO`) FROM tbl_activities WHERE `YEAR` = 2019 ORDER BY `MONTHNO` DESC

        var selectedYear = $(this).val();
        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "tbl_activities",
                valueMember:  "DISTINCT `MONTHNO`",
                displayMember:  "udf_inttomonthname(`MONTHNO`)",
                condition: "`YEAR`="+selectedYear+" ORDER BY `MONTHNO` DESC",
            },
            success: function(response) {
                //console.log(response);
                $('#selectedMonth2').html(response);

            }
        });

    }); 

    $('#selectedYear').change(function(){
      //SELECT `MONTH` AS MONTHNO, MONTHNAME(CONCAT(`YEAR`,'-',`MONTH`,'-15' )) AS `MONTHNAME` 
      //FROM tbl_mcpr WHERE `YEAR`=2018 GROUP BY `MONTH`, `YEAR`;
        var selectedYear = $(this).val();
        $.ajax({  
            type: 'POST',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "tbl_mcpr",
                valueMember:  "MONTH",
                displayMember:  "MONTHNAME(CONCAT(`YEAR`,'-',`MONTH`,'-15' ))",
                condition: "`YEAR`="+selectedYear+" GROUP BY `MONTH`, `YEAR`",
            },
            success: function(response) {
                console.log(response);
                $('#selectedMonth').html(response);

            }
        });

    }); 


    $(document).on('click',"#btnPeriodFilter2",function(e){
        e.preventDefault();
        var selectedYear = $('#selectedYear2').val();
        var selectedMonth = $('#selectedMonth2').val();
 
        if (selectedYear<2000){
            return;
        }
        
        if (selectedMonth<1){
            return;
        }
        

        $.ajax({  
            type: 'GET',
            url: './proc/acct_approval_getdata_proc.php', 
            data: { 
                selectedYear: selectedYear,
                selectedMonth: selectedMonth,
            },
            success: function(response) {
                 //prompt('res: ',response);
                 console.log('res: '+response);
                 if (response.indexOf("**success**") > -1){
                    //alert('Incentives Computation successful!'); 
                    var arr_response = response.split('|');
                    $('#rowcontainer').html(arr_response[1]);
                    //$('#myDataTable').draw();

                 }else if (response.indexOf("**failed**") > -1){
                    alert('Incentives Computation failed!');
                 }
            }
        });                                                    
        //window.location = "index.php?page=acctledger&year="+year+"&month="+month; 
    });


    $(document).on('click',"#btnPeriodFilter",function(e){
        e.preventDefault();
        var MCPR_ID = $('#selectedAgent').val();

        if (MCPR_ID==''){
            return;
        }

        $.ajax({  
            type: 'GET',
            url: './proc/acct_inccomputation_mcpr_getdata_proc.php', 
            data: { 
                MCPR_ID: MCPR_ID,
            },
            success: function(response) {
                 //prompt('res: ',response);
                 console.log('res: '+response);
                 if (response.indexOf("**success**") > -1){
                    //alert('Incentives Computation successful!'); 
                    var arr_response = response.split('|');
                    $('#rowcontainer').html(arr_response[1]);
                    //$('#myDataTable').draw();

                 }else if (response.indexOf("**failed**") > -1){
                    alert('Incentives Computation failed!');
                 }
            }
        });                                                    
        //window.location = "index.php?page=acctledger&year="+year+"&month="+month; 
    });


    $(document).on('click','#btnSaveCommAlteration',function(e){
        e.preventDefault();


        var ORno = parseFloat($('#selectedOR').val());
        var txtBMComm = parseFloat($('#txtBMComm').val());
        var txtAgentComm = parseFloat($('#txtAgentComm').val());
        var txtBMOI = parseFloat($('#txtBMOI').val());
        var txtFFSOOI = parseFloat($('#txtFFSOOI').val());


        if (!$.isNumeric(txtBMComm)){
            alert("BM Commission should be numeric! Input '0' if not applicable");
            return;
        } 
        if (!$.isNumeric(txtAgentComm)){
            alert("Agent Commission should be numeric! Input '0' if not applicable");
            return;
        } 
        if (!$.isNumeric(txtBMOI)){
            alert("BM Overriding Incentives should be numeric! Input '0' if not applicable");
            return;
        } 
        if (!$.isNumeric(txtFFSOOI)){
            alert("FFSO Overriding Incentives should be numeric! Input '0' if not applicable");
            return;
        } 


        $.ajax({  
            type: 'GET',
            url: './proc/acct_comm_manual_computation_proc.php', 
            data: { 
                ORno: ORno,
                txtBMComm:txtBMComm,
                txtAgentComm:txtAgentComm,
                txtBMOI:txtBMOI,
                txtFFSOOI:txtFFSOOI
            },
            success: function(response) {
                
                 if (response.indexOf("**success**") > -1){
                    //alert('Incentives Computation successful!'); 
                    var arr_response = response.split('|');

                    current_row.fadeOut(500,function(){
                        current_row.html(arr_response[1]);
                        current_row.fadeIn(500);
                    });

                 }else if (response.indexOf("**failed**") > -1){
                    console.log(response);
                    alert('No changes made!');
                 }




            }
        });        


    });


     $(document).on('click','#btn_alter_computation',function(e){
        var first_row_value = parseInt($(this).closest('tr').find("td:first").html());
        if (!$.isNumeric(first_row_value)){
            alert('It seems like the record has been modified. The page will automatically reload then try again.');
            location.reload();
            return;            
        }

        $('#selectedOR').val($(this).attr('ORno'));
        $('#txtBMComm').val($(this).attr('BM_Commision'));    
        $('#txtAgentComm').val($(this).attr('AG_Commision'));    
        $('#txtBMOI').val($(this).attr('BM_OI'));    
        $('#txtFFSOOI').val($(this).attr('FFSO_OI'));    
        current_row = $(this).closest('tr');
     });


     $(document).on("click","#btn_comm_compute",function(){
        var ORno = $(this).attr('ORno');
        var user_id  = $('#user_info').attr('user_id');
        var Member_Code = $(this).attr('Member_Code');
        var row = $(this).closest('tr');
        var is_sleeve_fee = $(this).attr('is_sleeve_fee');

        if (confirm("Commission and Incentives will be computed automatically.You can manually alter computation once you made the computation.")){
        $('#btn_alter_computation').prop('disabled',true);            
            $.ajax({  
                type: 'GET',
                url: './proc/acct_comm_computation_proc.php', 
                data: { 
                    ORno: ORno,
                    user_id: user_id,
                    Member_Code:Member_Code,
                    is_sleeve_fee:is_sleeve_fee
                },
                success: function(response) {
                     //prompt('res: ',response);
                     console.log('res: '+response);
                     if (response.indexOf("**success**") > -1){
                        //alert('Incentives Computation successful!'); 
                        var arr_response = response.split('|');
                        row.fadeOut(500,function(){
                            row.html(arr_response[1]);
                            row.fadeIn(500);
                        });

                     }else if (response.indexOf("**failed**") > -1){
                        alert('Incentives Computation failed!');
                     }
                }
            });                                                    
        }
     });

    </script>


