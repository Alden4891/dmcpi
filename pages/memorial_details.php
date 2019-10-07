<?php
  $member_code = isset($_REQUEST['member_code'])?$_REQUEST['member_code']:"x";

  $res_deceased_info = mysqli_query($con,"
    SELECT
        `deceased_table`.`ID`
        , `deceased_table`.`Member_Code`
        , `deceased_table`.`Date_of_death`
        , `deceased_table`.`Place_of_death`
        , `deceased_table`.`Reason_of_death`
        , `deceased_table`.`Date_reported`
        , `deceased_table`.`Reported_by`
        , `deceased_table`.`date_approved`
        , `deceased_table`.`approved_by` AS approved_by_id
        , `deceased_table`.`memo_serv_duration`
        , `deceased_table`.`burrial_date`
        , `deceased_table`.`surcharge`

        , `b`.`fullname` AS `approved_by`
        , `deceased_table`.`date_recommended`
        , `a`.`fullname` AS `recommended_by`
    FROM
        `dmcpi1_dmcsm`.`deceased_table`
        INNER JOIN `dmcpi1_dmcsm`.`users` AS `a` 
            ON (`deceased_table`.`recommended_by` = `a`.`user_id`)
        LEFT JOIN `dmcpi1_dmcsm`.`users` AS `b`
            ON (`deceased_table`.`approved_by` = `b`.`user_id`)
    WHERE (`deceased_table`.`Member_Code` ='$member_code');

  ") or die("Error: Cannot retreive member's information!");


    $res_member_data = mysqli_query($con, "

SELECT DISTINCT
  `members_profile`.`Member_Code`        AS `Account Code`,
  CONCAT(`members_profile`.`Fname`,' ',`members_profile`.`Mname`,' ',`members_profile`.`Lname`) AS `Fullname`,
  `members_profile`.`Sex`                AS `Sex`,
  `members_profile`.`Status`             AS `Civil Status`,
  `members_profile`.`Address`            AS `Permanent Address`,
  `members_profile`.`Bdate`              AS `Date of Birth`,
  `members_profile`.`Age`                AS `Age (During Inception)`,
  `members_profile`.`Bplace`             AS `Bplace`,
  `members_profile`.`Occupation`         AS `Occupation`,
  `members_profile`.`Religion`           AS `Religion`,
  `members_profile`.`Bname`              AS `Name of Beneficiary`,
  `members_profile`.`Bbdate`             AS `DOB of Beneficiary`,
  `members_profile`.`Brelation`          AS `Relation to member`,
  `members_profile`.`Bstatus`            AS `Bene Civil Status `,
  `members_profile`.`Bcontactno`         AS `Bene Contact Number`,
  `packages`.`Plan_Code`                 AS `plan_code`,
  `members_account`.`No_of_units`        AS `Units`,
  CONCAT(`agent_profile`.`First_name`,' ',LEFT(`agent_profile`.`Middle_Name`,1),'. ',`agent_profile`.`Last_name`) AS `Name of Agent`,
  `members_account`.`Insurance_Type`     AS `Insurance`,
  `members_account`.`Date_of_membership` AS `Date of Inception`,
  `members_account`.`Current_term`       AS `Current Term`,
  `members_account`.`Account_Status`     AS `Account Status`,
  `agent_profile_ao`.`Initials`          AS `AO`,
  `bd`.`Branch_Name`                     AS `Branch Office`,
  `bd`.`Branch_Manager`                  AS `Name of Branch Manager`

FROM `branch_details`
JOIN `members_account`
JOIN `branch_details` `bd`
ON `members_account`.`BranchManager` = `bd`.`Branch_ID`
JOIN `agent_profile`
ON `members_account`.`AO` = `agent_profile`.`AgentID`
JOIN `agent_profile` `agent_profile_ao`
ON `members_account`.`AgentID` = `agent_profile_ao`.`AgentID`
JOIN `packages`
ON `members_account`.`Plan_id` = `packages`.`Plan_id`
JOIN `members_profile`
ON `members_account`.`Member_Code` = `members_profile`.`Member_Code`
JOIN `agentfullname`
ON `members_account`.`Member_Code` = `agentfullname`.`Member_Code`
JOIN `aofullname`
ON `members_account`.`Member_Code` = `aofullname`.`Member_Code`
JOIN `planname`
ON `members_account`.`Member_Code` = `planname`.`Member_Code`
WHERE `members_account`.Member_Code = '$member_code'

    ") or die('Error: Cannot retreive deceased information!');


$r_md=mysqli_fetch_array($res_member_data,MYSQLI_ASSOC) or die(mysqli_error());
$di_fullname = $r_md['Fullname'];
$di_address = $r_md['Permanent Address'];
$di_account_status = $r_md['Account Status'];




$r_di=mysqli_fetch_array($res_deceased_info,MYSQLI_ASSOC) or die(mysqli_error());
$deceased_id = $r_di["ID"];
$option_class = "";
$di_date_approved = $r_di['date_approved'];
$di_approved_by = $r_di['approved_by'];

$di_death_date = $r_di['Date_of_death'];
$di_place_of_death = $r_di['Place_of_death'];
$di_reason_of_death = $r_di['Reason_of_death'];
$di_date_reported = $r_di['Date_reported'];
$di_reportted_by = $r_di['Reported_by'];

$di_burrial_date = $r_di['burrial_date'];
$di_surcharge = $r_di['surcharge'];
$di_memo_serv_duration = $r_di['memo_serv_duration'];


$option_class_alttext = "";

if ($r_di['approved_by_id'] > 0){
  $option_class = "hidden";

  $option_class_alttext = "<i class=\"fa fa-thumbs-o-up \" ></i>
                          Apprved by $di_approved_by last $di_date_approved";
}




//mysqli_free_result($res_member_data);

?>

        <!-- page content -->
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>MEMORIAL SERVICE RECORD</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Members Information <small>Decease report</small></h2>
<!--                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
 -->

                    <div class="pull-right">



<?php
                    echo "

                        <a href=\"#\" 
                        class = \" btn btn-success $option_class\"
                        id=btnaction_deceased 
                        action=Deceased 
                        Member_Code=$member_code 
                        bene=\"$di_fullname\"
                        status=\"$di_account_status\"
                        data-toggle=\"modal\" 
                        data-target=\".modal_update_deceased\"
                        >UPDATE INFORMATION</a>




                        <button type=\"button\" 
                        id=btn_memorial_approval 
                        deceased_id=$deceased_id 
                        Member_Code=$member_code 
                        class=\"btn btn-primary btn-sm btn-block $option_class \">
                          <i class=\"fa fa-thumbs-o-up\"></i> 
                        APPROVE</button>
                        $option_class_alttext

                    ";

                    
?>

                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12 profile_left">


                     <h3><?=$di_fullname?></h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> Status:
                            <?php
                            //echo "[$di_account_status]";
                                $status_class = "";
                                if ($di_account_status=="Active"){
                                    $status_class="success";
                                } else if ($di_account_status=="Overdue"){
                                    $status_class="warning";
                                } else if ($di_account_status=="Inactive"){
                                    $status_class="danger";
                                }

                                echo "<span class=\"label label-$status_class\">$di_account_status</span>";
                            ?>                         

                        </li>

                      </ul>


                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">


                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content0" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">MEMBER PROFILE</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content1" role="tab" data-toggle="tab" aria-expanded="false">MEMORIAL INFORMATION</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">AMORTIZATION</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">POLICY</a>
                          </li>
                        </ul>



                        <div id="myTabContent" class="tab-content">

                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content0" aria-labelledby="home-tab">


                            <table class="data table table-striped no-margin">
                              <thead>
                                <tr>
                                  <th width="200px">Particulars</th>
                                  <th class="hidden-phone">Value</th>
                                </tr>
                              </thead>
                              <tbody>

                                <?php

                              while ($r=$res_member_data->fetch_field()) {
                                if ($r_md[$r->name] != '' && $r_md[$r->name] !='1900-01-01' && $r_md[$r->name] != '0'){

                                  echo "

                                    <tr>
                                      <td>$r->name</td>
                                      <td class=\"hidden-phone\">".$r_md[$r->name]."</td>
                                    </tr>

                                      ";
                                    }
                                  }


                                  mysqli_free_result($res_member_data);


                                ?>






                              </tbody>
                            </table>



<?php

?>

                          </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="profile-tab">

                            <!-- start deceased info -->

                            <table class="data table table-striped no-margin">
                              <thead>
                                <tr>
                                  <th width="200px">Particulars</th>
                                  <th class="hidden-phone">Value</th>
                                </tr>
                              </thead>
                              <tbody>

                                <?php
                                    echo "
                                <tr>
                                  <td>Date Died</td>
                                  <td class=\"hidden-phone\">".$r_di['Date_of_death']."</td>
                                </tr>
                                <tr>
                                  <td>Cause of Death</td>
                                  <td class=\"hidden-phone\">".$r_di['Reason_of_death']."</td>
                                </tr>
                                <tr>
                                  <td>Place of death</td>
                                  <td class=\"hidden-phone\">".$r_di['Place_of_death']."</td>
                                </tr>
                                <tr>
                                  <td>Date Reported</td>
                                  <td class=\"hidden-phone\">".$r_di['Date_reported']."</td>
                                </tr>
                                <tr>
                                  <td>Reported by</td>
                                  <td class=\"hidden-phone\">".$r_di['Reported_by']."</td>
                                </tr>


                                <tr>
                                  <td>Schedule of Burrial</td>
                                  <td class=\"hidden-phone\">".$r_di['burrial_date']."</td>
                                </tr>
                                <tr>
                                  <td>Memorial Duration</td>
                                  <td class=\"hidden-phone\">".$r_di['memo_serv_duration']." days </td>
                                </tr>
                                <tr>
                                  <td>Surcharge</td>
                                  <td class=\"hidden-phone\">".$r_di['surcharge']."</td>
                                </tr>

                                    ";     

                                  
                                  mysqli_free_result($res_deceased_info);


                                ?>

                              </tbody>
                            </table>


                            <!-- end deceased info -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start payments -->

<?php
                              $res_soa = mysqli_query($con, "call sp_soa('$member_code','DESC');") or die(mysqli_error());
                              echo "
                              <table width=\"100%\" class=\"table table-striped table-bordered table-hover\" id=\"dataTables-mcpr\">
                                  <thead>
                                      <tr>
                                          <!--th>AMOUNT DUE</th-->
                                          <!--th>OVERDUE</th-->
                                          <th>INS #</th>
                                          <th>O.R. DATE</th>
                                          <th>O.R. #</th>
                                          <th>AMOUNT</th>
                                          <th>REMARKS</th>
                                          <!--th>REPORT DATE</th-->
                                      </tr>
                                  </thead>
                                  <tbody>
                              ";
                              while($r=mysqli_fetch_array($res_soa,MYSQLI_ASSOC)){
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

                                          <!--td>$Amt_Due</td-->
                                          <!--td>$Over_Due</td-->                                                            
                                          <td>$Installment_No</td>
                                          <td>$ORdate</td>

                                          <td>$ORno</td>
                                          <td>$Rec_Amt</td>
                                          <td>$Remarks</td>
                                          <!--td class=\"center\">$report_period</td-->

                                      </tr>
                                  ";
                              }
                                                                        
                              mysqli_free_result($res_soa);

                          echo "
                              </tbody>
                              </table>
                          ";

?>

                            <!-- end  payments -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
<!--                               <iframe src="" style="width:100%; height: 800px">
                                
                              </iframe>
 -->

                            <iframe src="fpdf/reports/r_policy.php?Member_Code=<?=$member_code?>#view=FitH" id=prev_pdf name=prev_pdf width="100%" height="800"></iframe>


                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <!-- /page content -->



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
               <input class="form-control" id="Member_Code" name="Member_Code" type="text" value="$member_code" readonly />
               <input type="hidden" name="Member_Code_hidden" id="Member_Code_hidden" value="<?=$member_code?>" />
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
               <input class="form-control" id="member_name" name="member_name" type="text" value="<?=$di_fullname?>" readonly/>
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
               <input class="form-control" id="dod" name="dod" placeholder="MM/DD/YYYY" type="date" value="<?=$di_death_date?>" />
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
               <input class="form-control" id="pod" name="pod"  value="<?=$di_place_of_death ?>" type="text"/>
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
               <input class="form-control" id="reason" name="reason" type="text"  value="<?=$di_reason_of_death ?>" />
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
               <input class="form-control" id="date_reported" name="date_reported" placeholder="MM/DD/YYYY" type="date"  value="<?=$di_date_reported?>" />
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
               <input class="form-control" id="reported_by" name="reported_by" type="text"  value="<?=$di_reportted_by?>"/>
              </div>
             </div>

             <div class="form-group ">
              <label class="control-label requiredField" for="reason">
               Schedule of Burrial
               <span class="asteriskField">
                *
               </span>
              </label>
              <div class="input-group">
               <div class="input-group-addon">
                <i class="fa fa-calendar-check-o">
                </i>
               </div>
               <input class="form-control" id="burrial_date" name="burrial_date" type="date"  value="<?=$di_burrial_date ?>" />
              </div>
             </div>

             <div class="form-group ">
              <label class="control-label requiredField" for="reason">
               Memorial Service Duration
               <span class="asteriskField">
                *
               </span>
              </label>
              <div class="input-group">
               <div class="input-group-addon">
                <i class="fa fa-clock-o">
                </i>
               </div>
               <input type="hidden" name="memo_serv_duration_hidden"  id="memo_serv_duration_hidden" value="<?=$di_memo_serv_duration ?>">
               <input class="form-control" id="memo_serv_duration" name="memo_serv_duration" type="text"  value="<?=$di_memo_serv_duration ?> days" readonly/>
              </div>
             </div>


             <div class="form-group ">
              <label class="control-label requiredField" for="reason">
               Surcharge
               <span class="asteriskField">
                *
               </span>
              </label>
              <div class="input-group">
               <div class="input-group-addon">
                <i class="fa fa-ticket">
                </i>
               </div>
               <input class="form-control" id="surcharge" name="surcharge" type="Number"  value="<?=$di_surcharge ?>" />
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



<script type="text/javascript">

    $(document).on("change","#burrial_date",function(e){
        var burrial_date = $('#burrial_date').val();
        var dod = $('#dod').val();
        var day_diff = diff_days(burrial_date, dod);

        day_diff = isNaN(day_diff)?'0':day_diff;

        $('#memo_serv_duration').val(day_diff +' days')        
        $('#memo_serv_duration_hidden').val(day_diff)        
        //console.log(day_diff);
    });
    $(document).on("change","#dod",function(e){
        var burrial_date = $('#burrial_date').val();
        var dod = $('#dod').val();
        var day_diff = diff_days(burrial_date, dod);

        day_diff = isNaN(day_diff)?'0':day_diff;

        $('#memo_serv_duration').val(day_diff +' days')        
        $('#memo_serv_duration_hidden').val(day_diff)        
        //console.log(day_diff);
    });



    function diff_days(d1, d2) {

      var d1_year = d1.split('-')[0];
      var d1_month = d1.split('-')[1];
      var d1_day = d1.split('-')[2];

      var d2_year = d2.split('-')[0];
      var d2_month = d2.split('-')[1];
      var d2_day = d2.split('-')[2];

      var date1_ms = new Date(d1_year,d1_month,d1_day);
      var date2_ms = new Date(d2_year,d2_month,d2_day);
      var difference_ms =  date1_ms - date2_ms;
    
      return Math.round(difference_ms/86400000); 

     }


    $(document).on("click","#btnaction_deceased_save",function(){

        var Member_Code = $('#Member_Code_hidden').val();
        var bene = $('#member_name').val();
        var dod = $('#dod').val();
        var pod = $('#pod').val();
        var reason = $('#reason').val();
        var date_reported = $('#date_reported').val();
        var reported_by = $('#reported_by').val();

        var burrial_date = $('#burrial_date').val();
        var memo_serv_duration = $('#memo_serv_duration_hidden').val();
        var surcharge = $('#surcharge').val();
        if (dod=='' || pod=='' || reason==''){
            alert('Note: All information with asterisk (*) are required.');            
            return;
        }

        if (confirm('You are about to save the changes made to this member . Do you want to continue? \n\n Member Code: '+Member_Code+' \n Beneficiary: '+bene)){
           $.ajax({  
              type: 'GET',
              url: './proc/updates_proc.php', 
              data: { 
                  action:'update_deceased',
                  Member_Code:Member_Code,
                  dod:dod,
                  pod:pod,
                  reason:reason,
                  date_reported:date_reported,
                  reported_by:reported_by,
                  burrial_date:burrial_date,
                  memo_serv_duration:memo_serv_duration,
                  surcharge:surcharge,
                  user_id:"<?=$user_id?>"
              },
              success: function(response) {
                   console.log('res:' + response);
                   if (response.indexOf("**success**") > -1){
                       window.location = "index.php?page=memo_details&member_code="+Member_Code;               
                   }else if (response.indexOf("**failed**") > -1){
                      alert("Update failed!");
                     
                   }
                   
              }
          }); 

        }



    });


    $(document).on("click","#btn_memorial_approval",function(e){
        e.preventDefault();

        var id          = $(this).attr('deceased_id');
        var Member_Code = $(this).attr('Member_Code');

        if (confirm('I certify this client as eligible to receive memorial services')){
            $.ajax({  
                type: 'GET',
                url: './proc/memorial_proc.php', 
                data: { 
                    id:id,
                    action:"approve",
                    user_id:"<?=$user_id?>",
                    Member_Code:Member_Code
                },
                success: function(response) {
                     //prompt(response,response);return;
                     if (response.indexOf("**success**") > -1){
                        window.location = "index.php?page=memo_details&member_code="+Member_Code;
                     }else if (response.indexOf("**failed**") > -1){
                         alert('An error occured while processing transactions!');
                     }
                }
            });  
        }


    });
    

</script>