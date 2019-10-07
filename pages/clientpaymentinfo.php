
<?php 
$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'');

//-- client information ---------------------------------------------------
$res_clientinfo_header = mysqli_query($con, "SELECT Member_Code,plan_code,insurance_type,fullname as fn,No_of_units as units,Current_term as cur_term,agent,date_of_membership,account_status FROM members_profile_details WHERE Member_Code = '$Member_Code'") or die(mysqli_error());
	
	$r=mysqli_fetch_array($res_clientinfo_header,MYSQLI_ASSOC);
    $Member_Code = $r['Member_Code']; 
    $plan_code = $r['plan_code']; 
    $insurance_type = $r['insurance_type']; 
    $fullname = $r['fn']; 
    $No_of_units = $r['units']; 
    $Current_term = $r['cur_term']; 
    $agent = $r['agent']; 
    $date_of_membership = $r['date_of_membership']; 
    $account_status = $r['account_status']; 


//-- get payment detail  -----------------------------------------------------
  
    $last_year_paid=0;
    $last_month_paid=0;
    $res_packages = mysqli_query($con, "SELECT * FROM packages WHERE plan_code = '$plan_code';");
    $r_packages=mysqli_fetch_array($res_packages,MYSQLI_ASSOC);
    $package_payment_mode = $r_packages['Payment_mode']; 
    $package_amount_due = $r_packages['Amount']; 
    $package_term = $r_packages['Term'];

    $monthly_payment_amount = $package_amount_due * $No_of_units; 

    mysqli_free_result($res_packages);

    $res_lastpayment = mysqli_query($con, "
        SELECT Installment_No, Period_Covered,MONTH(STR_TO_DATE(Period_Covered,'%b')) AS period_month, Period_Year, Term, Units, br_installment_no, 
        DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH) AS next_period,
        YEAR(DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH)) AS next_year,
        MONTH(DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH)) AS next_month,
        LEFT(MONTHNAME(DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH)),3) AS next_monthname
        FROM installment_ledger WHERE member_code = '$Member_Code'  ORDER BY LedgerID DESC LIMIT 1;
        ");
    $r_lp=mysqli_fetch_array($res_lastpayment,MYSQLI_ASSOC);
    $lp_Installment_No = $r_lp['Installment_No'];
    $lp_Period_Covered = $r_lp['Period_Covered'];
    $lp_Period_Year = $r_lp['Period_Year'];
    $lp_Term = $r_lp['Term'];
    $lp_Units = $r_lp['Units'];
    $lp_br_installment_no = $r_lp['br_installment_no'];
    $next_month= $r_lp['next_month'];
    $next_monthname= $r_lp['next_monthname'];
    $next_year = $r_lp['next_year'];
    mysqli_free_result($res_lastpayment);





