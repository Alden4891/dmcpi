


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Policy Forms</h1>
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
                                            <a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnformedit data-toggle=\"modal\" data-target=\"#myModal\"
                                                Plan_id =\"$Plan_id\"
                                                form_number=$form_number    
                                            >

                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <form id="uploadfile" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Form Information</legend>
                <div class='row'>
                   <div class='col-sm-8'>
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
                <p class="help-block">The template should be in jpg image file format. You can convert word document by saving it in pdf file format. Then use https://pdf2jpg.net to convert pdf document to jpg format</p>
              </div>

            </fieldset>
            <hr>
            <fieldset>
                <legend>VARIABLES</legend>
                <button type="button" class="btn btn-success pull-right" id=btnaddfield>ADD VARIABLE</button>
                <table class="table" id=fieldtable>
                <thead>
                  <tr>
                    <th>Field</th>
                    <th>Font</th>
                    <th width=10%>Size</th>
                    <th width=20%>Style</th>
                    <th width=10%>X-Coor</th>
                    <th width=10%>Y-Coor</th>
                    <th width=10%></th>

                  </tr>
                </thead>
                <tbody id=rowcontainer>
                  
                  <tr class="hidden" id="rowtemplate" rowtemplate>
                    <td>        

                    <div class="form-group">
                        <select class="form-control" id="field" name="field[]"  field-obj/>
                            <option value="">Please select</option>
                            <option value="Lname">Last Name</option>
                            <option value="Fname">First Name</option>
                            <option value="Mname">Middle Name</option>
                            <option value="Nname">Nick Name</option>
                            <option value="Sex">Sex</option>
                            <option value="Status">Marital Status</option>
                            <option value="Address">Address</option>
                            <option value="IDno">ID Number</option>
                            <option value="Bdate">Date of Birth</option>
                            <option value="Age">Age</option>
                            <option value="Bplace">Place of Birth</option>
                            <option value="Occupation">Occupation</option>
                            <option value="religion">Religion</option>

                            <option value="pname">Payor's Name</option>
                            <option value="page">Payor's Age</option>
                            <option value="prelation">Payor's Relation to Member</option>
                            <option value="pcontactno">Payor's Contact Number</option>

                            <option value="CollectionAddress">Collection Address</option>
                            <option value="mcontactno">Member's Contact Number</option>

                            <option value="bcontactno">Beneficiary's Contact Number</option>
                            <option value="bbdate">Beneficiary's Date of Birth</option>
                            <option value="bage">Beneficiary's Age</option>
                            <option value="brelation">Beneficiary's Relation</option>
                            <option value="religion">Beneficiary's Religion</option>
                            
                            <option value="agent_fullname">Agent's Name</option>
                            <option value="agent_id">Agent's No</option>
                            <option value="agent">Agent's Initial</option>
                            <option value="branch_manager">Branch Manager</option>
                            <option value="BManager_Initials">Branch Initial</option>
                            
                            <option value="ORdate">OR Date</option>
                            <option value="ORno">OR Number</option>
                            <option value="ORdate">PR Date</option>
                            <option value="ORno">PR Number</option>
                            <option value="amount">Initial Amount Paid</option>
 
                            <option value="ORdate">Collection Date</option>
                            <option value="CollectionAddress">Collection Address</option>

                        </select>

                        </div>
                    </td>
                    <td>      
                    <div class="form-group">      
                        <select class="form-control" id="font" name="font[]" font-obj/>
                            <option value="Arial" selected>Arial</option>
                            <option value="Courier">Time New Roman</option>
                            <option value="Helvetica">Helvetica</option>
                            <option value="Symbol">Symbol</option>
                            <option value="ZapfDingbats">ZapfDingbats</option>
                        </select>
                    </div>
                    </td>
                    <td>            
                    <div class="form-group">
                        <input class="form-control" id="fsize" id="fsize" name="fsize[]"  size="30" type="number" min="8" max="16" value="11" fsize-obj/>
                    </div>
                    </td>
                    <td>
                    <div class="form-group">
                        <select class="form-control" id="style" name="style[]" style-obj />
                            <option value="" selected>Regular</option>
                            <option value="U">Underline</option>
                            <option value="B">Bold</option>
                            <option value="I">Italicize</option>
                            <option value="BI">Bold+Italicize</option>
                            <option value="BU">Bold+Underline</option>
                            <option value="UI">Underline+Italicize</option>
                        </select>
                        </div>
                    </td>
                    <td>
                    <div class="form-group">
                        <input class="form-control"  name="xcoor[]"  id="xcoor" size="30" type="number"  min=1 max=500 value=1 step=".1"  x-obj/>
                    </div>
                    </td>
                    <td>
                    <div class="form-group">
                        <input class="form-control"  name="ycoor[]"  id="ycoor" size="30" type="number"  min=1 max=500 value=1 step=".1" y-obj/>
                    </div>
                    </td>
                    <td>
                        <a href="#" 
                        id=btnremovefield 
                        class="btn btn-danger btn-circle"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>

                  </tr>

                </tbody>
              </table>
            </fieldset>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id=btnformsave>Save</button>
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
    }else if ($('#file').val().substr( ($('#file').val().lastIndexOf('.') +1)) != 'jpg'){
        $("#file").replaceWith($("#file").val('').clone(true));
        alert("Invalid file type. Please select jpg file format!");
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

        var rowCount = $('#fieldtable tr').length;
        if (rowCount < 3) {
            alert("You forgot to add variables for entries!");
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
            url: './fpdf/reports/depolicy_proc.php', 
            data: new FormData(this),
            success: function(response) {
                    //alert(response);
                 if (response.indexOf("**success**") > -1){
                    //0:**success**
                    //1:html row

                    /*
                    var strarray=response.split('|');
                    var row = strarray[1];
                    
                    if (mode = 'insert'){
                        $( "#clientlist" ).append( row );
                    }else{
                        $("#clientlist #row"+Plan_id).replaceWith( row );
                    }
                        $('#btnformsave').prop( "disabled", true );
                    */
                    //no update all replace

                    $('#hidden_form_number').val(form_number);
                    alert('Policy Form #'+form_number+' saved!');
                    
                    window.location = "index.php?page=dePolicyForms";

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




    $.ajax({
        type: 'GET',
        url: './proc/getpolicyforminfo_proc.php', 
        data: { 
            Plan_id:-1
        },
        success: function(response) {

            $(".deletable_row").remove();
            $('#Plan_id').val(Plan_id);
            $('#form_number').val(form_number);
            $('#hidden_form_number').val(form_number);            
            $('#rowcontainer').append(response);
        }

    });



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

    $.ajax({
        type: 'GET',
        url: './proc/getpolicyforminfo_proc.php', 
        data: { 
            Plan_id:Plan_id
        },
        success: function(response) {

            $(".deletable_row").remove();
            $('#Plan_id').val(Plan_id);
            $('#form_number').val(form_number);
            $('#hidden_form_number').val(form_number);            
            $('#rowcontainer').append(response);
        }

    });
});


//-------------------------------------------------------------------------------------------------------------    
  $(document).on('change','#Plan_id', function() {
        var e = document.getElementById("Plan_id");
        var Plan_id = e.options[e.selectedIndex].value;
        $('#form_number').val(Plan_id);
        
  });

    //DELETE PLAN
    $(document).on("click","#btnformdelete",function (e) {
        e.preventDefault();    
        var ClientCount =$(this).attr('ClientCount');
        if (ClientCount > 0) {
            alert("Unable to delete this plan. You have an exisitng record associated with this plan");
            return;
        }
        if (confirm("You are about to delete this form?. Do you want to continue?")){
            var Plan_id =$(this).attr('Plan_id');
            var form_number =$(this).attr('form_number');

            
                 $.ajax({  
                    type: 'GET',
                    url: './proc/depolicyformdelete_proc.php', 
                    data: { 
                        mode:'delete',
                        Plan_id:Plan_id,
                        form_number:form_number                    },
                    success: function(response) {
                      //   prompt(response,response);
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
