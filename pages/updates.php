



<div class="row">
    <div class="col-lg-6">
        <h1 class="page-header">Updates</h1>
    </div>
    <div class="col-lg-6">
    <BR><BR>


    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id=row_count>
                All records
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th >Code</th>
                            <th >Name</th>
                            <th >Agent</th>
                            <th >Plan type</th>
                            <th >Units</th>
                            <th >No. of Payment</th>
                            <th >Total Paid</th>
                            <th >Status</th>
                            <th >Current Term</th>
                            <th >Membership Date</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                            $res_data = mysqli_query($con, "

                              SELECT
                              `members_account`.`Member_Code`          AS `Member_Code`
                              , UPPER(CONCAT(`members_profile`.`Lname`,', ',`members_profile`.`Fname`,', ',SUBSTR(`members_profile`.`Mname`,1,1),'.')) AS `Fullname`
                              , `agent_profile`.`initials`              AS `Agent`
                              , `packages`.`Plan_Code`          AS `Plan_Code`
                              , `members_account`.`No_of_units`        AS `No_of_Units`
                              , `members_account`.`Insurance_Type`     AS `Insurance_Type`
                              , `members_account`.`Date_of_membership` AS `Date_of_Membership`
                              , COUNT(installment_ledger.ORno)         AS `No_of_payment`
                              , SUM(installment_ledger.Amt_Due)      AS `Total_paid`
                              , IF (deceased_table.ID>0,'Deceased',`members_account`.`Account_Status`)     AS `Account_Status`
                              , `members_account`.`Current_term`       AS `CURRENT_TERM`
                              , `members_profile`.`ENTRY_ID`           AS `ENTRY_ID`
                              ,  packages.Term              AS `PACKAGE_TERM`
                              ,  packages.Constability
                              ,  deceased_table.ID AS 'DECEASED_ID'
                            FROM `members_account`
                              INNER JOIN `members_profile`
                                 ON `members_account`.`Member_Code` = `members_profile`.`Member_Code`
                                  INNER JOIN  installment_ledger
                                ON members_account.Member_Code = installment_ledger.Member_Code
                                   JOIN agent_profile
                                       ON `members_account`.AgentID = agent_profile.AgentID
                                      JOIN packages
                                         ON members_account.Plan_id = packages.Plan_id
                                         LEFT JOIN deceased_table
                                             ON members_account.Member_Code = deceased_table.Member_Code
                            WHERE `members_account`.`Account_Status` IN ('Active','Overdue')
                            GROUP BY `members_account`.`Member_Code`, `Fullname`,`agent_profile`.`Initials`,`packages`.`Plan_Code`, `members_account`.`No_of_units`, `members_account`.`Insurance_Type`, `members_account`.`Date_of_membership`
                            , `members_account`.`Account_Status`, `members_account`.`Current_term`, `members_profile`.`ENTRY_ID` ,  deceased_table.ID 

                            ") or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_data,MYSQLI_ASSOC)) {
                                $Member_Code = $r['Member_Code']; 
                                $Fullname = strtoupper($r['Fullname']); 
                                $Agent = $r['Agent']; 
                                $Plan_Code = $r['Plan_Code']; 
                                $No_of_Units = $r['No_of_Units']; 
                                $No_of_payment = $r['No_of_payment'];
                                $Total_paid = number_format($r['Total_paid'],2);
                                $Account_Status = $r['Account_Status'];
                                $Current_Term = $r['CURRENT_TERM'];
                                $Date_of_Membership = $r['Date_of_Membership']; 
                                

                                $row_colorclass = "";  
                                $option_class = "";                              
                                if ($Account_Status == "Deceased"){
                                    $row_colorclass = "danger";
                                    $option_class = "hidden";
                                }

                                echo "
                                    <tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $Member_Code</td>
                                        <td>$Fullname</td>
                                        <td>$Agent</td>
                                        <td>$Plan_Code</td>
                                        <td>$No_of_Units</td>
                                        <td>$No_of_payment</td>
                                        <td>$Total_paid</td>
                                        <td>$Account_Status</td>
                                        <td>$Current_Term</td>
                                        <td>$Date_of_Membership</td>
                                        <td>

                                              <a href=\"#\" 
                                              class = \" btn btn-success\"
                                              id=btnaction_deceased 
                                              action=Deceased 
                                              Member_Code=$Member_Code 
                                              bene=\"$Fullname\"
                                              status=\"$Account_Status\"
                                              data-toggle=\"modal\" 
                                              data-target=\".modal_update_deceased\"

                                              >Mark as Deceased</a>

                                            <!--div class=\"btn-group $option_class \" role=\"group\">
                                                <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                                  Select
                                                  <span class=\"caret\"></span>
                                                </button>
                                            <ul class=\"dropdown-menu\">
                                          
                                              <li><a href=\"#\" 
                                              id=btnaction_deceased 
                                              action=Deceased 
                                              Member_Code=$Member_Code 
                                              bene=\"$Fullname\"
                                              status=\"$Account_Status\"
                                              data-toggle=\"modal\" 
                                              data-target=\".modal_update_deceased\"

                                              >Mark as Deceased</a></li>
                                             
                                            </ul>
                                          </div-->


                                        </td>
                                    </tr>

                                ";


                            }
                            mysqli_free_result($res_data);
                            
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