//-- ledger ----------------------------------------------------------------
    $res_ledger = mysqli_query($con, "

SELECT 
`installment_ledger`.`Installment_No`,
IFNULL(approvals.id,0) AS 'DELETION_REQIEST_ID',
approvals.`status` AS 'REQUEST_STATUS',
`installment_ledger`.`ORdate` AS `ORdate`, 
`installment_ledger`.`ORno` AS `ORno`, 
`installment_ledger`.`Br_Amt` AS `AmountPaid`, 
`installment_ledger`.`Br_period_covered` AS `PC`, 
`installment_ledger`.`Br_installment_no` AS `Br_installment_no`, 
`installment_ledger`.`Units` AS `Units`, 
MAX(`installment_ledger`.`Term`) AS `Term`, 
IF(approvals.id>0 AND approvals.`status`='pending','For deletion approval',`installment_ledger`.`Remarks`) AS `Remarks`, 
`installment_ledger`.`Insurance_Remarks` AS `Insurance_Remarks`, 
`installment_ledger`.`Member_Code` AS `Member_Code`
FROM `installment_ledger`
LEFT JOIN approvals
ON approvals.reference = `installment_ledger`.`ORno`
WHERE `installment_ledger`.Member_Code = '$Member_Code' 
    #and approvals.`type` = 'Void Receipt' 
    #and approvals.`status` = 'pending'
GROUP BY approvals.reference, `installment_ledger`.`ORdate`,`installment_ledger`.`ORno`,`AmountPaid`,`PC`,`installment_ledger`.`Units`,`installment_ledger`.`Remarks`,`installment_ledger`.`Insurance_Remarks`,`installment_ledger`.`Member_Code`
ORDER BY `installment_ledger`.`ORdate` DESC ,`installment_ledger`.`LedgerID` DESC 








    ") or die(mysqli_error());
    $res_ledger_count = mysqli_num_rows($res_ledger);   

//-- mcpr ------------------------------------------------------------------
    $res_mcpr = mysqli_query($con, "

        call sp_soa('$Member_Code','DESC');

        ;") or die(mysqli_error());
    $res_mcpr_count = mysqli_num_rows($res_mcpr);   

?>          


            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?=strtoupper($fullname) ?></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>

            <div id=temp_dataholder class=temp_dataholder name=temp_dataholder>
                <input type="hidden" class="next_year" id="next_year" name="next_year" value="<?=$next_year?>"> </input>
                <input type="hidden" class="next_month" id="next_month" name="next_month" value="<?=$next_month?>"> </input>
                <input type="hidden" class="next_monthname" id="next_monthname" name="next_monthname" value="<?=$next_monthname?>"> </input>
                <input type="hidden" class="next_yearmonthname" id="next_yearmonthname" name="next_yearmonthname" value="<?=$next_year?>-<?=$next_monthname?>"> </input>

            </div>
                
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            PAYMENT INFORMATION
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">LEDGER (<?=$res_ledger_count ?>)</a></li>
                                <!--li><a href="#profile" data-toggle="tab">OVERDUE</a></li-->
                                <li><a href="#messages" data-toggle="tab">SOA (<?=$res_mcpr_count?>)</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
                                <BR>
                                <?php

                                if($_COOKIE['MP_PAYMENT']==1 && ($account_status!='Inactive')){
                                echo "
                                $aes_notification
                                <button 
                                    type=\"button\" 
                                    class=\"btn btn-success \" 
                                    aria-label=\"Left Align\" 
                                    data-toggle=\"modal\" 
                                    data-target=\"#ledger_payment_emcoding_modal\"
                                    >
                                       <span class=\"glyphicon glyphicon-saved disabled\" aria-hidden=\"true\"></span>
                                        NEW PAYMENT
                                       </button>
                                ";


                                }

                                ?>





                                <br><br>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-ledger">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>O.R. DATE</th>
                                                <th>O.R. #</th>
                                                <th>AMOUNT</th>
                                                <th>P/C</th>
                                                <th>UNITS</th>
                                                <th>TERM</th>
                                                <th>REMARKS</th>
                                                <th>INSURANCE</th>
                                                <th>VOID</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                $ledger_entry_counter=$res_ledger_count;
                                                while($r=mysqli_fetch_array($res_ledger,MYSQLI_ASSOC)){
                                                    $ORdate= $r['ORdate'];  
                                                    $ORno= $r['ORno'];  
                                                    $Amt_Due= $r['AmountPaid'];  
                                                    $PC= $r['PC'];  
                                                    //$Installment_No= $r['Br_installment_no'];  
                                                    $Units= $r['Units'];  
                                                    $Term= $r['Term'];  
                                                    $Remarks= $r['Remarks'];  
                                                    $Insurance_Remarks= $r['Insurance_Remarks'];  
                                                    $Installment_No = $r['Installment_No'];
                                                    //even gradeC or even gradeX
                                                    $delete_btn_class = ($Installment_No<2?'hidden':'');

                                                    echo "
                                                        <tr class=\"odd gradeX\">
                                                            <td class=\"center\">$ledger_entry_counter</td>
                                                            <td>$ORdate</td>
                                                            <td>$ORno</td>
                                                            <td class=\"text-primary\">$Amt_Due</td>
                                                            <td>$PC</td>
                                                            <td class=\"center\">$Units</td>
                                                            <td class=\"center\">$Term</td>
                                                            <td>$Remarks</td>
                                                            <td>$Insurance_Remarks</td>
                                                            <td>
                                                                    
                                                                <a href=\"#\" 
                                                                    class=\"btn btn-danger  btn-xs btn-circle $delete_btn_class\"  
                                                                    id=btnvoid_payment
                                                                    orno=$ORno 
                                                                    table_entry_id=$ledger_entry_counter
                                                                >
                                                                <i class=\"glyphicon glyphicon-remove\" ></i></a>                                                                    
                                                            </td>

                                                        </tr>
                                                    ";
                                                    $ledger_entry_counter--;
                                               }
                                              
                                                mysqli_free_result($res_ledger);
                                            ?>

                                        </tbody>
                                    </table>




								<!-- PAYMENT ENCODING Modal -->
								<div class="modal fade" id="ledger_payment_emcoding_modal" tabindex="-1" role="dialog" aria-labelledby="ledger_payment_emcoding_modal_label">
								  <div class="modal-dialog" role="document" style="width:1200px;">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title" id="ledger_payment_emcoding_modal_label">NEW PAYMENT</h4>
								      </div>
								      <div class="modal-body">




                                    <!-- payment modal content here . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . -->
                                    <div class="row">
                                    <div class="col-sm-12">
                                        <legend><?=$fullname ?>:</legend>
                                    </div>
                                    <!-- panel preview -->
                                    <div class="col-sm-3">
                                        <h4>Add payment:</h4>
                                        <div class="panel panel-default">
                                            <div class="panel-body form-horizontal payment-form">

                                                <div class="form-group">
                                                    <label for="p_or_number" class="col-sm-3 control-label">OR/PR Number</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control p_or_number" id="p_or_number" name="p_or_number">
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="p_or_date" class="col-sm-3 control-label">OR/PR Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control p_or_date datepicker" id="p_or_date" name="p_or_date">
                                                    </div>
                                                </div>  



                                                <div class="form-group">
                                                    <label for="p_year" class="col-sm-3 control-label">Year</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="p_year" name="p_year">

                                                            <?php 
                                                                //$next_year
                                                                
                                                                for ($i=2017; $i <= date("Y")+5; $i++) { 
                                                                    if ($next_year == $i) {
                                                                        echo "<option value=\"$i\" selected>$i</option>";
                                                                    } else {
                                                                        echo "<option value=\"$i\">$i</option>";
                                                                    }
                                                                    
                                                                }
                                                            ?>


                                                        </select>                                                   
                                                    </div>


                                                </div>
                                                <div class="form-group">
                                                    <label for="p_month" class="col-sm-3 control-label">Month</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="p_month" name="p_month">
                                                            <?php 
                                                                $arrMonth = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                                                                foreach ($mon as &$arrMonth) {
                                                                    if ($next_monthname == $mon){
                                                                        echo "<option value=\"$mon\" selected>$mon</option>";
                                                                    
                                                                    } else {
                                                                        echo "<option value=\"$mon\">$mon</option>";
                                                                    }                                                                    
                                                                }

                                                                for($m=1; $m<=12; ++$m){
                                                                    $mon = date('M', mktime(0, 0, 0, $m, 1));
                                                                     //echo "<option value=\"$mon\">$mon</option>";
                                                                    if ($next_monthname == $mon){
                                                                        echo "<option value=\"$mon\" selected>$mon</option>";
                                                                    
                                                                    } else {
                                                                        echo "<option value=\"$mon\">$mon</option>";
                                                                    }        

                                                                }


                                                            ?>


                                                        </select>                                                   
                                                    </div> 
                                                </div> 
                                                         <div class="form-group">
                                                    <label for="amount" class="col-sm-3 control-label">Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" id="amount" name="amount" value="<?=$monthly_payment_amount ?>">
                                                    </div>
                                                </div>
                
                                                <div class="form-group">
                                                    <div class="col-sm-12 text-right">
                                                        <button type="button" class="btn btn-default preview-add-button">
                                                            <span class="glyphicon glyphicon-plus"></span> Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>            
                                    </div> <!-- / panel preview -->

                                    <div class="col-sm-9"> 


                                        <h4>Preview:</h4>
                                        <form name=frmPayment id=frmPayment class="frmPayment">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table preview-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Year</th>
                                                                    <th>Month</th>
                                                                    <th>Amount</th>
                                                                    <th>OR NUMBER</th>
                                                                    <th>OR DATE</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody> <!-- preview content goes here-->
                                                        </table>

                                                        
                                                    </div>                            
                                                </div>
                                            </div>

                                            <div class="row text-left">
                                                <div class="col-xs-12">
                                                    <h4>Total: <strong><span class="preview-total"></span></strong></h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <hr style="border:1px dashed #dddddd;">
                                                    <button type="button" class="btn btn-primary btn-block" id=save_payment name=save_payment>Save Payment</button>
                                                </div>                
                                            </div>

                                        </form>  
                                    </div>


                                    </div>
                                     <!-- /payment modal content here . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . -->

 

								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        <!--button type="button" class="btn btn-primary">POST</button-->
								      </div>
								    </div>
								  </div>
								</div>
								<!-- //PAYMENT ENCODING Modal -->



                                </div>

                                <!--div class="tab-pane fade" id="profile">
                                <BR>
                                    This page is temporaryly unavailable!
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-overdue">
                                        <thead>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td>Trident</td>
                                                <td>Internet Explorer 4.0</td>
                                                <td>Win 95+</td>
                                                <td class="center">4</td>
                                                <td class="center">X</td>
                                            </tr>
                                            <tr class="even gradeC">
                                                <td>Trident</td>
                                                <td>Internet Explorer 5.0</td>
                                                <td>Win 95+</td>
                                                <td class="center">5</td>
                                                <td class="center">C</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div-->

                                <div class="tab-pane fade" id="messages">
                                <BR>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-mcpr">
                                        <thead>
                                            <tr>
                                                <th>AMOUNT DUE</th>
                                                <th>OVERDUE</th>
                                                <th>INS #</th>
                                                <th>O.R. DATE</th>
                                                <th>O.R. #</th>
                                                <th>AMOUNT</th>
                                                <th>REMARKS</th>
                                                <th>REPORT DATE</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php 
                                                while($r=mysqli_fetch_array($res_mcpr,MYSQLI_ASSOC)){
                                                    $Amt_Due= $r['Amt_Due'];  
                                                    $Over_Due = $r['Over_Due'];  
                                                    $Installment_No= $r['Installment_No'];  
                                                    $ORdate= $r['OrDate'];  
                                                    $ORno= $r['OrNo'];  
                                                    $Rec_Amt= $r['Rec_Amt'];  
                                                    $Remarks= $r['Remarks'];  
                                                    $report_period= $r['report_period'];  
 

                                                    //even gradeC or even gradeX
                                                    echo "
                                                        <tr class=\"odd gradeX\">

                                                            <td>$Amt_Due</td>
                                                            <td>$Over_Due</td>                                                            
                                                            <td>$Installment_No</td>
                                                            <td>$ORdate</td>

                                                            <td>$ORno</td>
                                                            <td>$Rec_Amt</td>
                                                            <td>$Remarks</td>
                                                            <td class=\"center\">$report_period</td>

                                                        </tr>
                                                    ";
                                               }
                                              
                                                mysqli_free_result($res_mcpr);
                                            ?>                                       

                                        </tbody>
                                    </table>
                    			
                                <?php
                                        echo "
                                            <a class=\"btn btn-primary\" href=\"./xls/xlsdl_soa.php?Member_Code=$Member_Code\" role=\"button\">
                                              <span class=\"glyphicon glyphicon-download-alt\" aria-hidden=\"true\"></span>
                                            DOWNLOAD SOA</a>
                                        ";


                                ?>






                                </div>
                    
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    
                    </div>
                    <!-- /.panel -->




                    <!--div class="list-group">
                      <a href="#" class="list-group-item disabled">
                        PRINTABLES
                      </a>
                      <a href="./fpdf/reports/r_policy.php?Member_Code=RO10000002" target=”_blank” class="list-group-item">POLICY</a>
                      <a href="./fpdf/reports/r_deceaseinfo.php?Member_Code=RO10000002" target=”_blank” class="list-group-item">DECEASED INFORMATION</a>
                      <a href="./fpdf/reports/r_ms_acknowledgement.php?Member_Code=RO10000002" target=”_blank” class="list-group-item">ACKNOWLEDGEMENT OF SERVICE</a>
                      <a href="#" class="list-group-item">MEMBER'S INDIVIDUAL LEDGER REPORT</a>
                      <a href="#" class="list-group-item">MEMBER'S INDIVIDUAL HDMF REPORT</a>
                    </div-->


                </div>

                    <?php

                        echo "
                             <div id=meminfo 
                             membercode='$Member_Code'
                             units = '$No_of_units'
                             lpInstallmentNo = '$lp_Installment_No'
                             lpbrinstallmentno = '$lp_br_installment_no'
                             lpTerm = '$lp_Term'
                             ></div>

                        ";
                    ?>

                <!-- /.col-lg-6 -->
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            CLIENT INFORMATION
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>PART.</th>
                                            <th>DESC</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        echo "
                                            <tr><td><b>CODE</b></td><td>$Member_Code</td></tr>
                                            <tr><td><b>PLAN</b></td><td>$plan_code</td></tr>
                                            <tr><td><b>INSURANCE</b></td><td>$insurance_type</td></tr>
                                            <tr><td><b>UNIT</b></td><td>$No_of_units</td></tr>
                                            <tr><td><b>AGENT</b></td><td>$agent</td></tr>
                                            <tr><td><b>MEM. DATE</b></td><td>$date_of_membership</td></tr>
                                            <tr><td><b>STATUS</b></td><td>$account_status</td></tr>
                                            <tr><td><b>CUR. TERM</b></td><td>$Current_term</td></tr>
                                        ";

                                    ?>
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.table-responsive -->


                        </div>
                        <!-- /.panel-body -->
            
                    </div>
                    <!-- /.panel -->
            
                </div>
                <!-- /.col-lg-6 -->
            
            </div>
            <!-- /.row -->
            
    <!--script src="../vendor/jquery/jquery.min.js"></script-->



<script>







function calc_total(){
    var sum = 0;
    $('.input-amount').each(function(){
        sum += parseFloat($(this).text());
    });
    $(".preview-total").text(sum);    
}
$(document).on('click', '.input-remove-row', function(){ 
    var tr = $(this).closest('tr');
    tr.fadeOut(200, function(){
        tr.remove();
        calc_total()
    });
});

$(document).on('click','#btnvoid_payment', function(){

    if (confirm('You are about to delete this payment. \nYou can only delete newly encoded payment otherwise is subject for approval. \n \n Do you want to continue?')) {
         var orno = $(this).attr('orno');


         $.ajax({  
            type: 'GET',
            url: './proc/delete_payemt_proc.php', 
            data: { 
                mode:'delete',
                orno: orno,
                user_id: '<?=$user_id?>'
            },
            success: function(response) {
               // prompt(response,response);

                
                 
                 if (response.indexOf("**success**") > -1){
                    alert("Success!");
                    window.location = "?page=clientpaymentinfo&Member_Code=<?=$Member_Code?>";                              
                 }else if (response.indexOf("**for_approval**") >-1){
                    alert("Receipt#"+orno+" successfully submitted for approval.");                    
                 }else if (response.indexOf("**failed**") > -1){
                    alert("Delete failed!");
                   
                 }
                 
            }
        });  
    }    
});


$(document).on('click', '#save_payment', function(){ 

    if ($("#p_or_date").val() == ''){
        alert('OR/PR date is required');
        exit();
    }
    if ($("#p_or_number").val() == '' || $("#p_or_number").val() == '0'){
        alert('OR/PR number is required');
        exit();
    }


    if (confirm('I certify that the payment details are correct.')) {
    $("#save_payment").attr("disabled", true);

    //-- count number of entries---------------------------------
    var payment_count = 0
    var pay_amount = [];
    var pay_year = [];
    var pay_month = [];
    var pay_orno = [];
    var pay_ordate = [];
    var pay_yearmonthname = [];
    var userid = $('#user_info').attr('user_id');



    $("tr.payment_detail_row").each(function() {
        payment_count++;
        //dump payment data to array
        pay_amount.push($(this).find( 'input[name="pay_amount"]' ).val());
        pay_month.push($(this).find( 'input[name="pay_month"]' ).val());
        pay_year.push($(this).find( 'input[name="pay_year"]' ).val());
        pay_orno.push($(this).find( 'input[name="pay_orno"]' ).val());
        pay_ordate.push($(this).find( 'input[name="pay_ordate"]' ).val());



        pay_yearmonthname.push($(this).find( 'input[name="pay_year"]' ).val() + '-' + $(this).find( 'input[name="pay_month"]' ).val());
        //alert($(this).find( 'input[name="pay_year"]' ).val() + '-' + $(this).find( 'input[name="pay_month"]' ).val())
       
    });
    

    if (payment_count==0) {
        alert('Please add entry!');
        exit();
    }

    //~~ post payment--------------------------------------------
        $.ajax({  
            type: 'POST',
            url: './proc/save_payment_proc.php', 
            data: { 
                member_code: $('#meminfo').attr('membercode'),
                units: $('#meminfo').attr('units'),
                lpInstallmentNo:  $('#meminfo').attr('lpInstallmentNo'),
                lpbrinstallmentno:  $('#meminfo').attr('lpbrinstallmentno'),
                lpTerm: $('#meminfo').attr('lpTerm'),
                pay_ordate: pay_ordate,
                pay_orno: pay_orno,
                pay_amount:pay_amount,
                pay_month:pay_month,
                pay_year:pay_year,
                userid: "<?=$user_id?>"
            },
            success: function(response) {

            //prompt(response,response);                 
            //console.log(response);
            //return;
             if (response.indexOf("**success**") > -1){
                //UPDATE SOA                
                  /*
                  $.ajax({  
                        type: 'POST',
                        url: './proc/soa_proc.php', 
                        data: { 
                            member_code: $('#meminfo').attr('membercode')
                        },
                        success: function(response) {
                            alert('SOA:'+response);
                        }
                    });    

                    */

                         alert('Payment saved!');
                         window.location = "index.php?page=clientlist";
                         }else if (response.indexOf("**failed**") > -1){
                                alert('Save failed');
                                $("#save_payment").attr("disabled", false);

                         }else if (response.indexOf("**exists**") >-1){
                                $("#save_payment").attr("disabled", true);
                                var strarray=response.split('|');
                                alert('OR#'+$("#p_or_number").val()+' Already exists in the database. Please check the payment of the client with Member_Code#'+strarray[1] + '.');
                         }                
            }
        });



} else {
    // Do nothing!
}

});

$(function(){

function getMonth(monthStr){
    return new Date(monthStr+'-1-01').getMonth()+1
}
function numToShortMonth(numMonth) {
    var arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    
    return arr[numMonth-1];
}

    $('.preview-add-button').click(function(){
        


        var form_data = {};
        form_data["Year"] = $('.payment-form select[name="p_year"]').val();
        form_data["Month"] = $('.payment-form select[name="p_month"]').val();
        form_data["amount"] = parseFloat($('.payment-form input[name="amount"]').val()).toFixed(2);

        form_data["or_date"] = $('.payment-form input[name="p_or_date"]').val();
        form_data["or_number"] = $('.payment-form input[name="p_or_number"]').val();


        form_data["remove-row"] = '<span class="glyphicon glyphicon-remove"></span>';

        //increment month
        pay_next_month=(getMonth(form_data["Month"])==12?1:getMonth(form_data["Month"])+1);
        pay_next_year=(pay_next_month==1?parseInt(form_data["Year"])+1:form_data["Year"]);

        //console.log('---------------');
        //console.log(pay_next_year);
        //console.log(form_data["Year"]);

        $('#p_month').val(numToShortMonth( pay_next_month));
        $('#p_year').val(pay_next_year);



        //-----------------------------------------------------------------------------------

        //1st entry should be the next payable period (disable temporaryly for backtracking)        
        /*
        var list_count = 0;
        $("tr.payment_detail_row").each(function() { list_count++;});
        if (list_count==0 && (form_data["Year"] != $("#next_year").val() || form_data["Month"] != $("#next_monthname").val())) {
            console.log('next payable period not included list');
            alert ('Please include period ' + $("#next_year").val() + '-' + $("#next_monthname").val() + ' in the list!');
            return;
        }
        */

        

        //if not 1st entry, 
        //get the next peyment period

        $('.payment-form select[name="p_month"]').removeAttr('selected').next('option').attr('selected', 'selected');
        
        //-----------------------------------------------------------------------------------
        var row = $('<tr id=payment_detail_row name=payment_detail_row class=payment_detail_row></tr>');
        var index = 0;
        var inv_fields = '';
        $.each(form_data, function( type, value ) {

            if (index<=5){
                //apend only index 0,1,2,3 fields to table
                //hidden variables for visible fields
            
                switch(index) {
                    case 0:
                        inv_fields = '<input type=hidden name=pay_year id=pay_year value="'+value+'">';
                        break;
                    case 1:
                        inv_fields = '<input type=hidden name=pay_month id=pay_month value="'+value+'">';
                        break;
                    case 2:
                        inv_fields = '<input type=hidden name=pay_amount id=pay_amount value="'+value+'">';
                        break;
                    case 3:
                        inv_fields = '<input type=hidden name=pay_ordate id=pay_ordate value="'+value+'">';
                        break;
                    case 4:
                        inv_fields = '<input type=hidden name=pay_orno id=pay_orno value="'+value+'">';
                        break;
                    default:
                    inv_fields='';
                }
                
                $('<td class="input-'+type+'"></td>').html(value+inv_fields).appendTo(row);

            }else{
                //hidden variables for invisible fields
            }

            
            index++;
        });
        $('.preview-table > tbody:last').append(row); 
        
        calc_total();
    });  
});


$(document).on('click', '#btn_update_soa', function(){ 
    if (confirm('Are you sure you want to update SOA?')) {

       $.ajax({  
            type: 'POST',
            url: './proc/soa_proc.php', 
            data: { 
                member_code: $('#meminfo').attr('membercode')
            },
            success: function(response) {
                //prompt(response,response);
                 if (response.indexOf("**success**") > -1){
                    alert('SOA Updated!');

                 }else if (response.indexOf("**failed**") > -1){
                    alert('An error has occured while updating SOA');
                 }                
            }
        });


    }   
});


    </script>

