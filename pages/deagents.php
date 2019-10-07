<?php

    $res_recuiter = mysqli_query($con, 
    "SELECT AGENTID AS ID, CONCAT(First_name,' ',Middle_Name,' ',Last_name, ' (FFSO)') AS RECUITER, `TYPE` FROM agent_profile WHERE `type` IN ('FFSO')
        UNION
        SELECT Branch_ID, IF(Branch_Manager='ANONYMOUS',CONCAT('BM OF ',Branch_Name), CONCAT(Branch_Manager, ' (BM OF ',Branch_Name,')')) AS `BRANCH MANAGER`,'BM' AS `TYPE` FROM branch_details") or die(mysqli_error());


    $res_branches = mysqli_query($con, "SELECT Branch_ID, Branch_Name FROM branch_details ORDER BY Branch_Name;") or die(mysqli_error());
    $res_agents = mysqli_query($con, "

    SELECT
          `agent_profile`.`AgentID`
        , `agent_profile`.`First_name`
        , `agent_profile`.`Middle_Name`
        , `agent_profile`.`Last_name`
        , `agent_profile`.`Initials`

        , `agent_profile`.`Birth_Date`
        , `agent_profile`.`Age`
        , `agent_profile`.`Sex`
        , `agent_profile`.`Status`
        , `agent_profile`.`Contact_No`

        , `agent_profile`.`Street`
        , `agent_profile`.`Barangay`
        , `agent_profile`.`City`
        , `agent_profile`.`Province`
        , `agent_profile`.`type` AS `agent_type` 

#        , COUNT(`members_account`.`Member_Code`) AS `No_of_clients`
        , `branch_details`.`Branch_Manager`
        , `branch_details`.`mainoffice`
        , `branch_details`.`Branch_ID`        
        , CONCAT(referrer_id,'|',referrer_type) AS referrer
    
    FROM
        `dmcpi1_dmcsm`.`agent_profile`
        LEFT JOIN `dmcpi1_dmcsm`.tbl_branchagents
            ON (`agent_profile`.`AgentID` = `tbl_branchagents`.`AgentID`)
        LEFT JOIN `dmcpi1_dmcsm`.`branch_details` 
            ON (`branch_details`.Branch_ID = `tbl_branchagents`.`Branch_ID`)
    WHERE `agent_profile`.`AgentID` > - 1
    GROUP BY `agent_profile`.`Initials`, `agent_profile`.`First_name`, `agent_profile`.`Middle_Name`, `agent_profile`.`Last_name`, `agent_profile`.`Sex`, `agent_profile`.`type`
    ORDER BY AgentID DESC;


    ") or die(mysqli_error());


    


?>


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">AGENT PROFILE</h1>
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

                <a href="#" class="btn btn-success" id=btnNewAgent data-toggle="modal" data-target="#myModal">New Agent</a>

                </div>
                <br><br>

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>AGENT ID</th>
                            <th>AGENT</th>
                            <th>INITIALS</th>

                            <th>SEX</th>
                            <th>CONTACT NO.</th>

                            <th>CITY</th>
                            <th>AGENT STATUS</th>
                            <th>BRANCH MANAGER</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist class="clientlist">
                    <div id=dummyrow></div>
                        <?php 
                            while ($r=mysqli_fetch_array($res_agents,MYSQLI_ASSOC)) {
                                
                                $AgentID = $r['AgentID']; 
                                $First_name = $r['First_name']; 
                                $Middle_Name = $r['Middle_Name']; 
                                $Last_name = $r['Last_name']; 
                                $Initials = $r['Initials']; 
                                $fullname = "$Last_name, $First_name $Middle_Name";
                                $Birth_Date = $r['Birth_Date'];
                                $Age = $r['Age'];
                                $Sex = $r['Sex'];
                                $Status = $r['Status'];
                                $Contact_No = $r['Contact_No'];

                                $Street     = $r['Street'];
                                $Barangay    = $r['Barangay'];
                                $City    = $r['City'];
                                $Province    = $r['Province'];
                                $type   = $r['agent_type'];

                                $Branch_ID = $r['Branch_ID'];
                                $Branch_Manager   = $r['Branch_Manager'];
                                $mainoffice = $r['mainoffice'];

                                $referrer=$r['referrer'];


                                echo "
                                    <tr class=rowentry id=row$AgentID>
                                        <td class=\"even gradeC\"> $AgentID</td>
                                        <td>$fullname</td>
                                        <td>$Initials</td>

                                        <td>$Sex</td>
                                        <td>$Contact_No</td>
                                       
                                        <td>$City</td>
                                        <td>$type</td>
                                        <td>$Branch_Manager</td>

                                        <td>
                                            <a href=\"#\" class=\"btn btn-success btn-xs btn-circle\" id=btnagentedit data-toggle=\"modal\" data-target=\"#myModal\"
                                                agent_id     =\"$AgentID\"
                                                agent_fname =\"$First_name\"
                                                agent_mname =\"$Middle_Name\"
                                                agent_lname =\"$Last_name\"
                                                agent_initials =\"$Initials\"
                                                
                                                agent_dob =\"$Birth_Date\"
                                                agent_age    =\"$Age\"
                                                agent_sex =\"$Sex\"
                                                agent_mstatus =\"$Status\"
                                                agent_contact =\"$Contact_No\"
                                                
                                                agent_street     =\"$Street\"
                                                agent_barangay    =\"$Barangay\"
                                                agent_city    =\"$City\"
                                                agent_province    =\"$Province\"
                                                agent_type   =\"$type\"
                                                
                                                Branch_Manager   =\"$Branch_Manager\"
                                                mainoffice = \"$mainoffice\"
                                                Branch_ID=\"$Branch_ID\"

                                                referrer = \"$referrer\"
                                            >

                                            <i class=\"glyphicon glyphicon-edit\"></i></a>
                                            <a href=\"#\" 
                                            AgentID=$AgentID
                                            id=btnagentdelete 
                                            class=\"btn btn-xs  btn-danger btn-circle\"><i class=\"glyphicon glyphicon-trash\"></i></a>

                                        </td>
                                </tr>

                                ";


                            }
                            
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
        <form action="#" method="post">            
            <fieldset>
                <legend>AGENT INFORMATION</legend>
                <div class='row'>
                    <div class='col-sm-4'>    
                        <div class='form-group'>
                            <label for="agent_fname">FIRST NAME</label>
                            <input type="hidden" id="agent_id"/>
                            <input class="form-control" id="agent_fname"  size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="agent_mname">MIDDLE NAME</label>
                            <input class="form-control" id="agent_mname"  required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-4'>
                        <div class='form-group'>
                            <label for="agent_lname">LAST NAME</label>
                            <input class="form-control" id="agent_lname"  required="true" size="30" type="text" />
                        </div>
                    </div>
                </div> 

                <div class='row'>
                    <div class='col-sm-3'>    
                        <div class='form-group'>
                            <label for="plan_mop">Sex</label>
                            <select class="form-control" id="agent_sex" />
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-sm-3'>    
                        <div class='form-group'>
                            <label for="agent_mstatus">Marital Status</label>
                            <select class="form-control" id="agent_mstatus"  />
                                <option value="SINGLE">Single</option>
                                <option value="MARRIED">Married</option>
                                <option value="WIDOWED">Widowed/Widower</option>
                                <option value="WIDOWED">SEPARATED</option>
                                <option value="WIDOWED">ANNULED</option>
                            </select>
                        </div>
                    </div>

                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_dob">Date of Birth</label>
                            <input class="form-control datepicker" id="agent_dob"  required="true" size="30" type="date" />
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_contact">Contact Number</label>
                            <input class="form-control" id="agent_contact"  required="true" size="30" type="text" />
                        </div>
                    </div>
                </div> 

                <div class='row'>
                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_province">Province</label>
                            <input class="form-control" id="agent_province"  required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_city">City</label>
                            <input class="form-control" id="agent_city"  required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_barangay">Barangay</label>
                            <input class="form-control" id="agent_barangay"  required="true" size="30" type="text" />
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_street">Street</label>
                            <input class="form-control" id="agent_street"  required="true" size="30" type="text" />
                        </div>
                    </div>
                </div>


                <div class='row'>

                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="branch_office">Branch</label>
                            <select class="form-control" id="branch_office" />
                                <?php
                                
                                echo "<option value=-1>Select</option>";
                                while ($r=mysqli_fetch_array($res_branches,MYSQL_ASSOC)) {
                                    $Branch_ID = $r['Branch_ID'];
                                    $Branch_Name = $r['Branch_Name'];
                                    echo "<option value=\"$Branch_ID\">$Branch_Name</option>";
                                }
                                

                                ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class='col-sm-3'>
                        <div class='form-group'>
                            <label for="agent_type">Agent Status</label>
                            <select class="form-control" id="agent_type" />
                                <option value="">NON-FFSO</option>
                                <option value="FFSO">FFSO</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                        </div>
                    </div>

                    <div class='col-sm-6 hidden' id=recuiter_container>
                        <div class='form-group'>
                            <label for="agent_referrer">Recruited by</label>
                            <select class="form-control" id="agent_referrer" />
                                <?php
                                
                                echo "<option value=-1>Select</option>";
                                while ($r=mysqli_fetch_array($res_recuiter,MYSQL_ASSOC)) {
                                    $RECUITER_ID = $r['ID'];
                                    $RECUITER_NAME = $r['RECUITER'];
                                    $RECUITER_TYPE = $r['TYPE'];

                                    echo "<option value=\"$RECUITER_ID|$RECUITER_TYPE\">$RECUITER_NAME</option>";
                                }
                                

                                ?>
                                
                            </select>
                        </div>
                    </div>


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

<?php
mysqli_free_result($res_agents);
mysqli_free_result($res_branches);
mysqli_free_result($res_recuiter);

?>



<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

$('#agent_type').on('change',function(e){    
      var value = $(this).val();
      if (value==""){           //NON-FFSO
            $('#recuiter_container').removeClass("hidden");
      }else{
            $('#recuiter_container').addClass("hidden");
            $('#agent_referrer').val(-1);
      }
});
    
    //new agent
    $(document).on("click","#btnNewAgent",function (e) {
        e.preventDefault();

        $('#agent_id').val('');

        $('#agent_fname').val('');
        $('#agent_lname').val('');
        $('#agent_mname').val('');
        $('#agent_type').val('');
        $('#branch_office').val('');

        $('#agent_sex').val('Male');
        $('#agent_mstatus').val('Single');
        $('#agent_dob').val('');
        $('#agent_contact').val('');

        $('#agent_barangay').val('');
        $('#agent_province').val('');
        $('#agent_city').val('');
        $('#agent_street').val('');

        $('#referrer').val('');
        $('#recuiter_container').removeClass("hidden");



    });

    //DELETE PLAN
    $(document).on("click","#btnagentdelete",function (e) {
        e.preventDefault();    
        var AgentID =$(this).attr('AgentID');
        var Member_Count = 0;
        
        $.ajax({  
            type: 'GET',
            url: './proc/getvalue.php', 
            data: { 
                idvalue:AgentID,
                idname:'AgentID',
                table:'members_account',
                field:'count(AgentID)'
            },
            success: function(response) {
                alert('ret: ' + response);
                var strarray=response.split('|');
                Member_Count=strarray[0];

                if (Member_Count > 0) {
                    alert("Unable to delete this agent. You have an exisitng record associated with this him/her");
                    return;
                }else{
                    if (confirm("You are about to remove this agent. Do you want to continue?")){
                             $.ajax({  
                                type: 'GET',
                                url: './proc/deagent_proc.php', 
                                data: { 
                                    save_mode:'delete',
                                    agent_id:AgentID                    },
                                success: function(response) {
                                     if (response.indexOf("**success**") > -1){
                                        $("#clientlist #row"+AgentID).remove();                           
                                     }else if (response.indexOf("**failed**") > -1){
                                        alert("Delete failed!");
                                       
                                     }
                                }
                            });  
                    }

                }


            }
        });

    });
    

    
    //SAVE PLAN
    $(document).on("click","#btnsharesave",function (e) {
        e.preventDefault();    


        var branch=$('#branch_office').val();
        var agent_id=$('#agent_id').val();

        var agent_fname=$('#agent_fname').val();
        var agent_mname=$('#agent_mname').val();
        var agent_lname=$('#agent_lname').val();
        var agent_type=$('#agent_type').val();

        var agent_sex=$('#agent_sex').val();
        var agent_mstatus=$('#agent_mstatus').val();
        var agent_dob=$('#agent_dob').val();
        var agent_contact=$('#agent_contact').val();

        var agent_province=$('#agent_province').val();
        var agent_city=$('#agent_city').val();
        var agent_barangay=$('#agent_barangay').val();
        var agent_street=$('#agent_street').val();

        var agent_referrer = $('#agent_referrer').val();


        var agent_initials=agent_fname.substring(1)+agent_mname.substring(1)+agent_lname.substring(1);
        var agent_age=0;
        var mode = '';



        if (agent_fname == ''){
            $('#agent_fname').closest("div").addClass("has-error");
            alert("First name is required");
            return;
        }else{
            $('#agent_fname').closest("div").removeClass("has-error");            
        }
/*
        if (agent_mname == ''){
            $('#agent_mname').closest("div").addClass("has-error");
            alert("Middle name is required");
            return;
        }else{
            $('#agent_mname').closest("div").removeClass("has-error");            
        }
*/
        if (agent_lname == ''){
            $('#agent_lname').closest("div").addClass("has-error");
            alert("Last name is required");
            return;
        }else{
            $('#agent_lname').closest("div").removeClass("has-error");            
        }

         if (branch == -1){
            $('#branch_office').closest("div").addClass("has-error");
            alert("Branch Office is required");
            return;
        }else{
            $('#branch_office').closest("div").removeClass("has-error");            
        }


/*
        if (agent_province == ''){
            $('#agent_province').closest("div").addClass("has-error");
            alert("Province is required");
            return;
        }else{
            $('#agent_province').closest("div").removeClass("has-error");                        
        }


        if (agent_city == ''){
            $('#agent_province').closest("div").addClass("has-error");
            alert("City/Municipality is required");
            return;
        }else{
            $('#agent_province').closest("div").removeClass("has-error");                                    
        }
*/


        if (agent_id==""){
            mode='insert';
        }else{
            mode='update';
        }


         $.ajax({  
            type: 'GET',
            url: './proc/deagent_proc.php', 
            data: { 
                save_mode:mode,
                agent_id:agent_id,
                agent_fname:agent_fname,
                agent_mname:agent_mname,
                agent_lname:agent_lname,
                agent_type:agent_type,

                branch:branch,
                
                agent_sex:agent_sex,
                agent_mstatus:agent_mstatus,
                agent_dob:agent_dob,
                agent_contact:agent_contact,

                agent_province:agent_province,
                agent_city:agent_city,
                agent_barangay:agent_barangay,
                agent_street:agent_street,

                agent_initials:agent_initials,
                agent_age:agent_age,

                agent_referrer:agent_referrer
                
            },
            success: function(response) {
         
                 //alert(response);
                 if (response.indexOf("**success**") > -1){

                    //0:**success**
                    //1:html row
                    var strarray=response.split('|');
                    var row = strarray[1];
                    if (mode=='update') {
                        $("#clientlist #row"+agent_id).replaceWith( row );
                        alert("Update Successful!");

                    } else if (mode=='insert') {
                        $( "#clientlist" ).append( row );
                        //row.insertBefore("#dataTables-clientlist tr:first");

                        //$("#dataTables-sample tr:first").before(row);
                        //$("#dataTables-example tr:first").after(row);
                        //row.before("#dataTables-example tr:first");
                        

                       // $("#clientlist tr:first").insertBefore(row);
                        //alert($("#clientlist tr:first").html());
                        alert("New agent added successfully.");
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
        var agent_id =$(this).attr('agent_id');
        var agent_fname =$(this).attr('agent_fname');
        var agent_lname =$(this).attr('agent_lname');
        var agent_mname =$(this).attr('agent_mname');
        var agent_type =$(this).attr('agent_type');
        var agent_sex =$(this).attr('agent_sex');
        var agent_mstatus =$(this).attr('agent_mstatus');
        var agent_dob =$(this).attr('agent_dob');
        var agent_contact =$(this).attr('agent_contact');
        var agent_province =$(this).attr('agent_province');
        var agent_city     =$(this).attr('agent_city');
        var agent_barangay    =$(this).attr('agent_barangay');
        var agent_street    =$(this).attr('agent_street');
        var agent_initials    =$(this).attr('agent_initials');
        var agent_age  =$(this).attr('agent_age');
        var referrer = $(this).attr('referrer');
        var Branch_ID=$(this).attr('Branch_ID');

        if (agent_type==""){   //NON-FFSO=EMPTY
            $('#recuiter_container').removeClass('hidden');
        }else{
            $('#recuiter_container').addClass('hidden');            
        }

        $('#agent_id').val(agent_id);
        $('#agent_fname').val(agent_fname);
        $('#agent_mname').val(agent_mname);
        $('#agent_lname').val(agent_lname);
        $('#agent_type').val(agent_type);
        $('#agent_sex').val(agent_sex);
        $('#agent_mstatus').val(agent_mstatus);
        $('#agent_dob').val(agent_dob);
        $('#agent_contact').val(agent_contact);
        $('#agent_province').val(agent_province);
        $('#agent_city').val(agent_city);
        $('#agent_barangay').val(agent_barangay);
        $('#agent_street').val(agent_street);
        $('#agent_initials').val(agent_initials);
        $('#agent_age').val(agent_age);
        $('#agent_referrer').val(referrer);
        $('#branch_office').val(Branch_ID);

        

    });

$('.datepicker').datepicker({
    format: 'mm/dd/yyyy'
});   
    

</script>