<!--script src="../vendor/jquery/jquery.min.js"></script-->


<div class="modal fade bs-example-modal-sm modal_update_deceased" tabindex="-1" role="dialog" aria-labelledby="modal_update_deceased">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Type: Deceased</h4>


      </div>
      <div class="modal-body">



  <div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
    <form method="post">
     <div class="form-group ">
      <label class="control-label " for="Member_Code">
       Member Code
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-gg">
        </i>
       </div>
       <input class="form-control" id="Member_Code" name="Member_Code" type="text" readonly />
       <input type="hidden" name="Member_Code_hidden" id="Member_Code_hidden"/>
      </div>
     </div>
     <div class="form-group ">
      <label class="control-label " for="member_name">
       Member Name
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-user-times">
        </i>
       </div>
       <input class="form-control" id="member_name" name="member_name" type="text" readonly/>
      </div>
     </div>
     <div class="form-group ">
      <label class="control-label requiredField" for="dod">
       Date of Death
       <span class="asteriskField">
        *
       </span>
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-calendar-times-o">
        </i>
       </div>
       <input class="form-control" id="dod" name="dod" placeholder="MM/DD/YYYY" type="date"/>
      </div>
     </div>
     <div class="form-group ">
      <label class="control-label requiredField" for="pod">
       Place of Death
       <span class="asteriskField">
        *
       </span>
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-map-pin">
        </i>
       </div>
       <input class="form-control" id="pod" name="pod" type="text"/>
      </div>
     </div>
     <div class="form-group ">
      <label class="control-label requiredField" for="reason">
       Reason of Death
       <span class="asteriskField">
        *
       </span>
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-sticky-note-o">
        </i>
       </div>
       <input class="form-control" id="reason" name="reason" type="text"/>
      </div>
     </div>
     <div class="form-group ">
      <label class="control-label " for="date_reported">
       Date Reported
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-calendar-check-o">
        </i>
       </div>
       <input class="form-control" id="date_reported" name="date_reported" placeholder="MM/DD/YYYY" type="date"/>
      </div>
     </div>
     <div class="form-group ">
      <label class="control-label " for="reported_by">
       Reported by
      </label>
      <div class="input-group">
       <div class="input-group-addon">
        <i class="fa fa-user">
        </i>
       </div>
       <input class="form-control" id="reported_by" name="reported_by" type="text"/>
      </div>
     </div>
    </form>

     <div class="form-group">
      <div>
       <button class="btn btn-primary" id="btnaction_deceased_save">
        Update
       </button>
      </div>
     </div>
   </div>
  </div>            




            </div>
   
    </div>
  </div>
</div>



<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).on("click","#btnaction_deceased",function(e){
        e.preventDefault();
        var action = $(this).attr('action');
        var Member_Code = $(this).attr('Member_Code');
        var bene = $(this).attr('bene');
        var status = $(this).attr('status');

        $('#Member_Code_hidden').val(Member_Code);
        $('#Member_Code').val(Member_Code);
        $('#member_name').val(bene);
        $('#dod').val('11/28/1984');
        $('#pod').val('');
        $('#reason').val('');
        $('#date_reported').val('');
        $('#reported_by').val('');

    });

    $(document).on("click","#btnaction_deceased_save",function(){


        var Member_Code = $('#Member_Code_hidden').val();
        var bene = $('#member_name').val();
        var dod = $('#dod').val();
        var pod = $('#pod').val();
        var reason = $('#reason').val();
        var date_reported = $('#date_reported').val();
        var reported_by = $('#reported_by').val();

        if (dod=='' || pod=='' || reason==''){
            alert('Note: All information with asterisk (*) are required.');            
            return;
        }

        if (confirm('You are about to mark this member as "Deceased" . Do you want to continue? \n\n Member Code: '+Member_Code+' \n Beneficiary: '+bene)){
           $.ajax({  
              type: 'GET',
              url: './proc/updates_proc.php', 
              data: { 
                  action:'deceased',
                  Member_Code:Member_Code,
                  dod:dod,
                  pod:pod,
                  reason:reason,
                  date_reported:date_reported,
                  reported_by:reported_by,
                  user_id:"<?=$user_id?>"
              },
              success: function(response) {
                   //prompt(response,response);
                   if (response.indexOf("**success**") > -1){
                       window.location = "index.php?page=updates";               
                   }else if (response.indexOf("**failed**") > -1){
                      alert("Update failed!");
                     
                   }
                   
              }
          }); 

        }



    });



</script>

