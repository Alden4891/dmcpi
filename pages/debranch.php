


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">DMCPI Branch Profile</h1>
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
                <a href="#" class="btn btn-success" id=btnNewBranch data-toggle="modal" data-target="#myModal">New Branch</a>
                </div>
                <br><br>

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>CODE</th>
                            <th>BRANCH NAME</th>
                            <th>MANAGER</th>
                            <th>OFFICE</th>
                            <th>NUMBER OF CLIENTS</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist class="clientlist">
                    <div id=dummyrow></div>
                        <?php 
                            $res_branches = mysqli_query($con, "
                        SELECT
                                    `branch_details`.`Branch_ID`
                                    , `branch_details`.`Branch_Name`
                                    , CONCAT(LEFT(`branch_details`.BRANCH_NAME,1),`branch_details`.Branch_ID) AS Branch_Code
                                    , `branch_details`.`Branch_Manager`
                                    , `branch_details`.`mainoffice`
                                    , COUNT(`members_account`.`Member_Code`) AS `No_of_clients`
                                FROM
                                    `dmcpi1_dmcsm`.`members_account`
                                    RIGHT JOIN `dmcpi1_dmcsm`.`branch_details` 
                                        ON (`members_account`.`BranchManager` = `branch_details`.`Branch_ID`)
                                GROUP BY `branch_details`.`Branch_ID`, `branch_details`.`Branch_Name`, `branch_details`.`Branch_Manager`, `branch_details`.`mainoffice`
                                ORDER BY `branch_details`.`Branch_Name` ASC

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_branches,MYSQLI_ASSOC)) {
                                
                                $Branch_ID = $r['Branch_ID']; 
                                $Branch_Name = $r['Branch_Name']; 
                                $Branch_Code = $r['Branch_Code']; 
                                $Branch_Manager = $r['Branch_Manager']; 
                                $mainoffice = $r['mainoffice']; 
                                $No_of_clients = $r['No_of_clients'];


                                echo "
                                    <tr id=row$Branch_ID>
                                        <td class=\"even gradeC\"> $Branch_Code</td>
                                        <td>$Branch_Name</td>
                                        <td>$Branch_Manager</td>
                                        <td>".($mainoffice==0?"Branch office":"Main Office")."</td>
                                        <td>$No_of_clients</td>
                                       
                                        <td>
                                            <a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"
                                                Branch_ID     =\"$Branch_ID\"
                                                Branch_Name =\"$Branch_Name\"
                                                Branch_Code =\"$Branch_Code\"
                                                Branch_Manager =\"$Branch_Manager\"
                                                mainoffice =\"$mainoffice\"
                                                No_of_clients =\"$No_of_clients\"
                                            >

                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
                                            <a href=\"#\" 
                                            Branch_ID=$Branch_ID
                                            No_of_clients=\"$No_of_clients\" 
                                            id=btnbranchdelete 
                                            class=\"btn btn-xs btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    
    
    $(document).on("click","#btnNewBranch",function (e) {
        e.preventDefault();

        $('#Branch_ID').val('');
        $('#Branch_Name').val('');
        $('#Branch_Code').val('');
        $('#Branch_Manager').val('');
        $('#mainoffice').val('');
        $('#No_of_clients').val('');

    });

    //DELETE PLAN
    $(document).on("click","#btnbranchdelete",function (e) {
        e.preventDefault();    
        var ClientCount =$(this).attr('No_of_clients');
        if (ClientCount > 0) {
            alert("Unable to delete this branch. You have an exisitng record associated with this him/her");
            return;
        }
        if (confirm("You are about to remove this branch. Do you want to continue?")){
            var Branch_ID =$(this).attr('Branch_ID');

            
                 $.ajax({  
                    type: 'GET',
                    url: './proc/debranch_proc.php', 
                    data: { 
                        save_mode:'delete',
                        Branch_ID:Branch_ID
                    },
                    success: function(response) {
                         if (response.indexOf("**success**") > -1){
                            $("#clientlist #row"+Branch_ID).remove();                           
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Delete failed!");
                           
                         }
                    }
                });  
        }
    });
    

    
    //SAVE PLAN
    $(document).on("click","#btnbranchsave",function (e) {
        e.preventDefault();    

        var Branch_ID=$('#Branch_ID').val();
        var No_of_clients=$('#No_of_clients').val(); 
        var Branch_Name=$('#Branch_Name').val();
        var Branch_Code=$('#Branch_Code').val();
        var Branch_Manager=$('#Branch_Manager').val();
        var mainoffice=$('#mainoffice').val();

        var mode = '';


        
        if (Branch_Name == ''){
            $('#Branch_Name').closest("div").addClass("has-error");
            alert("Branch name is required");
            return;
        }else{
            $('#Branch_Name').closest("div").removeClass("has-error");            
        }
        if (Branch_Code == ''){
            $('#Branch_Code').closest("div").addClass("has-error");
            alert("Branch Code is required");
            return;
        }else{
            $('#Branch_Code').closest("div").removeClass("has-error");            
        }
        if (Branch_Manager == ''){
            $('#Branch_Manager').closest("div").addClass("has-error");
            alert("Branch manager is required");
            return;
        }else{
            $('#Branch_Manager').closest("div").removeClass("has-error");            
        }

        if (Branch_ID==""){
            mode='insert';
        }else{
            mode='update';
        }

         $.ajax({  
            type: 'GET',
            url: './proc/debranch_proc.php', 
            data: { 
                save_mode:mode,
                Branch_ID:Branch_ID,
                Branch_Name:Branch_Name,
                Branch_Code:Branch_Code,
                Branch_Manager:Branch_Manager,
                No_of_clients:No_of_clients,
                mainoffice:mainoffice                
            },
            success: function(response) {
                 if (response.indexOf("**success**") > -1){

                    //0:**success**
                    //1:html row
                    var strarray=response.split('|');
                    var row = strarray[1];
                    if (mode=='update') {
                        $("#clientlist #row"+Branch_ID).replaceWith( row );
                        alert("Update Successful!");
                        window.location = "index.php?page=debranch"; 


                    } else if (mode=='insert') {
                        $( "#clientlist" ).append( row );
                        //row.insertBefore("#dataTables-clientlist tr:first");
                        //$("#dataTables-sample tr:first").before(row);
                        //$("#dataTables-example tr:first").after(row);
                        //row.before("#dataTables-example tr:first");
                        
                        //$("#clientlist tr:first").insertBefore(row);
                        alert("New branch added successfully.");
                        //window.location.reload();
                        window.location = "index.php?page=debranch"; 
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
        var Branch_ID =$(this).attr('Branch_ID');
        var Branch_Name =$(this).attr('Branch_Name');
        var Branch_Code =$(this).attr('Branch_Code');
        var Branch_Manager =$(this).attr('Branch_Manager');
        var mainoffice =$(this).attr('mainoffice');
        var No_of_clients =$(this).attr('No_of_clients');

        $('#Branch_ID').val(Branch_ID);
        $('#Branch_Name').val(Branch_Name);
        $('#Branch_Code').val(Branch_Code);
        $('#Branch_Manager').val(Branch_Manager);
        $('#mainoffice').val(mainoffice);
        $('#No_of_clients').val(No_of_clients);

    });

   
    

</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Branch Information</h4>
      </div>
      <div class="modal-body">

            <form class="form-horizontal">
            <fieldset>

            <input type="hidden" id="Branch_ID"/>
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="Branch_Code">Branch Code</label>  
              <div class="col-md-8">
              <input id="Branch_Code" name="Branch_Code" type="text" placeholder="" class="form-control input-md" required="">
              <span class="help-block">Unique Identifier of branch e.g. R01</span>  
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="Branch_Name">NAME</label>  
              <div class="col-md-8">
              <input id="Branch_Name" name="Branch_Name" type="text" placeholder="" class="form-control input-md" required="">
              <span class="help-block">Name of the branch office.</span>  
              </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="Branch_Manager">Branch Manager</label>  
              <div class="col-md-8">
              <input id="Branch_Manager" name="Branch_Manager" type="text" placeholder="" class="form-control input-md" required="">
              <span class="help-block">Name of the branch manager</span>  
              </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
              <label class="col-md-4 control-label" for="mainoffice">Select Basic</label>
              <div class="col-md-4">
                <select id="mainoffice" name="mainoffice" class="form-control">
                  <option value="0">Branch Office</option>
                  <option value="1">Main Office</option>
                </select>
              </div>
            </div>


            </fieldset>
            </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id=btnbranchsave>Save</button>
      </div>
    </div>
  </div>
</div>