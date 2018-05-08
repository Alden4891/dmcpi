
<?php 
$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'');





//-- client information ---------------------------------------------------
$res_clientinfo_header = mysql_query("SELECT Member_Code,plan_code,insurance_type,fullname as fn,No_of_units as units,Current_term as cur_term,agent,date_of_membership,account_status FROM members_profile_details WHERE Member_Code = '$Member_Code'") or die(mysql_error());
	
	$r=mysql_fetch_array($res_clientinfo_header,MYSQL_ASSOC);
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
    $res_packages = mysql_query("SELECT * FROM packages WHERE plan_code = '$plan_code';");
    $r_packages=mysql_fetch_array($res_packages,MYSQL_ASSOC);
    $package_payment_mode = $r_packages['Payment_mode']; 
    $package_amount_due = $r_packages['Amount']; 
    $package_term = $r_packages['Term'];
    mysql_free_result($res_packages);

    $res_lastpayment = mysql_query("
        SELECT Installment_No, Period_Covered,MONTH(STR_TO_DATE(Period_Covered,'%b')) AS period_month, Period_Year, Term, Units, br_installment_no, 
        DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH) AS next_period,
        YEAR(DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH)) AS next_year,
        MONTH(DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH)) AS next_month,
        LEFT(MONTHNAME(DATE_ADD(STR_TO_DATE(CONCAT(Period_Year,'-',MONTH(STR_TO_DATE(Period_Covered,'%b')),'-',1),'%Y-%m-%d'), INTERVAL 1 MONTH)),3) AS next_monthname
        FROM installment_ledger WHERE member_code = '$Member_Code'  ORDER BY LedgerID DESC LIMIT 1;
        ");
    $r_lp=mysql_fetch_array($res_lastpayment,MYSQL_ASSOC);
    $lp_Installment_No = $r_lp['Installment_No'];
    $lp_Period_Covered = $r_lp['Period_Covered'];
    $lp_Period_Year = $r_lp['Period_Year'];
    $lp_Term = $r_lp['Term'];
    $lp_Units = $r_lp['Units'];
    $lp_br_installment_no = $r_lp['br_installment_no'];
    $next_month= $r_lp['next_month'];
    $next_monthname= $r_lp['next_monthname'];
    $next_year = $r_lp['next_year'];
    mysql_free_result($res_lastpayment);

//$date_of_membership = 0;

//-- ledger ----------------------------------------------------------------
    $res_ledger = mysql_query("SELECT * FROM ledger_report WHERE Member_Code = '$Member_Code' order by ORdate desc") or die(mysql_error());
    $res_ledger_count = mysql_num_rows($res_ledger);   

//-- mcpr ------------------------------------------------------------------
    $res_mcpr = mysql_query("SELECT * , CONCAT(`Installment_Period_Covered`, ' ',`Installment_Period_Year`) AS report_period FROM `dmcsm`.`mcpr_report` WHERE Member_Code='$Member_Code';") or die(mysql_error());
    $res_mcpr_count = mysql_num_rows($res_mcpr);   

