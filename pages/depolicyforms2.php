


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Upload Policy Template</h1>
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

                <a href="#"
                Plan_id ="-1"
                form_number="0"    
                class="btn btn-info" id=btnHelp data-toggle="modal" data-target="#myModalHelp">Variables</a>

                <a href="#"
                Plan_id ="-1"
                form_number="0"    
                class="btn btn-success" id=btnNewForm data-toggle="modal" data-target="#myModal">New Template</a>
                </div>
                <br><br>

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Plan Code</th>
                            <th>Package Name</th>
                            <th>Eligibility</th>
                            <th>Coverage</th>
                            <th>Term</th>
                            <th>Contestability</th>
                            <th>For Year</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist class="clientlist">
                    <div id=dummyrow></div>
                        <?php 



                            $res_package = mysqli_query($con, "

                                SELECT
                                    `Plan_id`
                                    , `Plan_Code`
                                    , `Plan_name`
                                    , `Eligibility`
                                    , `Coverage`
                                    , `Term`
                                    , `Constability`
                                    , `form_number`
                                    , YEAR(`Applied_Date`) AS `For_Year`
                                FROM
                                    `dmcpi1_dmcsm`.`packages`
                                WHERE NOT form_number IS NULL                                 

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_package,MYSQLI_ASSOC)) {
                                
                                $Plan_id = $r['Plan_id']; 
   
                                $Plan_Code = $r['Plan_Code']; 
                                $Plan_name = $r['Plan_name']; 
                                $Eligibility = $r['Eligibility']; 
                                $Coverage = $r['Coverage'];
                                $Term = $r['Term'];
                                $Constability = $r['Constability'];
                                $form_number = $r['form_number'];
                                $For_Year = $r['For_Year'];

                                echo "
                                    <tr id=row$Plan_id>
                                        <td class=\"even gradeC\"> $Plan_Code</td>
                                        <td>$Plan_name</td>
                                        <td>$Eligibility</td>
                                        <td>$Coverage</td>
                                        <td>$Term</td>
                                        <td>$Constability</td>
                                        <td>$For_Year</td>
                                        
                                        <td>
                                            <!--a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnformedit data-toggle=\"modal\" data-target=\"#myModal\"
                                                Plan_id =\"$Plan_id\"
                                                form_number=$form_number    
                                            >
                                            <i class=\"glyphicon glyphicon-edit\"></i></a-->
                                            
                                           
                                            <a href=\"tbs/templates/$form_number.docx\" class=\"btn btn-xs btn-success btn-circle\">
                                            <i class=\"glyphicon glyphicon-download-alt\"></i></a>


                                            <a href=\"#?Plan_id=$Plan_id\" 
                                            Plan_id=$Plan_id
                                            id=btnformdelete 
                                            form_number=$form_number
                                            class=\"btn btn-xs btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_package);
                            
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


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <form id="uploadfile" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Upload Form Policy</legend>
                <div class='row'>
                   <div class='col-sm-12'>
                  
                  
                  <div class="alert alert-success alert-dismissible " role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Note: </strong> 1. Don't forget to set the 
                    <a href="#"
                Plan_id ="-1"
                form_number="0"    
                 data-toggle="modal" data-target="#myModalHelp">variables</a>
                     in the template. <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. Save the template in *.docx format (Open in word and save as docx).
                  </div>                        
                  

                        <div class='form-group'>
                            <label for="Plan_id">PLAN</label>
                            <select class="form-control" id="Plan_id" name="Plan_id" />
                                <option value="">Please select</option>
                                <?php
                                    $res_plan = mysqli_query($con,"SELECT Plan_id AS 'id', CONCAT(Plan_Code,' --- ', Plan_name) AS 'value'  FROM packages ORDER BY Plan_Code");

                                         while ($r=mysqli_fetch_array($res_plan,MYSQLI_ASSOC)) {
                                            $id = $r['id'];
                                            $value = $r['value'];
                                            echo "<option value=\"$id\">$value</option>";
                                         }


                                    mysqli_free_result($res_plan);
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <!--label for="form_number">FORM NUMBER</label-->
                            <input class="form-control" id="form_number" name="form_number" required="true" size="30" type="hidden" />
                            <input type="hidden" name="hidden_form_number" id="hidden_form_number" value="0" />
                        </div>
                    </div>
                </div> 
             <div class="form-group">
                <label for="form_template">POLICY FORM TEMPLATE</label>
                <input type="file" id="file" name="file">
                <p class="help-block">The template should be in docx format. </p>
              </div>

            </fieldset>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id=btnformsave>Upload</button>
      </div>
        </form>

    </div>
  </div>
</div>

<!-- Modal Help -->
<div class="modal fade" id="myModalHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_comm_alterLabel">TABLE OF VARIABLES FOR POLICY FORM</h4>
      </div>
      <div class="modal-body">

          <p class="lead">Memeber's Information</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                    <tr><th style='width:35%'>[onshow.fname]</th><td>Given name</td></tr>
                    <tr><th style='width:35%'>[onshow.mname]</th><td>Middle name</td></tr>
                    <tr><th style='width:35%'>[onshow.lname]</th><td>Last name</td></tr>
                    <tr><th style='width:35%'>[onshow.nick]</th><td>Nick name</td></tr>
                    <tr><th style='width:35%'>[onshow.sex]</th><td>Sex</td></tr>
                    <tr><th style='width:35%'>[onshow.cstatus]</th><td>Civil Status</td></tr>
                    <tr><th style='width:35%'>[onshow.m_cont]</th><td>Member's contact number</td></tr>
                    <tr><th style='width:35%'>[onshow.address]</th><td>Residence address</td></tr>
                    <tr><th style='width:35%'>[onshow.valid_id]</th><td>Member's Valid ID</td></tr>
                    <tr><th style='width:35%'>[onshow.dob]</th><td>Date of Birth</td></tr>
                    <tr><th style='width:35%'>[onshow.age]</th><td>Age</td></tr>
                    <tr><th style='width:35%'>[onshow.pob]</th><td>Birth Place</td></tr>
                    <tr><th style='width:35%'>[onshow.occupation]</th><td>Occupation</td></tr>
                    <tr><th style='width:35%'>[onshow.religion]</th><td>Religious affiliation</td></tr>
              </tbody>
            </table>
          </div>
          <hr>

          <p class="lead">Payor's Information</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                    <tr><th style='width:35%'>[onshow.p_name]</th><td>Payor's Name</td></tr>
                    <tr><th style='width:35%'>[onshow.p_age]</th><td>Payor's Age</td></tr>
                    <tr><th style='width:35%'>[onshow.p_relation]</th><td>Relation of the payor to the member</td></tr>
                    <tr><th style='width:35%'>[onshow.p_cont]</th><td>Payor's contact number</td></tr>
                    <tr><th style='width:35%'>[onshow.p_address]</th><td>Payor's Address</td></tr>
              </tbody>
            </table>
          </div>
          <hr>

          <p class="lead">Beneficiaries's Information</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                    <tr><th style='width:35%'>[onshow.b_cont]</th><td>Contact Number</td></tr>
                    <tr><th style='width:35%'>[onshow.b_name]</th><td>Name</td></tr>
                    <tr><th style='width:35%'>[onshow.b_dob]</th><td>Date of Birth</td></tr>
                    <tr><th style='width:35%'>[onshow.b_age]</th><td>Age</td></tr>
                    <tr><th style='width:35%'>[onshow.b_relation]</th><td>Relation to Head</td></tr>
                    <tr><th style='width:35%'>[onshow.b_cstatus]</th><td>Civil Status</td></tr>
              </tbody>
            </table>
          </div>
          <hr>

          <p class="lead">Agent's Information</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                    <tr><th style='width:35%'>[onshow.a_name]</th><td>Name of the agent</td></tr>
                    <tr><th style='width:35%'>[onshow.a_id]</th><td>ID Number</td></tr>
                    <tr><th style='width:35%'>[onshow.a_code]</th><td>Agent Code</td></tr>
                    <tr><th style='width:35%'>[onshow.a_branch]</th><td>Branch</td></tr>
                    <tr><th style='width:35%'>[onshow.a_branchcode]</th><td>Branch Code</td></tr>
              </tbody>
            </table>
          </div>
          <hr>
                    

          <p class="lead">Payment Information</p>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                    <tr><th style='width:35%'>[onshow.prdate]</th><td>PR Date</td></tr>
                    <tr><th style='width:35%'>[onshow.prno]</th><td>PR Number</td></tr>
                    <tr><th style='width:35%'>[onshow.ordate]</th><td>OR Date</td></tr>
                    <tr><th style='width:35%'>[onshow.orno]</th><td>Or Number</td></tr>
                    <tr><th style='width:35%'>[onshow.amount]</th><td>Amount Paid</td></tr>
                    <tr><th style='width:35%'>[onshow.cdate]</th><td>Collection Date</td></tr>
                    <tr><th style='width:35%'>[onshow.caddress]</th><td>Collection Address</td></tr>
              </tbody>
            </table>
          </div>
          <hr>
                    

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
        </form>

    </div>
  </div>
</div>


<script>

$('#file').bind('change', function() {
    if (this.files[0].size > 1000000){
        $("#file").replaceWith($("#file").val('').clone(true));
        alert("The file is too huge. Please make sure that the file size will not exceed to 1MB");
        return;
    }else if ($('#file').val().substr( ($('#file').val().lastIndexOf('.') +1)) != 'docx'){
        $("#file").replaceWith($("#file").val('').clone(true));
        alert("Invalid file type. Please select *.xlsx file format!");
        return;        
    }
});

$(document).ready(function (e) {
    //SAVE form
    $('#uploadfile').on("submit",function (e) {
        e.preventDefault();    

        var Plan_id=$('#Plan_id').val();
        var form_number=$('#form_number').val();
        var hidden_form_number = $('#hidden_form_number').val();
        var file = $('#file').val();
        var error_count = 0;
        var mode = '';

        if (file=='' && hidden_form_number=="0"){
            $('#file').closest("div").addClass("has-error");
            error_count+=1;
        }else{
            $('#file').closest("div").removeClass("has-error");            
        }

        if (Plan_id == ''){
            $('#Plan_id').closest("div").addClass("has-error");
            error_count+=1;
        }else{
            $('#Plan_id').closest("div").removeClass("has-error");            
        }

        if (form_number == '' || form_number <= 0){
            $('#form_number').closest("div").addClass("has-error");
            error_count+=1;
        }else{
            $('#form_number').closest("div").removeClass("has-error");                        
        }

        //field validation
        $('#uploadfile select').each(function(){            
            if (this.hasAttribute("field-obj") && this.closest('tr').hasAttribute('rowtemplate')==false){ 
                if ($(this).val().trim() == '') {
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error"); 
                }
            }
        });

        if (error_count>0){
            alert("You have to input all entries!");
            return;
        }

        if (hidden_form_number=="0"){
            mode='insert';
        }else{
            mode='update';
        }

         $.ajax({  
            contentType: false,       
            cache: false,             
            processData:false,        
            type: 'POST',
            url: './tbs/depolicy_proc2.php', 
            data: new FormData(this),
            success: function(response) {
                 //alert(response);
                 if (response.indexOf("**success**") > -1){
    
                    $('#hidden_form_number').val(form_number);
                    alert('Policy Form #'+form_number+' saved!');
                    
                    window.location = "index.php?page=dePolicyForms2";

                 }else if (response.indexOf("Notice") > -1){
                    alert("Save failed: An error has occured while saving data. Please contact your system developer. ");
                 }else if (response.indexOf("**noChanges**") > -1){
                        alert("Same data - no changes made");
                 }
            }
        });       

    });

});


//NEW PLAN
$(document).on("click","#btnNewForm",function (e) {
    e.preventDefault();
    $('#plan_id').val('');
    $('#form_number').val('0');
    $('#hidden_form_number').val(0);            
    //$('#form_number').prop( "readonly", false );
    //$('#Plan_id').prop( "readonly", false );
    $(".deletable_row").remove();
    $('#btnformsave').prop( "disabled", false );

    $('#Plan_id').val(Plan_id);
    $('#form_number').val(form_number);
    $('#hidden_form_number').val(form_number);            

});

//modal: add row
 $(document).on("click","#btnaddfield", function(e){
    var row = $("#rowtemplate").html();
    $("#rowcontainer").append('<tr class="deletable_row">'+row+'</tr>');

 });

 //modal: variable remove
$(document).on("click","#btnremovefield", function(e){
    if (confirm("You are about to remove this variable. Do you want to continue?")){
        var tr = $(this).closest("tr");
        tr.fadeOut("normal", function(){
            tr.remove();
        });        
    }
 });

//LOAD PLAN TO EDITOR
$(document).on("click","#btnformedit",function (e) {
    e.preventDefault();
    var Plan_id = $(this).attr('Plan_id');
    var form_number = $(this).attr('form_number');
    $('#btnformsave').prop( "disabled", false );

});


//-------------------------------------------------------------------------------------------------------------    
  $(document).on('change','#Plan_id', function() {
        var e = document.getElementById("Plan_id");
        var Plan_id = e.options[e.selectedIndex].value;
        $('#form_number').val(Plan_id);
        
  });

    //DELETE POLICY
    $(document).on("click","#btnformdelete",function (e) {
        e.preventDefault();    
        var ClientCount =$(this).attr('ClientCount');
        if (ClientCount > 0) {
            alert("Unable to delete this policy. You have an exisitng record associated with this policy");
            return;
        }
        if (confirm("You are about to delete this policy template?. Do you want to continue?")){
            var Plan_id =$(this).attr('Plan_id');
            var form_number =$(this).attr('form_number');
                 $.ajax({  
                    type: 'GET',
                    url: './tbs/depolicyformdelete_proc2.php', 
                    data: { 
                        mode:'delete',
                        Plan_id:Plan_id,
                        form_number:form_number                    },
                    success: function(response) {
                         //prompt(response,response);
                         if (response.indexOf("**success**") > -1){
                            $("#clientlist #row"+Plan_id).remove();     
                            alert("Polciy Form #"+form_number+" deleted successfully");                      
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Delete failed!");
                         }
                    }
                });  
        }
    });
    

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    
/*
     $('.datepicker').datepicker({
        format: 'mm/dd/yyyy'
     });  
*/

</script>
