


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">ACCESS ROLES MANAGER</h1>
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
                class="btn btn-success" 
                id=btnNewRole 
                data-backdrop="static" data-keyboard="false"
                data-toggle="modal" data-target="#myModal">ADD ROLE</a>
                </div>
                <br><br>

                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>

                            <th width="5%">ID</th>
                            <th width="30%">ROLE</th>
                            <th>DESCRIPTION</th>
                            <th width="10%">OPTIONS</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist class="clientlist">
                    <div id=dummyrow></div>
                        <?php 
                            $res_users = mysqli_query($con, "
                        SELECT
                            `roles`.`role_id` AS 'ROLE_ID'
                            , `roles`.`role` AS 'ROLE'
                            , `roles`.`desciption` AS 'DESCRIPTION'
                            , `roles`.`MP_MEMBER_ENCODING`
                            , `roles`.`MP_MEMBER_DELETION`
                            , `roles`.`MP_PAYMENT`
                            , `roles`.`MP_MCPR_UPLOAD`
                            , `roles`.`MP_ENCODING_SUMMARY`
                            , `roles`.`MP_APPROVAL_OF_REQUESTS`
                            , `roles`.`MP_DECEASED_UPDATING`
                            , `roles`.`REP_AUDIT_TRAILS`
                            , `roles`.`REP_MCPR_REPORTS`
                            , `roles`.`REP_MCPR_GENERATE`
                            , `roles`.`REP_MCPR_DOWNLOAD`
                            , `roles`.`REP_MCPR_OFFLINE_DOWNLOAD`
                            , `roles`.`REP_MCPR_DELETE`
                            , `roles`.`REP_PERIODIC_INCENTIVES_REPORTS`
                            , `roles`.`REP_MANILA_REPORTS`
                            , `roles`.`REP_BRANCH_REPORTS`
                            , `roles`.`REP_STATEMENT_OF_OPERATION`
                            , `roles`.`FM_AGENT_MANAGEMENT`
                            , `roles`.`FM_BRANCH_MANAGEMENT`
                            , `roles`.`FM_PLANS`
                            , `roles`.`FM_POLICY_FORMS`
                            , `roles`.`MEMORIAL_SERVICES`
                            , `roles`.`ACCT_INCENTIVES_COMPUTATION`
                            , `roles`.`ACCT_OR_VERIFICATION`
                            , `roles`.`ACCT_COLLECTION_SUMMARY`
                            , `roles`.`SUPPORT_TICKETS_OPEN`
                            , `roles`.`SUPPORT_TICKETS_CLOSED`
                            , `roles`.`SUPPORT_USER_GUIDE`
                            , `roles`.`SETTINGS_USER_ACCOUNTS`
                            , `roles`.`SETTINGS_ACCESS_ROLES`
                            , `roles`.`SETTINGS_BACKUP_RESTOR`
                            , `roles`.`DEV_DEBUG`
                            , IFNULL(SUM(`users`.`user_id`),0) AS `USER_COUNT`
                         FROM
                            `dmcpi1_dmcsm`.`users`
                            right JOIN `dmcpi1_dmcsm`.`roles` 
                                ON (`users`.`role_id` = `roles`.`role_id`)
                        GROUP BY `roles`.`role_id`, `roles`.`role`, `roles`.`desciption`, `roles`.`MP_MEMBER_ENCODING`, `roles`.`MP_MEMBER_DELETION`, `roles`.`MP_PAYMENT`, `roles`.`MP_MCPR_UPLOAD`, `roles`.`MP_ENCODING_SUMMARY`, `roles`.`MP_APPROVAL_OF_REQUESTS`, `roles`.`MP_DECEASED_UPDATING`, `roles`.`REP_AUDIT_TRAILS`, `roles`.`REP_MCPR_REPORTS`, `roles`.`REP_MCPR_GENERATE`, `roles`.`REP_MCPR_DOWNLOAD`, `roles`.`REP_MCPR_OFFLINE_DOWNLOAD`, `roles`.`REP_MCPR_DELETE`, `roles`.`REP_PERIODIC_INCENTIVES_REPORTS`, `roles`.`REP_MANILA_REPORTS`, `roles`.`REP_BRANCH_REPORTS`, `roles`.`REP_STATEMENT_OF_OPERATION`, `roles`.`FM_AGENT_MANAGEMENT`, `roles`.`FM_BRANCH_MANAGEMENT`, `roles`.`FM_PLANS`, `roles`.`FM_POLICY_FORMS`, `roles`.`MEMORIAL_SERVICES`, `roles`.`ACCT_INCENTIVES_COMPUTATION`, `roles`.`ACCT_OR_VERIFICATION`, `roles`.`ACCT_COLLECTION_SUMMARY`, `roles`.`SUPPORT_TICKETS_OPEN`, `roles`.`SUPPORT_TICKETS_CLOSED`, `roles`.`SUPPORT_USER_GUIDE`, `roles`.`SETTINGS_USER_ACCOUNTS`, `roles`.`SETTINGS_ACCESS_ROLES`, `roles`.`SETTINGS_BACKUP_RESTOR`, `roles`.`DEV_DEBUG`
                        HAVING `roles`.`role_id` > 0;

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_users,MYSQLI_ASSOC)) {
                                
                                $ROLE_ID = $r['ROLE_ID']; 
                                $ROLE = $r['ROLE']; 
                                $DESCRIPTION = $r['DESCRIPTION']; 

                                $MP_MEMBER_ENCODING=$r['MP_MEMBER_ENCODING'];
                                $MP_MEMBER_DELETION=$r['MP_MEMBER_DELETION'];
                                $MP_PAYMENT=$r['MP_PAYMENT'];
                                $MP_MCPR_UPLOAD=$r['MP_MCPR_UPLOAD'];
                                $MP_ENCODING_SUMMARY=$r['MP_ENCODING_SUMMARY'];
                                $MP_APPROVAL_OF_REQUESTS=$r['MP_APPROVAL_OF_REQUESTS'];
                                $MP_DECEASED_UPDATING=$r['MP_DECEASED_UPDATING'];
                                $REP_AUDIT_TRAILS=$r['REP_AUDIT_TRAILS'];
                                $REP_MCPR_REPORTS=$r['REP_MCPR_REPORTS'];
                                $REP_MCPR_GENERATE=$r['REP_MCPR_GENERATE'];
                                $REP_MCPR_DOWNLOAD=$r['REP_MCPR_DOWNLOAD'];
                                $REP_MCPR_OFFLINE_DOWNLOAD=$r['REP_MCPR_OFFLINE_DOWNLOAD'];
                                $REP_MCPR_DELETE=$r['REP_MCPR_DELETE'];
                                $REP_PERIODIC_INCENTIVES_REPORTS=$r['REP_PERIODIC_INCENTIVES_REPORTS'];
                                $REP_MANILA_REPORTS=$r['REP_MANILA_REPORTS'];
                                $REP_BRANCH_REPORTS=$r['REP_BRANCH_REPORTS'];
                                $REP_STATEMENT_OF_OPERATION=$r['REP_STATEMENT_OF_OPERATION'];
                                $FM_AGENT_MANAGEMENT=$r['FM_AGENT_MANAGEMENT'];
                                $FM_BRANCH_MANAGEMENT=$r['FM_BRANCH_MANAGEMENT'];
                                $FM_PLANS=$r['FM_PLANS'];
                                $FM_POLICY_FORMS=$r['FM_POLICY_FORMS'];
                                $MEMORIAL_SERVICES=$r['MEMORIAL_SERVICES'];
                                $ACCT_INCENTIVES_COMPUTATION=$r['ACCT_INCENTIVES_COMPUTATION'];
                                $ACCT_OR_VERIFICATION=$r['ACCT_OR_VERIFICATION'];
                                $ACCT_COLLECTION_SUMMARY=$r['ACCT_COLLECTION_SUMMARY'];
                                $SUPPORT_TICKETS_OPEN=$r['SUPPORT_TICKETS_OPEN'];
                                $SUPPORT_TICKETS_CLOSED=$r['SUPPORT_TICKETS_CLOSED'];
                                $SUPPORT_USER_GUIDE=$r['SUPPORT_USER_GUIDE'];
                                $SETTINGS_USER_ACCOUNTS=$r['SETTINGS_USER_ACCOUNTS'];
                                $SETTINGS_ACCESS_ROLES=$r['SETTINGS_ACCESS_ROLES'];
                                $SETTINGS_BACKUP_RESTOR=$r['SETTINGS_BACKUP_RESTOR'];
                                $DEV_DEBUG=$r['DEV_DEBUG'];

                                $USER_COUNT = $r['USER_COUNT'];  



                                echo "
                                    <tr id=row$ROLE_ID>
                                        <td class=\"even gradeC\"> $ROLE_ID</td>
                                        <td>$ROLE</td>
                                        <td>$DESCRIPTION</td>
                                        <td>

                                            <a href=\"#\" class=\"btn btn-xs btn-success btn-circle\" id=btnuseredit data-toggle=\"modal\" data-target=\"#myModal\"

                                                data-backdrop=\"static\" data-keyboard=\"false\"

                                                ROLE_ID     =\"$ROLE_ID\"
                                                ROLE    =\"$ROLE\"
                                                DESCRIPTION    =\"$DESCRIPTION\"

                                                MP_MEMBER_ENCODING=\"$MP_MEMBER_ENCODING\"
                                                MP_MEMBER_DELETION=\"$MP_MEMBER_DELETION\"
                                                MP_PAYMENT=\"$MP_PAYMENT\"
                                                MP_MCPR_UPLOAD=\"$MP_MCPR_UPLOAD\"
                                                MP_ENCODING_SUMMARY=\"$MP_ENCODING_SUMMARY\"
                                                MP_APPROVAL_OF_REQUESTS=\"$MP_APPROVAL_OF_REQUESTS\"
                                                MP_DECEASED_UPDATING=\"$MP_DECEASED_UPDATING\"
                                                REP_AUDIT_TRAILS=\"$REP_AUDIT_TRAILS\"
                                                REP_MCPR_REPORTS=\"$REP_MCPR_REPORTS\"
                                                REP_MCPR_GENERATE=\"$REP_MCPR_GENERATE\"
                                                REP_MCPR_DOWNLOAD=\"$REP_MCPR_DOWNLOAD\"
                                                REP_MCPR_OFFLINE_DOWNLOAD=\"$REP_MCPR_OFFLINE_DOWNLOAD\"
                                                REP_MCPR_DELETE=\"$REP_MCPR_DELETE\"
                                                REP_PERIODIC_INCENTIVES_REPORTS=\"$REP_PERIODIC_INCENTIVES_REPORTS\"
                                                REP_MANILA_REPORTS=\"$REP_MANILA_REPORTS\"
                                                REP_BRANCH_REPORTS=\"$REP_BRANCH_REPORTS\"
                                                REP_STATEMENT_OF_OPERATION=\"$REP_STATEMENT_OF_OPERATION\"
                                                FM_AGENT_MANAGEMENT=\"$FM_AGENT_MANAGEMENT\"
                                                FM_BRANCH_MANAGEMENT=\"$FM_BRANCH_MANAGEMENT\"
                                                FM_PLANS=\"$FM_PLANS\"
                                                FM_POLICY_FORMS=\"$FM_POLICY_FORMS\"
                                                MEMORIAL_SERVICES=\"$MEMORIAL_SERVICES\"
                                                ACCT_INCENTIVES_COMPUTATION=\"$ACCT_INCENTIVES_COMPUTATION\"
                                                ACCT_OR_VERIFICATION=\"$ACCT_OR_VERIFICATION\"
                                                ACCT_COLLECTION_SUMMARY=\"$ACCT_COLLECTION_SUMMARY\"
                                                SUPPORT_TICKETS_OPEN=\"$SUPPORT_TICKETS_OPEN\"
                                                SUPPORT_TICKETS_CLOSED=\"$SUPPORT_TICKETS_CLOSED\"
                                                SUPPORT_USER_GUIDE=\"$SUPPORT_USER_GUIDE\"
                                                SETTINGS_USER_ACCOUNTS=\"$SETTINGS_USER_ACCOUNTS\"
                                                SETTINGS_ACCESS_ROLES=\"$SETTINGS_ACCESS_ROLES\"
                                                SETTINGS_BACKUP_RESTOR=\"$SETTINGS_BACKUP_RESTOR\"




                                            >
                                            <i class=\"glyphicon glyphicon-edit\"></i></a>

                                            <a  
                                            ROLE_ID=$ROLE_ID

                                            USER_COUNT=$USER_COUNT
                                            id=btnroledelete 
                                            class=\"btn btn-xs btn-danger btn-circle \"><i class=\"glyphicon glyphicon-trash\"></i></a>

                                        </td>
                                </tr>

                                ";


                            }
                            mysqli_free_result($res_users);
                            
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
    
    
    $(document).on("click","#btnNewRole",function (e) {
        e.preventDefault();

        $('#ROLE_ID').val('');
        $('#ROLE').val('');
        $('#DESCRIPTION').val('');

        $('#MP_MEMBER_ENCODING').attr('checked', false);
        $('#MP_MEMBER_DELETION').attr('checked', false);
        $('#MP_PAYMENT').attr('checked', false);
        $('#MP_MCPR_UPLOAD').attr('checked', false);
        $('#MP_ENCODING_SUMMARY').attr('checked', false);
        $('#MP_APPROVAL_OF_REQUESTS').attr('checked', false);
        $('#MP_DECEASED_UPDATING').attr('checked', false);
        $('#REP_AUDIT_TRAILS').attr('checked', false);
        $('#REP_MCPR_REPORTS').attr('checked', false);
        $('#REP_MCPR_GENERATE').attr('checked', false);
        $('#REP_MCPR_DOWNLOAD').attr('checked', false);
        $('#REP_MCPR_OFFLINE_DOWNLOAD').attr('checked', false);
        $('#REP_MCPR_DELETE').attr('checked', false);
        $('#REP_PERIODIC_INCENTIVES_REPORTS').attr('checked', false);
        $('#REP_MANILA_REPORTS').attr('checked', false);
        $('#REP_BRANCH_REPORTS').attr('checked', false);
        $('#REP_STATEMENT_OF_OPERATION').attr('checked', false);
        $('#FM_AGENT_MANAGEMENT').attr('checked', false);
        $('#FM_BRANCH_MANAGEMENT').attr('checked', false);
        $('#FM_PLANS').attr('checked', false);
        $('#FM_POLICY_FORMS').attr('checked', false);
        $('#MEMORIAL_SERVICES').attr('checked', false);
        $('#ACCT_INCENTIVES_COMPUTATION').attr('checked', false);
        $('#ACCT_OR_VERIFICATION').attr('checked', false);
        $('#ACCT_COLLECTION_SUMMARY').attr('checked', true);
        $('#SUPPORT_TICKETS_OPEN').attr('checked', true);
        $('#SUPPORT_TICKETS_CLOSED').attr('checked', true);
        $('#SUPPORT_USER_GUIDE').attr('checked', true);
        $('#SETTINGS_USER_ACCOUNTS').attr('checked', false);
        $('#SETTINGS_ACCESS_ROLES').attr('checked', false);
        $('#SETTINGS_BACKUP_RESTOR').attr('checked', false);

    });

    $(document).on("click","#btnroledelete",function (e) {
        e.preventDefault();   

        if ($(this).attr('USER_COUNT')>0) {

            alert("Unable to delete this role. There are users associated with this role!");
            return;
        }

        if (confirm("You are about to remove this role. Do you want to continue?")){
            var ROLE_ID =$(this).attr('ROLE_ID');

            
                 $.ajax({  
                    type: 'GET',
                    url: './proc/rolelist_proc.php', 
                    data: { 
                        save_mode:'delete',
                        ROLE_ID:ROLE_ID
                    },
                    success: function(response) {
                         //prompt(response,response);
                         if (response.indexOf("**success**") > -1){
                            alert('Delete successful!')
                            $("#clientlist #row"+ROLE_ID).remove();                           
                         }else if (response.indexOf("**failed**") > -1){
                            alert("Delete failed!");
                           
                         }
                    }
                });  
        }
    });
    
    //when modal closed
    $(document).on('click','#btndismissmodal',function(e){
        e.preventDefault();
        window.location = "index.php?page=accessroles";
    });


    
    //SAVE PLAN
    $(document).on("click","#btnusersave",function (e) {
        e.preventDefault();    

        var ROLE_ID=$('#ROLE_ID').val();
        var ROLE=$('#ROLE').val(); 
        var DESCRIPTION=$('#DESCRIPTION').val();
        var mode = '';

        if (ROLE == ''){
            $('#role').closest("div").addClass("has-error");
            alert("Role Name is required");
            return;
        }else{
            $('#role').closest("div").removeClass("has-error");            
        }


        var chkArray = [];
        
        $(".chk:checked").each(function() {
          chkArray.push($(this).attr("id"));
        });
        
        var selected;
        selected = chkArray.join(',') ;
        
        /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
        if(selected.length > 0){
          //alert("You have selected " + selected); 
        }else{
          alert("You haven't select any permission"); 
          return;
        }

        if (ROLE_ID==""){
            mode='insert';
        }else{
            mode='update';
        }

         $.ajax({  
            type: 'GET',
            url: './proc/rolelist_proc.php', 
            data: { 
                save_mode:mode,
                ROLE_ID:ROLE_ID,
                ROLE:ROLE,
                DESCRIPTION:DESCRIPTION,
                selected:selected             
            },
            success: function(response) {
                 //   console.log('res: '+ response);

                 if (response.indexOf("**success**") > -1){
                    var strarray=response.split('|');
                    var row = strarray[1];
                    if (mode=='update') {
                        $("#clientlist #row"+ROLE_ID).replaceWith( row );
                        alert("Update Successful!");
                        window.location = "index.php?page=accessroles";
                    } else if (mode=='insert') {
                        //$("#clientlist tr:first").insertBefore(row);
                        //$('#clientlist').append(row);
                        alert("New role added successfully.");
                        window.location = "index.php?page=accessroles";
                    }           

                 }else if (response.indexOf("Notice") > -1){
                    alert("Save failed: An error has occured while saving data. Please contact your system developer. ");
                 }else if (response.indexOf("**noChanges**") > -1){
                        alert("Same data - no changes made");
                 }else if(response.indexOf("**exists**") > -1) {
                        alert("Role name already exists!");
                 }
            }
        });       

    });

    //LOAD PLAN TO EDITOR
    $(document).on("click","#btnuseredit",function (e) {
        e.preventDefault();

        var ROLE_ID =$(this).attr('ROLE_ID');
        var ROLE =$(this).attr('ROLE');


        console.log(!!parseInt($(this).attr('MP_MEMBER_ENCODING')));

        $('#ROLE_ID').val(ROLE_ID);
        $('#ROLE').val(ROLE);
        $('#DESCRIPTION').val($(this).attr('DESCRIPTION'));


/*
        $('#MP_MEMBER_ENCODING').removeAttr('checked');
        $('#MP_MEMBER_DELETION').removeAttr('checked');
        $('#MP_PAYMENT').removeAttr('checked');
        $('#MP_MCPR_UPLOAD').removeAttr('checked');
        $('#MP_ENCODING_SUMMARY').removeAttr('checked');
        $('#MP_APPROVAL_OF_REQUESTS').removeAttr('checked');
        $('#MP_DECEASED_UPDATING').removeAttr('checked');
        $('#REP_AUDIT_TRAILS').removeAttr('checked');
        $('#REP_MCPR_REPORTS').removeAttr('checked');
        $('#REP_MCPR_GENERATE').removeAttr('checked');
        $('#REP_MCPR_DOWNLOAD').removeAttr('checked');
        $('#REP_MCPR_OFFLINE_DOWNLOAD').removeAttr('checked');
        $('#REP_MCPR_DELETE').removeAttr('checked');
        $('#REP_PERIODIC_INCENTIVES_REPORTS').removeAttr('checked');
        $('#REP_MANILA_REPORTS').removeAttr('checked');
        $('#REP_BRANCH_REPORTS').removeAttr('checked');
        $('#REP_STATEMENT_OF_OPERATION').removeAttr('checked');
        $('#FM_AGENT_MANAGEMENT').removeAttr('checked');
        $('#FM_BRANCH_MANAGEMENT').removeAttr('checked');
        $('#FM_PLANS').removeAttr('checked');
        $('#FM_POLICY_FORMS').removeAttr('checked');
        $('#MEMORIAL_SERVICES').removeAttr('checked');
        $('#ACCT_INCENTIVES_COMPUTATION').removeAttr('checked');
        $('#ACCT_OR_VERIFICATION').removeAttr('checked');
        $('#ACCT_COLLECTION_SUMMARY').removeAttr('checked');
        $('#SUPPORT_TICKETS_OPEN').removeAttr('checked');
        $('#SUPPORT_TICKETS_CLOSED').removeAttr('checked');
        $('#SUPPORT_USER_GUIDE').removeAttr('checked');
        $('#SETTINGS_USER_ACCOUNTS').removeAttr('checked');
        $('#SETTINGS_ACCESS_ROLES').removeAttr('checked');
        $('#SETTINGS_BACKUP_RESTOR').removeAttr('checked');

*/


        $('#MP_MEMBER_ENCODING').attr('checked', !!parseInt($(this).attr('MP_MEMBER_ENCODING')));
        $('#MP_MEMBER_DELETION').attr('checked', !!parseInt($(this).attr('MP_MEMBER_DELETION')));
        $('#MP_PAYMENT').attr('checked', !!parseInt($(this).attr('MP_PAYMENT')));
        $('#MP_MCPR_UPLOAD').attr('checked', !!parseInt($(this).attr('MP_MCPR_UPLOAD')));
        $('#MP_ENCODING_SUMMARY').attr('checked', !!parseInt($(this).attr('MP_ENCODING_SUMMARY')));
        $('#MP_APPROVAL_OF_REQUESTS').attr('checked', !!parseInt($(this).attr('MP_APPROVAL_OF_REQUESTS')));
        $('#MP_DECEASED_UPDATING').attr('checked', !!parseInt($(this).attr('MP_DECEASED_UPDATING')));
        $('#REP_AUDIT_TRAILS').attr('checked', !!parseInt($(this).attr('REP_AUDIT_TRAILS')));
        $('#REP_MCPR_REPORTS').attr('checked', !!parseInt($(this).attr('REP_MCPR_REPORTS')));
        $('#REP_MCPR_GENERATE').attr('checked', !!parseInt($(this).attr('REP_MCPR_GENERATE')));
        $('#REP_MCPR_DOWNLOAD').attr('checked', !!parseInt($(this).attr('REP_MCPR_DOWNLOAD')));
        $('#REP_MCPR_OFFLINE_DOWNLOAD').attr('checked', !!parseInt($(this).attr('REP_MCPR_OFFLINE_DOWNLOAD')));
        $('#REP_MCPR_DELETE').attr('checked', !!parseInt($(this).attr('REP_MCPR_DELETE')));
        $('#REP_PERIODIC_INCENTIVES_REPORTS').attr('checked', !!parseInt($(this).attr('REP_PERIODIC_INCENTIVES_REPORTS')));
        $('#REP_MANILA_REPORTS').attr('checked', !!parseInt($(this).attr('REP_MANILA_REPORTS')));
        $('#REP_BRANCH_REPORTS').attr('checked', !!parseInt($(this).attr('REP_BRANCH_REPORTS')));
        $('#REP_STATEMENT_OF_OPERATION').attr('checked', !!parseInt($(this).attr('REP_STATEMENT_OF_OPERATION')));
        $('#FM_AGENT_MANAGEMENT').attr('checked', !!parseInt($(this).attr('FM_AGENT_MANAGEMENT')));
        $('#FM_BRANCH_MANAGEMENT').attr('checked', !!parseInt($(this).attr('FM_BRANCH_MANAGEMENT')));
        $('#FM_PLANS').attr('checked', !!parseInt($(this).attr('FM_PLANS')));
        $('#FM_POLICY_FORMS').attr('checked', !!parseInt($(this).attr('FM_POLICY_FORMS')));
        $('#MEMORIAL_SERVICES').attr('checked', !!parseInt($(this).attr('MEMORIAL_SERVICES')));
        $('#ACCT_INCENTIVES_COMPUTATION').attr('checked', !!parseInt($(this).attr('ACCT_INCENTIVES_COMPUTATION')));
        $('#ACCT_OR_VERIFICATION').attr('checked', !!parseInt($(this).attr('ACCT_OR_VERIFICATION')));
        $('#ACCT_COLLECTION_SUMMARY').attr('checked', !!parseInt($(this).attr('ACCT_COLLECTION_SUMMARY')));
        $('#SUPPORT_TICKETS_OPEN').attr('checked', !!parseInt($(this).attr('SUPPORT_TICKETS_OPEN')));
        $('#SUPPORT_TICKETS_CLOSED').attr('checked', !!parseInt($(this).attr('SUPPORT_TICKETS_CLOSED')));
        $('#SUPPORT_USER_GUIDE').attr('checked', !!parseInt($(this).attr('SUPPORT_USER_GUIDE')));
        $('#SETTINGS_USER_ACCOUNTS').attr('checked', !!parseInt($(this).attr('SETTINGS_USER_ACCOUNTS')));
        $('#SETTINGS_ACCESS_ROLES').attr('checked', !!parseInt($(this).attr('SETTINGS_ACCESS_ROLES')));
        $('#SETTINGS_BACKUP_RESTOR').attr('checked', !!parseInt($(this).attr('SETTINGS_BACKUP_RESTOR')));
        
    });

