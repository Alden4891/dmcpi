


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Plans and Packages</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id=row_count>
                
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="pull-right">

                <a href="#" class="btn btn-success" id=btnNewPlan data-toggle="modal" data-target="#myModal">New Plan</a>

                </div>
                <br><br>

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Plan Code</th>
                            <th>Plan</th>
                            <th>Eligibility</th>
                            <th>Payment_Mode</th>
                            <th>Amount</th>
                            <th>Coverage</th>
                            <th>Term</th>
                            <th>Contestability</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist class="clientlist">
                    <div id=dummyrow></div>
                        <?php 
                            $res_agents = mysqli_query($con, "

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
                             packages.oi_computation,
                             packages.oi_bm_fixed,
                             packages.oi_bm_percentage,
                             packages.oi_ffso_fixed,
                             packages.oi_ffso_percentage,
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
                                 packages.benefits_desc,
                                 packages.oi_computation,
                                 packages.oi_bm_fixed,
                                 packages.oi_bm_percentage,
                                 packages.oi_ffso_fixed,
                                 packages.oi_ffso_percentage
                        ORDER BY packages.Plan_id DESC


                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_agents,MYSQLI_ASSOC)) {
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

                                $oi_computation=$r['oi_computation'];
                                $oi_bm_fixed=$r['oi_bm_fixed'];
                                $oi_bm_percentage=$r['oi_bm_percentage'];
                                $oi_ffso_percentage=$r['oi_ffso_percentage'];
                                $oi_ffso_fixed=$r['oi_ffso_fixed'];

                                echo "
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
                                            <a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"
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
                                                oi_computation=\"$oi_computation\"
                                                oi_bm_fixed=\"$oi_bm_fixed\"
                                                oi_bm_percentage=\"$oi_bm_percentage\"
                                                oi_ffso_fixed=\"$oi_ffso_fixed\"
                                                oi_ffso_percentage=\"$oi_ffso_percentage\"
                                            >

                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
                                            <a href=\"#?Plan_id=$Plan_id\" 
                                            Plan_id=$Plan_id
                                            ClientCount=\"$ClientCount\" 
                                            id=btnagentdelete 
                                            class=\"btn btn-danger btn-xs btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_agents);
                            
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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    
    //NEW PLAN
    $(document).on("click","#btnNewPlan",function (e) {
        e.preventDefault();

        $('#plan_name').val('');
        $('#plan_id').val('');
        $('#plan_code').val('');
        $('#plan_eligibility').val('');
        $('#plan_mop').val('Monthly');
        $('#plan_amount').val('');
        $('#plan_coverage').val('');
        $('#plan_term').val('');
        $('#plan_constability').val('');
        $('#agent_share_1').val('');
        $('#agent_share_2').val('');
        $('#bm_share_1').val('');
        $('#bm_share_2').val('');
        $('#plan_applied_date').val('');
        $('#benefits_desc').val('');

        $('#bm_fixed').val('');
        $('#agent_fixed').val('');
        $('#share_computation').val('0');

        //CLEAR OVERRIDING INCENTIVES
            $("#oi_computation").prop('checked', false);
            $("#oi_ffso_fixed").val('');
            $("#oi_ffso_percentage").val('');
            $("#oi_bm_fixed").val('');
            $("#oi_bm_percentage").val('');
            $('#overiding_inc').addClass('hidden');            

    });

    //DELETE PLAN
    $(document).on("click","#btnagentdelete",function (e) {
        e.preventDefault();    
        var ClientCount =$(this).attr('ClientCount');
        if (ClientCount > 0) {
            alert("Unable to delete this plan. You have an exisitng record associated with this plan");
            return;
        }
        if (confirm("You are about to delete this plan package. Do you want to continue?")){
            var Plan_id =$(this).attr('Plan_id');

            
                 $.ajax({  
                    type: 'GET',
                    url: './proc/deplans_proc.php', 
                    data: { 
                        mode:'delete',
                        Plan_id:Plan_id                    },
                    success: function(response) {
                        // prompt(response,response);
                         if (response.indexOf("**success**") > -1){
                            $("#clientlist #row"+Plan_id).remove();     
                            alert("Plan with EntryID#"+Plan_id+" deleted successfully");                      
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Delete failed!");
                         }
                    }
                });  
        }
    });
    
    function isEmpty(value) {
        if ($.trim(value) == '') return true;
        else if ($.trim(value) == '0') return true;
        else if ($.trim(value) == undefined) return true;
        else if (value == undefined) return true;
    }
    
    //SAVE PLAN
    $(document).on("click","#btnsharesave",function (e) {
        e.preventDefault();    

        var Plan_name=$('#plan_name').val();
        var Plan_id=$('#plan_id').val();
        var Plan_Code=$('#plan_code').val();
        var Eligibility=$('#plan_eligibility').val();
        var Payment_mode=$('#plan_mop').val();
        var Amount=$('#plan_amount').val();
        var Coverage=$('#plan_coverage').val();
        var Term=$('#plan_term').val();
        var Constability=$('#plan_constability').val();
        var Agent_Share_1st=$('#agent_share_1').val();
        var Agent_Share_2nd=$('#agent_share_2').val();
        var BM_Share_1st=$('#bm_share_1').val();
        var BM_Share_2nd=$('#bm_share_2').val();
        var Applied_Date=$('#plan_applied_date').val();
        var benefits_desc=$('#benefits_desc').val();

        //BASIC INCENTIVES
        var Const_BM_Share=$('#bm_fixed').val();
        var Const_Agent_Share=$('#agent_fixed').val();
        var Comp_Constant=$('#share_computation').val();

        //OVERIDING INCENTIVES
        var oi_computation=0;
        var oi_bm_percentage=$('#oi_bm_percentage').val();
        var oi_ffso_percentage=$('#oi_ffso_percentage').val();
        var oi_ffso_fixed=$('#oi_ffso_fixed').val();
        var oi_bm_fixed=$('#oi_bm_fixed').val();

        //validation
        var mode = '';

        if($('#oi_computation').is(":checked")==false) {
            oi_computation = 0;
            oi_bm_percentage = 0;
            oi_bm_fixed = 0;
            oi_ffso_fixed = 0;
            oi_ffso_percentage = 0;
        }else{ 
            oi_computation = 1;
            if (!isEmpty(oi_bm_percentage) && !isEmpty(oi_bm_fixed)){
                $('#oi_bm_percentage').closest("div").addClass("has-error");
                $('#oi_bm_fixed').closest("div").addClass("has-error");
                alert("Please select only one(1) type of overiding computation for BMs");
                return;
            }else{
                $('#oi_bm_percentage').closest("div").removeClass("has-error");            
                $('#oi_bm_fixed').closest("div").removeClass("has-error");            
            }

            if (!isEmpty(oi_ffso_percentage) && !isEmpty(oi_ffso_fixed)){
                $('#oi_ffso_fixed').closest("div").addClass("has-error");
                $('#oi_ffso_percentage').closest("div").addClass("has-error");
                alert("Please select only one(1) type of overiding computation for BMs");
                return;
            }else{
                $('#oi_ffso_percentage').closest("div").removeClass("has-error");            
                $('#oi_ffso_fixed').closest("div").removeClass("has-error");            
            }

        }


        if (Plan_name == ''){
            $('#plan_name').closest("div").addClass("has-error");
            alert("Plan name is required");
            return;
        }else{
            $('#plan_name').closest("div").removeClass("has-error");            
        }

        if (Plan_Code == ''){
            $('#plan_code').closest("div").addClass("has-error");
            alert("Plan code is required");
            return;
        }else{
            $('#plan_code').closest("div").removeClass("has-error");                        
        }

        if (Eligibility == ''){
            $('#plan_eligibility').closest("div").addClass("has-error");
            alert("Eligibility is required");
            return;
        }else{
            $('#plan_eligibility').closest("div").removeClass("has-error");                                    
        }

        if (Amount == '' || Amount == 0){
            $('#plan_amount').closest("div").addClass("has-error");
            alert("Amount is required");
            return;
        }else{
            $('#plan_amount').closest("div").removeClass("has-error");                                    
        }

        if (Coverage == '' || Coverage == 0) {
            $('#plan_coverage').closest("div").addClass("has-error");
            alert("Coverage is required");
            return;
        }else{
            $('#plan_coverage').closest("div").removeClass("has-error");                                                
        }

        if (Term == '' || Term == 0) {
            $('#plan_term').closest("div").addClass("has-error");
            alert("Term is required");
            return;
        }else{
            $('#plan_term').closest("div").removeClass("has-error");                                                
        }


        if (Comp_Constant == 0 && (Agent_Share_1st < 1 || Agent_Share_2nd < 1 || BM_Share_1st < 1 || BM_Share_2nd < 1)) {

            if (Agent_Share_1st<1) $('#agent_share_1').closest("div").addClass("has-error");
            if (agent_share_2<1)   $('#agent_share_2').closest("div").addClass("has-error");
            if (BM_Share_1st<1)    $('#bm_share_1').closest("div").addClass("has-error");
            if (BM_Share_2nd<1)    $('#bm_share_2').closest("div").addClass("has-error");

            alert("BM and Agent Computation are required");
            return;
        }else{
             $('#agent_share_1').closest("div").removeClass("has-error");
             $('#agent_share_2').closest("div").removeClass("has-error");
             $('#bm_share_1').closest("div").removeClass("has-error");
             $('#bm_share_2').closest("div").removeClass("has-error");

        }

        if (Comp_Constant == 1 && (Const_BM_Share < 1 || Const_Agent_Share < 1)) {
            if (Const_BM_Share<1)    $('#bm_fixed').closest("div").addClass("has-error");
            if (Const_Agent_Share<1) $('#agent_fixed').closest("div").addClass("has-error");
            alert("BM and Agent Computation are required");
            return;
        }else{
            $('#bm_fixed').closest("div").removeClass("has-error");
            $('#agent_fixed').closest("div").removeClass("has-error");

        }


        if (Plan_id==""){
            mode='insert';
        }else{
            mode='update';
        }


         $.ajax({  
            type: 'GET',
            url: './proc/deplans_proc.php', 
            data: { 
                save_mode:mode,
                Plan_name:Plan_name,
                Plan_id:Plan_id,
                Plan_Code:Plan_Code,
                Eligibility:Eligibility,
                Payment_mode:Payment_mode,
                Amount:Amount,
                Coverage:Coverage,
                Term:Term,
                Constability:Constability,
                Agent_Share_1st:Agent_Share_1st,
                Agent_Share_2nd:Agent_Share_2nd,
                BM_Share_1st:BM_Share_1st,
                BM_Share_2nd:BM_Share_2nd,
                Applied_Date:Applied_Date,
                Const_BM_Share:Const_BM_Share,
                Const_Agent_Share:Const_Agent_Share,
                Comp_Constant:Comp_Constant,
                benefits_desc:benefits_desc,
                oi_computation:oi_computation,
                oi_ffso_percentage:oi_ffso_percentage,
                oi_ffso_fixed:oi_ffso_fixed,
                oi_bm_percentage:oi_bm_percentage,
                oi_bm_fixed:oi_bm_fixed
            },
            success: function(response) {
                 //prompt('response: ',response);

                 if (response.indexOf("**success**") > -1){

                    //0:**success**
                    //1:html row
                    var strarray=response.split('|');
                    var row = strarray[1];
                    if (mode=='update') {
                        $("#clientlist #row"+Plan_id).replaceWith( row );
                        alert("Update Successful!");

                    } else if (mode=='insert') {
                        $( "#clientlist" ).append( row );
                        alert("New Plan saved successfully.");
                        //window.location.reload();
                    }           
                    


                 }else if (response.indexOf("Notice") > -1){
                    alert("Save failed: An error has occured while saving data. Please contact your system developer. ");


                 }else if (response.indexOf("**noChanges**") > -1){
                        alert("Same data - no changes made");
                    

                 }
            }
        });       

    });

    //LOAD PLAN TO EDITOR
    $(document).on("click","#btnagentedit",function (e) {
        e.preventDefault();
        var Plan_name =$(this).attr('Plan_name');
        var Plan_id =$(this).attr('Plan_id');
        var Plan_Code =$(this).attr('Plan_Code');
        var Eligibility =$(this).attr('Eligibility');
        var Payment_mode =$(this).attr('Payment_mode');
        var Amount =$(this).attr('Amount');
        var Coverage =$(this).attr('Coverage');
        var Term =$(this).attr('Term');
        var Constability =$(this).attr('Constability');
        var Agent_Share_1st =$(this).attr('Agent_Share_1st');
        var Agent_Share_2nd     =$(this).attr('Agent_Share_2nd');
        var BM_Share_1st    =$(this).attr('BM_Share_1st');
        var BM_Share_2nd    =$(this).attr('BM_Share_2nd');
        var Applied_Date    =$(this).attr('Applied_Date');
        var Comp_Constant   =$(this).attr('Comp_Constant');
        var Const_BM_Share  =$(this).attr('Const_BM_Share');
        var Const_Agent_Share   =$(this).attr('Const_Agent_Share');
        var benefits_desc = $(this).attr('benefits_desc');

        $('#plan_name').val(Plan_name);
        $('#plan_id').val(Plan_id);
        $('#plan_code').val(Plan_Code);
        $('#plan_eligibility').val(Eligibility);
        $('#plan_mop').val(Payment_mode);
        $('#plan_amount').val(Amount);
        $('#plan_coverage').val(Coverage);
        $('#plan_term').val(Term);
        $('#plan_constability').val(Constability);
        $('#agent_share_1').val(Agent_Share_1st);
        $('#agent_share_2').val(Agent_Share_2nd);
        $('#bm_share_1').val(BM_Share_1st);
        $('#bm_share_2').val(BM_Share_2nd);
        $('#plan_applied_date').val(Applied_Date);
        $('#benefits_desc').val(benefits_desc);
        
        //BASIC INCENTIVES
        $('#bm_fixed').val(Const_BM_Share);
        $('#agent_fixed').val(Const_Agent_Share);
        $('#share_computation').val(Comp_Constant);

        if (Comp_Constant == 1){
            $("#comp_fixed").removeClass("hidden");
            $("#comp_percentage").addClass("hidden");
        }else{
            $("#comp_fixed").addClass("hidden");
            $("#comp_percentage").removeClass("hidden");
        }

        //LOAD OVERRIDING INCENTIVES
        if ($(this).attr('oi_computation')==1){
            $("#oi_computation").prop('checked', $(this).attr('oi_computation'));
            $("#oi_ffso_fixed").val($(this).attr('oi_ffso_fixed'));
            $("#oi_ffso_percentage").val($(this).attr('oi_ffso_percentage'));
            $("#oi_bm_fixed").val($(this).attr('oi_bm_fixed'));
            $("#oi_bm_percentage").val($(this).attr('oi_bm_percentage'));
            $('#overiding_inc').removeClass('hidden');
        }else{
            $("#oi_computation").prop('checked', false);
            $("#oi_ffso_fixed").val('');
            $("#oi_ffso_percentage").val('');
            $("#oi_bm_fixed").val('');
            $("#oi_bm_percentage").val('');
            $('#overiding_inc').addClass('hidden');            
        }


    })

/*
     $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
     });  
*/
    //SEARCH 
    $(document).on("click","#btnsearch",function(){
        var search_criteria = $('#search_criteria').val();

        $('#clientlist').html('');  
            $.ajax({  
                type: 'GET',
                url: './proc/planlistsearch_proc.php', 
                data: { 
                    search_criteria:search_criteria

                },
                success: function(response) {
                    // prompt(response,response);

                     if (response.indexOf("**success**") > -1){
                        //    0 - result status
                        //    1 - html table rows for detail section
                        //    2 - row count
                        var strarray=response.split('|');
                        
                         $('#clientlist').append(strarray[1]).fadeIn('slow');
                         $('#row_count').html( strarray[2] +' record found');

                     }else if (response.indexOf("**failed**") > -1){
                        $('#row_count').html('No record found');
                        alert('No record found');

                     }
                }
        });
    });
    
    //
    jQuery(document).ready(function() {
        $("#share_computation").on('change', function() {
            var computation_type = $(this).val();
            if (computation_type == 1){
                $("#comp_fixed").removeClass("hidden").fadeIn(500);
                $("#comp_percentage").fadeOut(500).addClass("hidden");
            }else{
                $("#comp_fixed").fadeOut(500).addClass("hidden");
                $("#comp_percentage").removeClass("hidden").fadeIn(500);

            }

        });

        $('#oi_computation').on('change',function(){
                var id = parseInt($(this).val(), 10);
                if($(this).is(":checked")) {
                    // checkbox is checked -> do something
                    $('#overiding_inc').removeClass('hidden').fadeIn(500);
                } else {
                    $('#overiding_inc').fadeOut(500).addClass('hidden');
                    // checkbox is not checked -> do something different
                }
        });


    });


</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <form action="#" method="post">            
            <fieldset>
                <legend>PLAN INFORMATION</legend>
                <div class='row'>
                    <div class='col-sm-2'>    
                        <div class='form-group'>
                            <label for="plan_code">CODE</label>
                            <input type="hidden" id="plan_id"/>
                            <input class="form-control" id="plan_code" name="plan[code]" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-5'>
                        <div class='form-group'>
                            <label for="plan_name">PLAN NAME</label>
                            <input class="form-control" id="plan_name" name="plan[name]" required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-5'>
                        <div class='form-group'>
                            <label for="plen_eligibility">ELIGIBILITY</label>
                            <input class="form-control" id="plan_eligibility" name="plan[eligibility]" required="true" size="30" type="text" />
                        </div>
                    </div>
                </div> 

                <div class='row'>
                    <div class='col-sm-4'>    
                        <div class='form-group'>
                            <label for="plan_mop">Mode of Payment</label>
                            <select class="form-control" id="plan_mop" name="plan[mop]" />
                                <option value="Monthly">Monthly</option>
                                <option value="Monthly">Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="plan_amount">AMOUNT</label>
                            <input class="form-control" id="plan_amount" name="plan[amount]" required="true" size="30" type="number" />
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="plan_coverage">COVERAGE</label>
                            <input class="form-control" id="plan_coverage" name="plan[coverage]" required="true" size="30" type="text" />
                        </div>
                    </div>
                </div> 

                <div class='row'>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="plan_term">TERM</label>
                            <input class="form-control" id="plan_term" name="plan[term]" required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="plan_constability">CONTESTABILITY</label>
                            <input class="form-control" id="plan_constability" name="plan[constability]" required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="plan_applied_date">APPLIED DATE</label>
                            <input class="form-control" id="plan_applied_date" name="plan[applied_date]" required="true" size="30" type="date" />
                        </div>
                    </div>

                </div>
                <div class="row hidden">
                    <div class='col-sm-12'>
                        <div class="form-group">
                          <label for="comment">Description of Benefits:</label>
                          <textarea class="form-control" rows="5" id="benefits_desc"></textarea>
                        </div>                    
                    </div>                    
                </div> 

            </fieldset>
            <hr>
            <fieldset>
                <legend>BASIC COMMISSION</legend>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='form-group'>
                            <label for="share_computation">MODE OF COMPUTATION</label>
                            <select class="form-control" id="share_computation" name="share[computation]">
                            <option value="0" selected="selected">Percentage</option>
                            <option value="1">Fixed Computation</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id=comp_percentage class="">
                    <div class='row'>
                        <div class='col-sm-6'>    
                            <div class='form-group'>
                                <label for="agent_share_1">% OF AGENT SHARE (for 1st 12 months)</label>
                                <input class="form-control" id="agent_share_1" name="agent[share1]" size="30" type="text" />
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <label for="agent_share_2">% OF AGENT SHARE (for more than 12 months)</label>
                                <input class="form-control" id="agent_share_2" name="agent[share2]" required="true" size="30" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-6'>    
                            <div class='form-group'>
                                <label for="bm_share_1">% OF BM SHARE (for 1st 12 months)</label>
                                <input class="form-control" id="bm_share_1" name="bm[share1]" size="30" type="text" />
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <label for="bm_share_2">% OF BM SHARE (for more than 12 months)</label>
                                <input class="form-control" id="bm_share_2" name="bm[share2]" required="true" size="30" type="text" />
                            </div>
                        </div>
                    </div>
                </div>  


                <div id=comp_fixed class="hidden">
                    <div class='row'>
                        <div class='col-sm-6'>    
                            <div class='form-group'>
                                <label for="bm_fixed">BM SHARE</label>
                                <input class="form-control" id="bm_fixed" name="bm[fixedshare]" size="30" type="text" />
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <label for="agent_fixed">AGENT SHARE</label>
                                <input class="form-control" id="agent_fixed" name="agent[fixedshare]" required="true" size="30" type="text" />
                            </div>
                        </div>
                    </div>
                </div>  
            </fieldset>


            <fieldset >
                <legend>OVERIDING INCENTIVES (for BM and/or FFSO Only)</legend>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='form-group'>
                            <input type="checkbox" id=oi_computation name=oi_computation class=""> With Overiding Incentives</input>
                        </div>
                    </div>
                </div>

                <div id=overiding_inc class="hidden" >
                    <div class='row'>
                        <div class='col-sm-6'>    
                            <div class='form-group'>
                                <label for="oi_bm_percentage">FOR BM (% OF THE AMOUNT PAID)</label>
                                <input class="form-control" id="oi_bm_percentage" name="agent[share1]" size="30" type="text" />
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <label for="oi_ffso_percentage">FOR FFSO (% OF THE AMOUNT PAID)</label>
                                <input class="form-control" id="oi_ffso_percentage" name="agent[share2]" required="true" size="30" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-sm-6'>    
                            <div class='form-group'>
                                <label for="oi_bm_fixed">FOR BM (AMOUNT PER PAYMENT)</label>
                                <input class="form-control" id="oi_bm_fixed" name="bm[share1]" size="30" type="text" />
                            </div>
                        </div>
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <label for="oi_ffso_fixed">FOR AGENT (AMOUNT PER PAYMENT)</label>
                                <input class="form-control" id="oi_ffso_fixed" name="bm[share2]" required="true" size="30" type="text" />
                            </div>
                        </div>
                    </div>
                <b>NOTE:</b> <br>LEAVE BLANK IF NOT APPLICABLE <br> USE ONLY WHOLE NUMBERS 
                </div>  

            </fieldset>



        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id=btnsharesave>Save</button>
      </div>
    </div>
  </div>
</div>