?>          


            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?=$fullname ?></h1>
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
                                <li><a href="#messages" data-toggle="tab">MCPR (<?=$res_mcpr_count?>)</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
                                <BR>
                                  <button type="button" class="btn btn-default" aria-label="Left Align" data-toggle="modal" data-target="#ledger_payment_emcoding_modal">
                                  <span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
                                  NEW PAYMENT
                                </button>
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
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                $ledger_entry_counter=$res_ledger_count;
                                                while($r=mysql_fetch_array($res_ledger,MYSQL_ASSOC)){
                                                    $ORdate= $r['ORdate'];  
                                                    $ORno= $r['ORno'];  
                                                    $Amt_Due= $r['AmountPaid'];  
                                                    $PC= $r['PC'];  
                                                    //$Installment_No= $r['Br_installment_no'];  
                                                    $Units= $r['Units'];  
                                                    $Term= $r['Term'];  
                                                    $Remarks= $r['Remarks'];  
                                                    $Insurance_Remarks= $r['Insurance_Remarks'];  

                                                    //even gradeC or even gradeX
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

                                                        </tr>
                                                    ";
                                                    $ledger_entry_counter--;
                                               }
                                              
                                                mysql_free_result($res_ledger);
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
                                    <div class="col-sm-5">
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
                                                        <input type="date" class="form-control p_or_date" id="p_or_date" name="p_or_date">
                                                    </div>
                                                </div>  

                                                <!--div class="form-group">
                                                    <label for="p_pr_number" class="col-sm-3 control-label">PR Number</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control p_pr_number" id="p_pr_number" name="p_pr_number">
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="p_pr_date" class="col-sm-3 control-label">PR Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control p_pr_date" id="p_pr_date" name="p_pr_date">
                                                    </div>
                                                </div-->   

                                                <div class="form-group">
                                                    <label for="p_year" class="col-sm-3 control-label">Year</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="p_year" name="p_year">
                                                            <option value="2013">2013</option>
                                                            <option value="2014">2014</option>
                                                            <option value="2015">2015</option>
                                                            <option value="2016">2016</option>
                                                            <option value="2017">2017</option>
                                                            <option value="2018" selected>2018</option>
                                                            <option value="2019">2019</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                        </select>                                                   
                                                    </div>


                                                </div>
                                                <div class="form-group">
                                                    <label for="p_month" class="col-sm-3 control-label">Month</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="p_month" name="p_month">
                                                            <option value="Jan">Jan</option>
                                                            <option value="Feb">Feb</option>
                                                            <option value="Mar">Mar</option>
                                                            <option value="Apr">Apr</option>
                                                            <option value="May">May</option>
                                                            <option value="Jun">Jun</option>
                                                            <option value="Jul">Jul</option>
                                                            <option value="Aug">Aug</option>
                                                            <option value="Sep">Sep</option>
                                                            <option value="Oct">Oct</option>
                                                            <option value="Nov">Nov</option>
                                                            <option value="Dec">Dec</option>
                                                        </select>                                                   
                                                    </div> 
                                                </div> 
                                                         <div class="form-group">
                                                    <label for="amount" class="col-sm-3 control-label">Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" id="amount" name="amount" value="<?=$package_amount_due ?>">
                                                    </div>
                                                </div>
                                                    <?php
                                                            
                                                    ?>
                
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

                                    <div class="col-sm-7">


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
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody> <!-- preview content goes here-->
                                                        </table>

                                                        
                                                    </div>                            
                                                </div>
                                            </div>

                                            <div class="row text-right">
                                                <div class="col-xs-12">
                                                    <h4>Total: <strong><span class="preview-total"></span></strong></h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <hr style="border:1px dashed #dddddd;">
                                                    <button type="button" class="btn btn-primary btn-block" id=post_payment name=post_payment>POST Payment</button>
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
                                                while($r=mysql_fetch_array($res_mcpr,MYSQL_ASSOC)){
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
                                              
                                                mysql_free_result($res_mcpr);
                                            ?>                                       

                                        </tbody>
                                    </table>
                    			
                                 <button type="button" class="btn btn-default" aria-label="Left Align">
								  <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
								  NEW MCPR
								</button>



                                </div>
                    
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    
                    </div>
                    <!-- /.panel -->




<div class="list-group">
  <a href="#" class="list-group-item disabled">
    PRINTABLES
  </a>
  <a href="./fpdf/reports/r_policy.php?Member_Code=RO10000002" target=”_blank” class="list-group-item">POLICY</a>
  <a href="./fpdf/reports/r_deceaseinfo.php?Member_Code=RO10000002" target=”_blank” class="list-group-item">DECEASED INFORMATION</a>
  <a href="./fpdf/reports/r_ms_acknowledgement.php?Member_Code=RO10000002" target=”_blank” class="list-group-item">ACKNOWLEDGEMENT OF SERVICE</a>
  <a href="#" class="list-group-item">MEMBER'S INDIVIDUAL LEDGER REPORT</a>
  <a href="#" class="list-group-item">MEMBER'S INDIVIDUAL HDMF REPORT</a>
</div>


                </div>




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
            
    <script src="../vendor/jquery/jquery.min.js"></script>



    <script>
    $(document).ready(function() {
        $('#dataTables-ledger').DataTable({
            responsive: true
        });
        $('#dataTables-overdue').DataTable({
            responsive: true
        });
        $('#dataTables-mcpr').DataTable({
            responsive: true
        });
    
    });




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
$(document).on('click', '#post_payment', function(){ 
if (confirm('I certify that the payment details are correct.')) {

    //-- count number of entries---------------------------------
    var payment_count = 0
    var pay_amount = [];
    var pay_year = [];
    var pay_month = [];
    var pay_yearmonthname = [];

    $("tr.payment_detail_row").each(function() {
        payment_count++;

        //dump payment data to array
        pay_amount.push($(this).find( 'input[name="pay_amount"]' ).val());
        pay_month.push($(this).find( 'input[name="pay_month"]' ).val());
        pay_year.push($(this).find( 'input[name="pay_year"]' ).val());
        pay_yearmonthname.push($(this).find( 'input[name="pay_year"]' ).val() + '-' + $(this).find( 'input[name="pay_month"]' ).val());
        //alert($(this).find( 'input[name="pay_year"]' ).val() + '-' + $(this).find( 'input[name="pay_month"]' ).val())
       
    });
    
    //alert(pay_month[0]);
    //alert($("#next_monthname").val());

    if (payment_count==0) {
        alert('Please add entry!');
        exit();
    }

    //ensure user payment for the present period
    var next_month_index = jQuery.inArray( $("#next_year").val() + '-' + $("#next_monthname").val(), pay_yearmonthname );
    if (next_month_index == -1) {
        alert ('Please include period ' + $("#next_year").val() + '-' + $("#next_monthname").val() + ' in the list!');
        exit();
    }



    if (pay_yearmonthname[next_month_index] == $("#next_year").val() + '-' + $("#next_monthname").val()){
        alert('ok!');
    }else{
        alert('ops!');
    }

    //exit();

    if ($jQuery.inArray( $("#next_monthname").val(), arr )==-1){
        alert('!');
        exit();        
    }



    //~~ post payment--------------------------------------------
       // alert('test');       
        $.ajax({  
            type: 'POST',
            url: './proc/post_payment_proc.php', 
            data: { 
                pay_ordate: $("#p_or_date").val(),
                pay_or_number: $("#p_or_number").val(),
               // pay_prdate: $("#p_pr_date").val(),
               // pay_pr_number: $("#p_pr_number").val(),
                pay_amount:pay_amount,
                pay_month:pay_month,
                pay_year:pay_year,
            },
            success: function(response) {
                alert(response);
            }
        });



} else {
    // Do nothing!
}

});

$(function(){
    $('.preview-add-button').click(function(){
        var form_data = {};
        form_data["Year"] = $('.payment-form select[name="p_year"]').val();
        form_data["Month"] = $('.payment-form select[name="p_month"]').val();
        form_data["amount"] = parseFloat($('.payment-form input[name="amount"]').val()).toFixed(2);
        form_data["remove-row"] = '<span class="glyphicon glyphicon-remove"></span>';
        //-----------------------------------------------------------------------------------

        /*
        console.log('form_data[year]='+form_data["Year"]);
        console.log('#next_year='+$("#next_year").val());
        console.log('form_data[month]='+form_data["Month"]);
        console.log('#next_monthname='+$("#next_monthname").val());
        */



        //1st entry should be the next payable period
        var list_count = 0;
        $("tr.payment_detail_row").each(function() { list_count++;});
        if (list_count==0 && (form_data["Year"] != $("#next_year").val() || form_data["Month"] != $("#next_monthname").val())) {
            console.log('next payable period not included list');
            alert ('Please include period ' + $("#next_year").val() + '-' + $("#next_monthname").val() + ' in the list!');
            return;
        }

        //if not 1st entry, 
        //get the next peyment period


        //$('option:selected', 'select').removeAttr('selected').next('option').attr('selected', 'selected');
        $('.payment-form select[name="p_month"]').removeAttr('selected').next('option').attr('selected', 'selected');
        
        

        //-----------------------------------------------------------------------------------
        var row = $('<tr id=payment_detail_row name=payment_detail_row class=payment_detail_row></tr>');
        var index = 0;
        var inv_fields = '';
        $.each(form_data, function( type, value ) {

            if (index<=3){
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


    </script>