</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id=btndismissmodal><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">User Information</h4>
      </div>
      <div class="modal-body">

            <form class="form-horizontal">
            <fieldset>

            <input type="hidden" id="ROLE_ID"/>
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-2 control-label" for="ROLE">Role</label>  
              <div class="col-md-8">
              <input id="ROLE" name="ROLE" type="text" placeholder="" class="form-control input-md" required="">
              <span class="help-block">Name of the role</span>  
              </div>
            </div>


            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-2 control-label" for="role">Desciption</label>  
              <div class="col-md-8">
              <textarea class="form-control" rows="3" id="DESCRIPTION" name="DESCRIPTION"></textarea>
              <span class="help-block"></span>  
              </div>
            </div>
            <hr>
            <!-- Multiple Checkboxes -->
            <div class="form-group">
              <label class="col-md-2 control-label" for="checkboxes">Access Roles</label>
              <div class="col-md-10">
              <div class="checkbox">
                <label for="MP_MEMBER_ENCODING">
                  <input type="checkbox" class="chk" name="MP_MEMBER_ENCODING" id="MP_MEMBER_ENCODING">
                  Registration of Members
                </label>
              </div>
              <div class="checkbox">
                <label for="MP_MEMBER_DELETION">
                  <input type="checkbox" class="chk" name="MP_MEMBER_DELETION" id="MP_MEMBER_DELETION">
                  Delete Members Information
                </label>
              </div>
              <div class="checkbox">
                <label for="MP_PAYMENT">
                  <input type="checkbox" class="chk" name="MP_PAYMENT" id="MP_PAYMENT">
                  Encoding of Payments
                </label>
              </div>
              <div class="checkbox">
                <label for="MP_MCPR_UPLOAD">
                  <input type="checkbox" class="chk" name="MP_MCPR_UPLOAD" id="MP_MCPR_UPLOAD">
                  Uploading of MCPR Data (Offline encoding)
                </label>
              </div>
              <div class="checkbox">
                <label for="MP_ENCODING_SUMMARY">
                  <input type="checkbox" class="chk" name="MP_ENCODING_SUMMARY" id="MP_ENCODING_SUMMARY">
                  Encoding Progress
                </label>
              </div>

              <div class="checkbox">
                <label for="MP_APPROVAL_OF_REQUESTS">
                  <input type="checkbox" class="chk" name="MP_APPROVAL_OF_REQUESTS" id="MP_APPROVAL_OF_REQUESTS">
                  Approval of Requests
                </label>
              </div>

              <div class="checkbox">
                <label for="MP_DECEASED_UPDATING">
                  <input type="checkbox" class="chk" name="MP_DECEASED_UPDATING" id="MP_DECEASED_UPDATING">
                  Updating of Deceased Member
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_AUDIT_TRAILS">
                  <input type="checkbox" class="chk" name="REP_AUDIT_TRAILS" id="REP_AUDIT_TRAILS">
                  Access Audit Trails
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_MCPR_REPORTS">
                  <input type="checkbox" class="chk" name="REP_MCPR_REPORTS" id="REP_MCPR_REPORTS">
                  Access MCPR Reports 
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_MCPR_GENERATE">
                  <input type="checkbox" class="chk" name="REP_MCPR_GENERATE" id="REP_MCPR_GENERATE">
                  Generate MCPR Reports
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_MCPR_DOWNLOAD">
                  <input type="checkbox" class="chk" name="REP_MCPR_DOWNLOAD" id="REP_MCPR_DOWNLOAD">
                  Download MCPR Reports
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_MCPR_OFFLINE_DOWNLOAD">
                  <input type="checkbox" class="chk" name="REP_MCPR_OFFLINE_DOWNLOAD" id="REP_MCPR_OFFLINE_DOWNLOAD">
                  Download MCPR for Offline Encoding
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_MCPR_DELETE">
                  <input type="checkbox" class="chk" name="REP_MCPR_DELETE" id="REP_MCPR_DELETE">
                  Delete MCPR Report
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_PERIODIC_INCENTIVES_REPORTS">
                  <input type="checkbox" class="chk" name="REP_PERIODIC_INCENTIVES_REPORTS" id="REP_PERIODIC_INCENTIVES_REPORTS">
                  Access Periodic Incentives/Commision Reports
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_MANILA_REPORTS">
                  <input type="checkbox" class="chk" name="REP_MANILA_REPORTS" id="REP_MANILA_REPORTS">
                  Download Manila Reports
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_BRANCH_REPORTS">
                  <input type="checkbox" class="chk" name="REP_BRANCH_REPORTS" id="REP_BRANCH_REPORTS">
                  Generate and Download Branch Reports
                </label>
              </div>
              <div class="checkbox">
                <label for="REP_STATEMENT_OF_OPERATION">
                  <input type="checkbox" class="chk" name="REP_STATEMENT_OF_OPERATION" id="REP_STATEMENT_OF_OPERATION">
                  Download Statement of Operations Report
                </label>
              </div>


              <div class="checkbox">
                <label for="FM_AGENT_MANAGEMENT">
                  <input type="checkbox" class="chk" name="FM_AGENT_MANAGEMENT" id="FM_AGENT_MANAGEMENT">
                  Agent Profile Management
                </label>
              </div>
              <div class="checkbox">
                <label for="FM_BRANCH_MANAGEMENT">
                  <input type="checkbox" class="chk" name="FM_BRANCH_MANAGEMENT" id="FM_BRANCH_MANAGEMENT">
                  Branch Profile Management
                </label>
              </div>
              <div class="checkbox">
                <label for="FM_PLANS">
                  <input type="checkbox" class="chk" name="FM_PLANS" id="FM_PLANS">
                  Plans and Packages Management
                </label>
              </div>
              <div class="checkbox">
                <label for="FM_POLICY_FORMS">
                  <input type="checkbox" class="chk" name="FM_POLICY_FORMS" id="FM_POLICY_FORMS">
                  Manage Policy Forms
                </label>
              </div>


              <div class="checkbox">
                <label for="MEMORIAL_SERVICES">
                  <input type="checkbox" class="chk" name="MEMORIAL_SERVICES" id="MEMORIAL_SERVICES">
                  Access Memorial Module
                </label>
              </div>


              <div class="checkbox">
                <label for="ACCT_INCENTIVES_COMPUTATION">
                  <input type="checkbox" class="chk" name="ACCT_INCENTIVES_COMPUTATION" id="ACCT_INCENTIVES_COMPUTATION">
                  Compute Incentives and Commissions
                </label>
              </div>
              <div class="checkbox">
                <label for="ACCT_OR_VERIFICATION">
                  <input type="checkbox" class="chk" name="ACCT_OR_VERIFICATION" id="ACCT_OR_VERIFICATION">
                  Verification and Approval of OR/PR
                </label>
              </div>
              <div class="checkbox">
                <label for="ACCT_COLLECTION_SUMMARY">
                  <input type="checkbox" class="chk" name="ACCT_COLLECTION_SUMMARY" id="ACCT_COLLECTION_SUMMARY">
                  View Collection Summary
                </label>
              </div>


              <div class="checkbox">
                <label for="SUPPORT_TICKETS_OPEN">
                  <input type="checkbox" class="chk" name="SUPPORT_TICKETS_OPEN" id="SUPPORT_TICKETS_OPEN">
                  Access Support (Open Tickets)
                </label>
              </div>
              <div class="checkbox">
                <label for="SUPPORT_TICKETS_CLOSED">
                  <input type="checkbox" class="chk" name="SUPPORT_TICKETS_CLOSED" id="SUPPORT_TICKETS_CLOSED">
                  View Resolved Issues (Closed Tickets)
                </label>
              </div>
              <div class="checkbox">
                <label for="SUPPORT_USER_GUIDE">
                  <input type="checkbox" class="chk" name="SUPPORT_USER_GUIDE" id="SUPPORT_USER_GUIDE">
                  Access User Guide
                </label>
              </div>


              <div class="checkbox">
                <label for="SETTINGS_USER_ACCOUNTS">
                  <input type="checkbox" class="chk" name="SETTINGS_USER_ACCOUNTS" id="SETTINGS_USER_ACCOUNTS">
                  Manage System user credentials
                </label>
              </div>
              <div class="checkbox">
                <label for="SETTINGS_ACCESS_ROLES">
                  <input type="checkbox" class="chk" name="SETTINGS_ACCESS_ROLES" id="SETTINGS_ACCESS_ROLES">
                  Manage user roles
                </label>
              </div>
              <div class="checkbox">
                <label for="SETTINGS_BACKUP_RESTOR">
                  <input type="checkbox" class="chk" name="SETTINGS_BACKUP_RESTOR" id="SETTINGS_BACKUP_RESTOR">
                  Access Backup and Restore
                </label>
              </div>
        </div>







            </div>


            






            </fieldset>
            </form>


      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary" id=btnusersave>Save</button>
      </div>
    </div>
  </div>
</div>