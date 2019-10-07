<?php
    $selectedYear = (isset($_REQUEST['selectedYear'])?$_REQUEST['selectedYear']:1900);
    $selectedMonth = (isset($_REQUEST['selectedMonth'])?$_REQUEST['selectedMonth']:1);
    $selectedEncSessionID = (isset($_REQUEST['selectedEncSessionID'])?$_REQUEST['selectedEncSessionID']:0);
    $MCPR_ID = (isset($_REQUEST['mcpr_id'])?$_REQUEST['mcpr_id']:0);
    $fltrd = isset($_REQUEST['fltrd'])?1:0;

/*
SELECT `MONTH` AS MONTHNO, MONTHNAME(CONCAT(`YEAR`,'-',`MONTH`,'-15' )) AS `MONTHNAME` FROM tbl_mcpr WHERE `YEAR`=2018 GROUP BY `MONTH`, `YEAR`;
SELECT BRANCH_ID, BRANCH FROM tbl_mcpr WHERE `YEAR`=2018 AND `MONTH`=12 GROUP BY BRANCH_ID, BRANCH;
SELECT AGENT_ID, AGENT FROM tbl_mcpr WHERE BRANCH_ID=26 AND `YEAR`=2018 AND `MONTH`=12;
*/


?>

<div class="row">
    <div class="col-lg-10">
        <h1 class="page-header">OR/PR Verification</h1>
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

            $f_mode = "MCPR BASE";
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
            $f_mode = "NEW SALES";
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
                <!--option value=0>SELECT</option-->
                <option value=1>BASE ON MCPR</option>                
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
            <select class="form-control" id="selectedAgent"  name="mcpr_id"  required>
            </select>
        </div>

            <input type="hidden" name="page" value="acctledger"></input>
            <input type="hidden" name="fltrd" value="1"></input>

        <div class="form-group col-md-2">
              <font size=3> &nbsp;</font><br>
              <!--a href="#" class="btn btn-info" id=btnPeriodFilter>DISPLAY</a-->
        <input type="submit" class="btn btn-info" value="DISPLAY"></input>


        </div>

        </form>

      </div><!--ROW ENDS-->
      </div>


    <div class="row hidden" id=filter2>
      <form action='index.php' method="GET" name="non_mcpr_getdata">

      <div class="form-row" >

        <div class="form-group col-md-2">
          <label for="source2">FILTER BY</label>
            <select class="form-control" id="source2">
                <!--option value=0>SELECT</option-->
                <option value=1>BASE ON MCPR</option>                
                <option value=2>ENCODING SESSION</option>
            </select>
        </div>

        <div class="form-group col-md-2">
          <label for="selectedYear2">Year*</label>
            <select class="form-control" id="selectedYear2" name="selectedYear" required>
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
            <select class="form-control" id="selectedMonth2" name="selectedMonth" required>
            </select>
        </div>

            <input type="hidden" name="page" value="acctledger"></input>
            <input type="hidden" name="fltrd" value="1"></input>
            <input type="hidden" name="selectedEncSessionID" id="selectedEncSessionID" value="0"></input>


        <div class="form-group col-md-2">
              <font size=3> &nbsp;</font><br>
              <!--a href="#" class="btn btn-info" id=btnPeriodFilter2>DISPLAY</a-->
                  <input type="submit" class="btn btn-info" value="DISPLAY"></input>
        </div>
    </div><!--ROW ENDS 2-->
    </form>
    </div><!--ROW ENDS 2-->
</div>



  </div>
</div>




<!-- ___________________________________________________________________________________________________________________ -->



            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" ID=table_title>
                            SOURCE:                             
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="myDataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member_Code</th>
                                        <th>Member</th>                                        
                                        <th>Plan</th>

                                        <th>GROSS</th>
                                        <th>OR No.</th>
                                        <th>OR Date</th>

                                        <!--th id=c1>PERIOD COVERED</th-->
                                        <th id=c2>BM COM.</th>
                                        <th id=c3>AGENT COM.</th>
                                        <th id=c4>BM OI</th>
                                        <th id=c5>FFSO OI</th>


                                        <th>TOTAL COMM/INC.</th>
                                        <th>NET AMOUNT</th>
                                        <th>REMARKS<BR> / VERIFICATION</th>

                                    </tr>
                                </thead>
                                <tbody id=rowcontainer>

                                <?php
                                    $sql_mcpr = "
                                        SELECT
                                            `tbl_mcpr_details`.`MCPR_EID`
                                            , `tbl_mcpr_details`.`Member_Code`
                                            , `tbl_mcpr_details`.`CLIENT`
                                            , `tbl_mcpr_details`.`DOI_ORG` AS `DOI`
                                            , `tbl_mcpr_details`.`Plan_Code`
                                            , `tbl_mcpr_details`.`ENC_INS`
                                            , `tbl_mcpr_details`.`ENC_OR`
                                            , `tbl_mcpr_details`.`ENC_ORDATE` 
                                            , `tbl_mcpr_details`.`ENC_AMOUNT` AS GROSS
                                            , `tbl_mcpr_details`.`ENC_PC`
                                            , `tbl_mcpr_details`.`ENC_USERID`
                                            , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) AS BM_COM
                                            , SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) AS AG_COM
                                            , SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) AS AG_OI
                                            , SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS BM_OI
                                            , SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) + SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS TOTAL_INCENTIVES
                                            , SUM(IFNULL(`tbl_mcpr_details`.`ENC_AMOUNT`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`BMShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`AgentShareAmount`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_ffso`,0)) - SUM(IFNULL(`tbl_sharecomputation`.`oi_bm`,0)) AS NET
                                            , `tbl_sharecomputation`.`Remarks`
                                            , `installment_ledger`.`AcctDateApproved`
                                            , IF (`installment_ledger`.`AcctDateApproved` IS NULL, 0,1) AS IS_APPROVED
                                            , IF (`tbl_sharecomputation`.`BMShareAmount` IS NULL AND `tbl_sharecomputation`.`AgentShareAmount` IS NULL,0,1) AS IS_COMPUTED
                                            , IF (`tbl_mcpr_details`.`ENC_OR` IS NULL,0,1) AS IS_ENCODED
                                        FROM
                                            `dmcpi1_dmcsm`.`tbl_sharecomputation`
                                            RIGHT JOIN `dmcpi1_dmcsm`.`tbl_mcpr_details` 
                                                ON (`tbl_sharecomputation`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
                                            LEFT JOIN `installment_ledger`
                                                ON (`installment_ledger`.`ORno` = `tbl_mcpr_details`.`ENC_OR`)
                                        WHERE  `tbl_mcpr_details`.`MCPR_ID` =$MCPR_ID 
                                        #AND `tbl_mcpr_details`.`ENC_VALIDATED`=1
                                        GROUP BY 
                                              `tbl_mcpr_details`.`MCPR_ID`
                                            , `tbl_mcpr_details`.`MCPR_EID`
                                            , `tbl_mcpr_details`.`Member_Code`
                                            , `tbl_mcpr_details`.`CLIENT`
                                            , `DOI`
                                            , `tbl_mcpr_details`.`Plan_Code`
                                            , `tbl_mcpr_details`.`ENC_INS`
                                            , `tbl_mcpr_details`.`ENC_OR`
                                            , `tbl_mcpr_details`.`ENC_ORDATE` 
                                            , `tbl_mcpr_details`.`ENC_AMOUNT`
                                            , `tbl_mcpr_details`.`ENC_PC`
                                            , `tbl_mcpr_details`.`ENC_USERID`
                                            , `tbl_mcpr_details`.`ENC_VALIDATED`
                                            , `tbl_sharecomputation`.`Remarks`;

                                    ";   

                                    $sql_nonmcpr = "
                                        SELECT
                                            `installment_ledger`.`Member_Code`
                                            , CONCAT(`members_profile`.`Fname`,' ',`members_profile`.`Mname`,' ',`members_profile`.`Lname`) AS `CLIENT`
                                            , `packages`.`Plan_Code`
                                            , SUM(`installment_ledger`.`Amt_Due`) AS `GROSS`
                                            , `installment_ledger`.`ORno` AS `ENC_OR`
                                            , `installment_ledger`.`ORdate` AS `ENC_ORDATE`
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
                                            #YEAR(`installment_ledger`.`ORdate`)=$selectedYear AND
                                            #MONTH(`installment_ledger`.`ORdate`)=$selectedMonth
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

                                    ";

                                    $sql=($MCPR_ID > 0 ? $sql_mcpr : $sql_nonmcpr);
                    
                                    $res_data = mysqli_query($con,$sql ) or die(mysqli_error());
    
                                    $cnt=0;
                                    while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {

                                        $Member_Code = $r['Member_Code'];
                                        $Fullname = $r['CLIENT']; 
                                        $Plan_Code= $r['Plan_Code'];

                                        $GROSS = $r['GROSS'];
                                        $ORno = $r['ENC_OR'];
                                        $ORdate = $r['ENC_ORDATE'];

                                        $BM_Commision= $r['BM_COM'];
                                        $AG_Commision= $r['AG_COM'];
                                        $BM_OI= $r['BM_OI'];
                                        $FFSO_OI= $r['AG_OI'];

                                        $TOTAL_INCENTIVES= $r['TOTAL_INCENTIVES'];
                                        $NET  = $r['NET'];

                                        $AcctDateApproved = $r['AcctDateApproved'];


                                        $btnCommOption="";
                                        if ($r['IS_ENCODED']==0){
                                            $AcctDateApproved="NO PAYMENT";             
                                        }else if ($r['IS_COMPUTED']==0){
                                            $AcctDateApproved="INC/COM NOT YET COMPUTED";               
                                        }else if ($r['IS_APPROVED']==0){
                                            $AcctDateApproved = "
                                            <button type=\"button\" 
                                            ORno=$ORno 
                                            id=btnacctapprove 
                                            class=\"btn btn-primary btn-sm\"
                                            >VERIFY</button>";
                                        }else{
                                            $AcctDateApproved="DATE APPROVED: $AcctDateApproved";
                                        }


                                        $cnt++;
                                        echo  "
                                            <tr id=sharelistdata>
                                                <td class=\"even gradeC\"> $cnt</td>
                                                <td>$Member_Code</td>
                                                <td>$Fullname</td>
                                                <td>$Plan_Code</td>
                                                


                                                <td><div class='pull-right'>$GROSS</div></td>
                                                <td>$ORno</td>
                                                <td>$ORdate</td>

                                                <td bgcolor=\"#FDEDEC\">$BM_Commision</td>
                                                <td bgcolor=\"#FDEDEC\">$AG_Commision</td>
                                                <td bgcolor=\"#FDEDEC\">$BM_OI</td>
                                                <td bgcolor=\"#FDEDEC\">$FFSO_OI</td>



                                                <td bgcolor=\"#FDEDEC\"><B>$TOTAL_INCENTIVES</B></td>
                                                <td>$NET</td>
                                                <td>$AcctDateApproved</td>

                                            </tr>

                                        ";




                                    }



                                ?>




                                </tbody>
                            </table>

                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-12 -->
            </div> <!-- /.row -->



    <!--script src="../vendor/jquery/jquery.min.js"></script-->

<script>
    

    $(document).ready(function() {
        $('#myDataTable').DataTable({
            responsive: true
        });
    });


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



    $('#selectedYear2').change(function(){
//SELECT DISTINCT MONTH(ORdate) AS monthno, MONTHNAME(ORdate) AS 'monthname' FROM installment_ledger WHERE YEAR(ORdate) =2018 ORDER BY MONTH(ORdate)

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
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "tbl_mcpr",
                valueMember:  "`MONTH`",
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
            url: './proc/acct_approval_mcpr_getdata_proc.php', 
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


         $(document).on("click","#btnacctapprove",function(){


            var ORno = $(this).attr('ORno');
            var user_id  = $('#user_info').attr('user_id');
            var row = $(this).closest('tr');
            var source = $('#source1').val();

            if (confirm("You are about certify that the ledger entry is correct.")){

                $.ajax({  
                    type: 'GET',
                    url: './proc/acctapproval_proc.php', 
                    data: { 
                        ORno: ORno,
                        user_id: user_id,
                        source:source,
                    },
                    success: function(response) {
                         //prompt('res: ',response);
                         console.log('res: '+response);
                         if (response.indexOf("**success**") > -1){
                            alert('Approval successful!'); 
                            var arr_response = response.split('|');
                            row.fadeOut(500,function(){
                                row.html(arr_response[1]);
                                row.fadeIn(500);
                            });

                         }else if (response.indexOf("**failed**") > -1){
                            alert('Approval failed!');
                         }
                    }
                });                                                    
            }
         });


        


    </script>


