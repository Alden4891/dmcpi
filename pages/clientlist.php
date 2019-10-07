<?php
  $search_criteria = (isset($_REQUEST['search_criteria'])?strtolower($_REQUEST['search_criteria']):'');
  $search_agent = (isset($_REQUEST['search_agent'])?strtolower($_REQUEST['search_agent']):'');
  $search_plan = (isset($_REQUEST['search_plan'])?strtolower($_REQUEST['search_plan']):'');
  $search_branch = (isset($_REQUEST['search_branch'])?strtolower($_REQUEST['search_branch']):'');

//print_r($_REQUEST);

  $res_branch = mysqli_query($con, "SELECT Branch_ID, CONCAT(LEFT(BRANCH_NAME,1),Branch_ID) AS BRANCH_CODE, BRANCH_NAME, BRANCH_MANAGER FROM branch_details GROUP BY BRANCH_CODE;") or die(mysqli_error());
  $res_agent = mysqli_query($con, "SELECT `AgentID` , CONCAT(`First_name`,' ',LEFT(`Middle_Name`,1),'. ',`Last_name`) AS AGENT_NAME , `Initials` AS `AGENT_CODE` FROM `dmcpi1_dmcsm`.`agent_profile` WHERE agentid > -1;") or die(mysqli_error());
  $res_plan = mysqli_query($con, "SELECT Plan_ID, Plan_Code, plan_name FROM packages GROUP BY Plan_Code, plan_name;") or die(mysqli_error());

  $MP_MEMBER_DELETION_DISABLER = isAuthorized('MP_MEMBER_DELETION')?'':'disabled';


?>


<div class="row">
    <div class="col-lg-6">
        <h1 class="page-header">DMCPI Member's Profile</h1>
    </div>
    <div class="col-lg-6">
    <BR><BR>
    <?php
      echo "
       <span class=\" pull-right\" >
           <a href=\"index.php?page=cliregistrationform&Member_Code=&uniqid=<?=uniqid()?>\" type=\"button\" class=\"btn btn-success btn-md $MP_MEMBER_ENCODING_DISABLER\"><i class=\"fa fa-plus\" ></i> New Member</a>
       </span>  
      ";

    ?>
    </div>
    <!-- /.col-lg-12 -->
</div>


           <!-- search section __________________________________________________________________________________________________________________________________ -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            SEARCH
                        </div>
                        <div class="panel-body">
                            

                         <form action='index.php' method="GET">
                          <input type="hidden" name="page" value="clientlist">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="Search for..." value="<?=$search_criteria ?>" id=search_criteria name="search_criteria">
                                  <span class="input-group-btn">
                                    <!--button class="btn btn-default" type="button" id=btnclientlistsearch>Search!</button-->
                                    <button class="btn btn-info" type="submit">Search!</button>

                                  </span>
                                </div>
                              </div>
                             </div>

                            <div class="row">

                              <div class="col-lg-4">
                                <div class="input-group label-floating" >
                                <label class="control-label">BRANCH OFFICE</label>
                                <select class="form-control" id=search_branch style="" name="search_branch">
                                  <option value=''>ANY BRANCH 
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                  </option>

                                    <?php
                                    //$res_agent = mysqli_query($con, "SELECT * FROM vagentlist ORDER BY fullname");
                                    while ($r=mysqli_fetch_array($res_branch, MYSQLI_ASSOC)) {
                                        $Branch_ID = $r['Branch_ID'];
                                        $BRANCH_NAME = $r['BRANCH_NAME'];

                                        $selected = ($Branch_ID==$search_branch?"selected":"");

                                        echo "<option value='$Branch_ID' $selected>$BRANCH_NAME </option>";
                                    }
                                   // mysqli_free_result($res_branch);
                                    ?>


                                </select>
                                </div>
                              </div>


                              <div class="col-lg-4">
                                <div class="input-group label-floating" >
                                <label class="control-label">AGENT NAME</label>
                                <select class="form-control" id=search_agent style="" name="search_agent">
                                  <option value=''>ANY AGENT
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                  </option>
                                    <?php
                                    //$res_agent = mysqli_query($con, "SELECT * FROM vagentlist ORDER BY fullname");
                                    while ($r=mysqli_fetch_array($res_agent, MYSQLI_ASSOC)) {
                                        $agent = $r['AGENT_NAME'];
                                        $AgentID = $r['AgentID'];
                                        $initial = $r['AGENT_CODE'];

                                        $selected = ($AgentID==$search_agent?"selected":"");

                                        echo "<option value='$AgentID' $selected>$initial - $agent </option>";
                                    }
                                    //mysqli_free_result($res_agent);
                                    ?>
                                </select>
                                </div>
                              </div>

                              <div class="col-lg-4">
                                <div class="input-group label-floating">
                                <label class="control-label">PLAN</label>
                                <select class="form-control" id="search_plan"  style="" name="search_plan">
                                  <option value="">ANY PLAN
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                  </option>

                                    <?php
                                    
                                    //$res_agent = mysqli_query($con, "SELECT Plan_id, Plan_Code,Plan_name FROM packages ORDER BY Plan_Code");

                                    while ($r=mysqli_fetch_array($res_plan, MYSQLI_ASSOC)) {
                                        $value = $r['Plan_Code'];
                                        $caption = $r['plan_name'];
                                        $Plan_id = $r['Plan_ID'];

                                        $selected = ($Plan_id==$search_plan?"selected":"");

                                        echo "<option value='$Plan_id' $selected>$value - $caption </option>";
                                    }
                                    //mysqli_free_result($res_plan);
                                    ?>

                                </select>
                                </div>
                              </div>
                            </div> 
                         </form>


                        </div> <!-- body -->
                    </div>
                </div>
            </div>



          <!-- list section __________________________________________________________________________________________________________________________________ -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" id=row_count>
                All records
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-bordered" id="datatable-buttons">
                    <thead>
                        <tr>
                            <th >Code</th>
                            <th >Name</th>

                            <th >Branch</th>
                            <th >Agent</th>
                            <th >Plan type</th>

                            <th>Options</th>

                            <th class="none">Status</th>
                            <th class="none" >Cur. Term</th>
                            <th class="none" >Membership Date</th>
                            <th class="none" >Remarks</th>

                        </tr>
                    </thead>
                    <tbody id=clientlist>
                        <?php 
                          $str_plan_where_claus = ($search_plan==''?"":" AND `packages`.`Plan_id` = '$search_plan'");
                          $str_agent_where_claus = ($search_agent==''?"":" AND `agent_profile`.`AgentID`  = '$search_agent'");
                          $str_branch_where_claus = ($search_branch==''?"":" AND `members_account`.`branchmanager`  = '$search_branch'");

                            $sql = "
                          SELECT
                            `members_account`.`Member_Code`          AS `Member_Code`
                            , CONCAT(`members_profile`.`Lname`,', ',`members_profile`.`Fname`,' ',SUBSTR(IFNULL(`members_profile`.`Mname`,''),1,1)) AS `Fullname`
                            , `agent_profile`.`initials`             AS `Agent`
                            , `branch_details`.`Branch_Name`         AS `Branch_Name`
                            , `packages`.`Plan_Code`                 AS `Plan_Code`
                            , `members_account`.`Remarks`            AS `Remarks`
                            , `members_account`.`No_of_units`        AS `No_of_Units`
                            , `members_account`.`Insurance_Type`     AS `Insurance_Type`
                            , `members_account`.`Date_of_membership` AS `Date_of_Membership`
                            , `members_account`.`Account_Status`     AS `Account_Status`
                            , `members_account`.`Current_term`       AS `Current_Term`
                            , `members_profile`.`ENTRY_ID`           AS `ENTRY_ID`
                          FROM `members_account`
                              INNER JOIN `members_profile`
                               ON `members_account`.`Member_Code` = `members_profile`.`Member_Code`
                              LEFT JOIN agent_profile
                               ON `members_account`.AgentID = agent_profile.AgentID
                              LEFT JOIN packages
                               ON members_account.Plan_id = packages.Plan_id
                              LEFT JOIN branch_details
                               ON members_account.BranchManager = branch_details.Branch_ID
                          WHERE (
                              CONCAT(`members_profile`.`Lname`,', ',`members_profile`.`Fname`,', ',SUBSTR(IFNULL(`members_profile`.`Mname`,''),1,1)) LIKE '%$search_criteria%' 
                              OR `members_account`.`Member_Code` LIKE '%$search_criteria%'
                              OR `members_account`.`Remarks` LIKE '%$search_criteria%') 

                          $str_branch_where_claus
                          $str_plan_where_claus 
                          $str_agent_where_claus 
                               
                              
                          GROUP BY 
                            `members_account`.`Member_Code`, 
                            `Fullname`,
                            `agent_profile`.`Initials`,
                            `packages`.`Plan_Code`, 
                            `members_account`.`No_of_units`, 
                            `members_account`.`Insurance_Type`, 
                            `members_account`.`Date_of_membership`, 
                            `members_account`.`Account_Status`, 
                            `members_account`.`Current_term`, 
                            `members_profile`.`ENTRY_ID`
                          ORDER BY `members_profile`.`ENTRY_ID` DESC
                          LIMIT 0, 50;
                            ";

                            $res_members_list = mysqli_query($con, $sql) or die(mysqli_error());
                            while ($r=mysqli_fetch_array($res_members_list,MYSQLI_ASSOC)) {
                                $Member_Code = $r['Member_Code']; 
                                $Fullname = strtoupper($r['Fullname']); 
                                $Branch_Name = $r['Branch_Name'];
                                $Agent = $r['Agent']; 
                                $Plan_Code = $r['Plan_Code']; 
                                //$No_of_Units = $r['No_of_Units']; 
                                $Account_Status = $r['Account_Status'];
                                $Current_Term = $r['Current_Term'];
                                $Date_of_Membership = $r['Date_of_Membership'];
                                $isLacking = ($r['Remarks']=='Lacking'?1:0); 
                                $Remarks = $r['Remarks'];

                                $row_colorclass = "";                                
                                if ($Account_Status == "Overdue"){
                                    $row_colorclass = "warning";
                                }elseif ($Account_Status == "Inactive"){
                                    $row_colorclass  = "danger";
                                }else {
                                    $row_colorclass = "";
                                }




                                $payment_button_htm = "";
                                if ($isLacking == 1){
                                    $row_colorclass  = "info";
                                    $payment_button_htm = "<a 
                                            Member_Code=\"$Member_Code\"
                                            id=btnViewPaymentDetails
                                            path=\"?page=clientpaymentinfo&Member_Code=$Member_Code\" 
                                            data-toggle=\"modal\" data-target=\".modal-updater-1\"
                                            class=\"btn btn-success btn-circle btn-xs $MP_PAYMENT_DISABLER\"><i class=\"fa fa-money\"></i></a>";                                
                                }else{
                                    $payment_button_htm = "<a href=\"?page=clientpaymentinfo&Member_Code=$Member_Code\" 
                                            data-toggle=\"tooltip\" data-placement=\"left\" title=\"Open Payment Information\"
                                            class=\"btn btn-success btn-circle btn-xs $MP_PAYMENT_DISABLER\"><i class=\"fa fa-money\"></i></a>";
                                }

                                echo "
                                    <tr class=\"$row_colorclass\">
                                        <td class=\"even gradeC\"> $Member_Code</td>
                                        <td>$Fullname</td>
                                        <td>$Branch_Name</td>
                                        <td>$Agent</td>
                                        <td>$Plan_Code</td>
                                        <td>
                                            $payment_button_htm
                                            
                                            <a href=\"#\" 
                                            link=\"fpdf/reports/r_policy.php?Member_Code=$Member_Code#view=FitH\" 
                                            target=_blank 
                                            title=\"View policy\"
                                            id=btn_policy_preview
                                            data-toggle=\"modal\" 
                                            data-target=\".preview_modal\"                                           
                                            class=\"btn btn-info btn-circle  btn-xs\"
                                            ><i class=\"glyphicon glyphicon-list-alt\"></i></a>

                                            <a href=\"?page=cliregistrationform&Member_Code=$Member_Code\" 
                                            data-toggle=\"tooltip\" data-placement=\"left\" title=\"Edit beneficiary's Basic Information\"         
                                            class=\"btn btn-warning btn-circle  btn-xs $MP_MEMBER_ENCODING_DISABLER\"><i class=\"glyphicon glyphicon-edit \"></i></a>

                                            <a href=\"#\" 
                                            data-toggle=\"tooltip\" data-placement=\"left\" title=\"Delete Client Information\"
                                            class=\"btn btn-danger  btn-xs btn-circle $MP_MEMBER_DELETION_DISABLER\"><i class=\"glyphicon glyphicon-remove\" id=delete_client membercode=$Member_Code></i></a>


                                        </td>
                                        <td>$Account_Status</td>
                                        <td>$Current_Term</td>
                                        <td>$Date_of_Membership</td>
                                        <td>$Remarks</td>

                                </tr>

                                ";

                            }
                            mysqli_free_result($res_members_list);
                            
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



<div class="modal fade bs-example-modal-sm preview_modal" tabindex="-1" role="dialog" aria-labelledby="modal_preview">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Preview</h4>


            </div>
            <div class="modal-body">
             <iframe id=prev_pdf name=prev_pdf width="100%" height="800"></iframe>
            
            </div>
   
    </div>
  </div>
</div>


<div class="modal fade modal-updater-1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">UPDATING OF LACKING INFORMATION</h4>
      </div>
      <div class="modal-body">

          <form class="form-horizontal">
          <fieldset>

          <!-- Form Name -->
          <div class="basic_info_container">
              <legend>BASIC INFORMATION</legend>
              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="Member_Code">MEMBER CODE</label>  
                <div class="col-md-4">
                <input id="Member_Code" name="Member_Code" type="text" placeholder="" class="form-control input-md " disabled>
                <input id="Member_Code_hidden" name="Member_Code_hidden" type="hidden">
                <input id="path" name="path" type="hidden">
                 
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="txtfirstname">FIRST NAME</label>  
                <div class="col-md-4">
                <input id="txtfirstname" name="txtfirstname" type="text" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="txtmiddlename">MIDDLE NAME</label>  
                <div class="col-md-4">
                <input id="txtmiddlename" name="txtmiddlename" type="text" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="txtlastname">LASTNAME</label>  
                <div class="col-md-4">
                <input id="txtlastname" name="txtlastname" type="text" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>

              <!-- Select Basic -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="selSex">SEX</label>
                <div class="col-md-4">
                  <select id="selSex" name="selSex" class="form-control">
                    <option value="Male">MALE</option>
                    <option value="Female">FEMALE</option>
                  </select>
                </div>
              </div>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="dtDOB">DATE OF BIRTH</label>  
                <div class="col-md-4">
                <input id="dtDOB" name="dtDOB" type="date" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>
          </div> <!-- BASIC INFORMATION CONTAINER -->


          <div class="account_info_container">

              <legend>ACCOUNT INFORMATION</legend>

              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="dtDOI">DATE OF INCEPTION</label>  
                <div class="col-md-4">
                <input id="dtDOI" name="dtDOI" type="date" placeholder="" class="form-control input-md" required>
                <span class="help-block">Date of Membership</span>  
                </div>
              </div>

              <!-- Select Basic -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="selPlan">PLAN</label>
                <div class="col-md-4">
                  <select id="selPlan" name="selPlan" class="form-control">
                   <option value="">None</option>
                  <?php
                      mysqli_data_seek($res_plan, 0);
                      while ($r=mysqli_fetch_array($res_plan,MYSQLI_ASSOC)) { 
                          $Plan_ID = $r['Plan_ID'];
                          $Plan_Code = $r['Plan_Code'];
                          $plan_name = $r['plan_name'];
                          $selplan = "";
                          if ($ddplan_code==$Plan_Code) $selplan = "Selected";
                          echo "<option value=\"$Plan_ID\"  $selplan >$Plan_Code</option>";
                      }
                      mysqli_free_result($res_plan);
                  ?>    
                  </select>
                </div>
              </div>



              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-4 control-label" for="no_of_units">NO. OF UNITS</label>  
                <div class="col-md-4">
                <input id="no_of_units" name="no_of_units" type="number" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>






              <!-- Select Basic -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="selAgent">AGENT</label>
                <div class="col-md-4">
                  <select id="selAgent" name="selAgent" class="form-control">
                  <option value="">NONE</option>
                    <?php
                        mysqli_data_seek($res_agent, 0);
                        while ($r=mysqli_fetch_array($res_agent,MYSQLI_ASSOC)) { 
                            $value = $r["AgentID"];
                            $code = $r["AGENT_CODE"];
                            $name = $r["AGENT_NAME"];
                            $selAgent="";
                            if ($ddagent==$code) $selAgent = "selected";
                            echo "<option value=\"$value\" $selAgent>$code - $name</option>";
                        }
                     mysqli_free_result($res_agent);
                    
                    ?>    
                  </select>
                </div>
              </div>

              <!-- Select Basic -->
              <div class="form-group">
                <label class="col-md-4 control-label" for="selBranch">BRANCH</label>
                <div class="col-md-4">
                  <select id="selBranch" name="selBranch" class="form-control">
                  <option value="">None</option>
                     <?php
                        mysqli_data_seek($res_branch, 0);
                         while ($r=mysqli_fetch_array($res_branch,MYSQLI_ASSOC)) { 
                            $value = $r["Branch_ID"];
                            $code = $r["BRANCH_CODE"];
                            $name = $r["BRANCH_NAME"];
                            $branch_manager = $r["BRANCH_MANAGER"];
                            $selBM = "";


                            if (trim($name)==trim($ddBranch_name)) $selBM = "Selected";

                            echo "<option value=\"$value\" $selBM >$name</option>";
                        }
                        mysqli_free_result($res_branch);
                    ?>    
                  </select>
                </div>
              </div>
          </div> <!-- account_info_container -->


          <!-- div class="payment_info_container">
              <legend>DETAIL OF PREVIOUS PERIOD PAYMENT</legend>

              <div class="form-group">
                <label class="col-md-4 control-label" for="dtReceiptDate">RECEIPT DATE</label>  
                <div class="col-md-4">
                <input id="dtReceiptDate" name="dtReceiptDate" type="date" placeholder="" class="form-control input-md" required>
                <span class="help-block">Date of payment</span>  
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="txtORPR">OR/PR #</label>  
                <div class="col-md-4">
                <input id="txtORPR" name="txtORPR" type="number" placeholder="" class="form-control input-md" required>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="selPeriod">PERIOD</label>
                <div class="col-md-4">
                  <select id="selPeriod" name="selPeriod" class="form-control">
                    <option value="1" selected>January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="selYear">YEAR</label>
                <div class="col-md-4">
                  <select id="selYear" name="selYear" class="form-control">
                    <?php
                        $current_year = date("Y");
                      for ($i=2013;$i<=$current_year+1;$i++) {
                        if ($current_year==$i) {
                          echo "<option value=$i selected>$i</option>";
                        }else{
                          echo "<option value=$i>$i</option>";
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="txtNoPeriodPaid">NO. PERIOD PAID</label>  
                <div class="col-md-4">
                <input id="txtNoPeriodPaid" name="txtNoPeriodPaid" type="number" placeholder="" class="form-control input-md" required>
                <span class="help-block">Total Number of Month Paid</span>  
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label" for="txtAmountPaid" >AMOUNT</label>  
                <div class="col-md-4">
                <input id="txtAmountPaid" name="txtAmountPaid" type="number" placeholder="" class="form-control input-md" disabled>
                <span class="help-block">The total amount indicated in the receipt</span>  
                </div>
              </div>

            </div> <**payment_info_container -->
          <!-- Button -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="btnUpdate"></label>
            <div class="col-md-4">
              <button id="btnUpdate" name="btnUpdate" class="btn btn-primary pull-right">UPDATE</button>
            </div>
          </div>

          </fieldset>
          </form>


      </div>

      
    </div>
  </div>
</div>






<script>
/*
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
*/
  
    function isEmpty(value) {
        if ($.trim(value) == '') return true;
        else if ($.trim(value) == '0') return true;
        else if ($.trim(value) == undefined) return true;
        else if (value == undefined) return true;
    }


    $(document).on("click","#btnUpdate", function(e){
        e.preventDefault();

        var txtlastname =     $('#txtlastname').val();
        var txtmiddlename =   $('#txtmiddlename').val();
        var txtfirstname =    $('#txtfirstname').val();
        var selSex =          $('#selSex').val();
        var dtDOB =           $('#dtDOB').val();
  
        var dtDOI =           $('#dtDOI').val();
        var selPlan =         $('#selPlan').val();
        var selAgent =        $('#selAgent').val();
        var selBranch =       $('#selBranch').val();
        var no_of_units =     $('#no_of_units').val();

/*
        var dtReceiptDate =   $('#dtReceiptDate').val();
        var txtORPR =         $('#txtORPR').val();
        var selPeriod =       $('#selPeriod').val();
        var selYear =         $('#selYear').val();
        var txtNoPeriodPaid = $('#txtNoPeriodPaid').val();
        //var txtAmountPaid =   $('#txtAmountPaid').val(); 
*/
        var Member_Code_hidden=$('#Member_Code_hidden').val();
        var path=$('#path').val();

        if (isEmpty(txtlastname)) {
          alert('Lastname is required!');
          return;
        }
        if (isEmpty(txtfirstname)) {
          alert('Firstname is required!');
          return;
        }
        if (isEmpty(selSex)) {
          alert('Gender is required!');
          return;
        }
        if (isEmpty(dtDOB)) {
          alert('Date of birth is required!');
          return;
        }

        if (isEmpty(dtDOI)) {
          alert('Date of Inception is required!');
          return;
        }
        if (isEmpty(selPlan)) {
          alert('Plan type is required!');
          return;
        }
        if (isEmpty(selAgent)) {
          alert('Agent is required!');
          return;
        }
        if (isEmpty(selBranch)) {
          alert('Barnch is required!');
          return;
        }
        if (isEmpty(no_of_units)) {
          alert('Number of units is required!');
          return;
        }


        $.ajax({  
            type: 'GET',
            url: './proc/clientlist_update_proc.php', 
            data: { 
                Member_Code:Member_Code_hidden,
                txtlastname:txtlastname,
                txtmiddlename:txtmiddlename,
                txtfirstname:txtfirstname,
                selSex:selSex,
                dtDOB:dtDOB,

                dtDOI:dtDOI,
                selPlan:selPlan,
                selAgent:selAgent,
                selBranch:selBranch,
                no_of_units: no_of_units,

//                dtReceiptDate:dtReceiptDate,
//                txtORPR:txtORPR,
//                selPeriod:selPeriod,
//                selYear:selYear,
//                txtNoPeriodPaid:txtNoPeriodPaid,
//                txtAmountPaid:txtAmountPaid  

            },
            success: function(response) {
                  //alert(response);
                 console.log('res: '+response);
                 if (response.indexOf("**success**") > -1){

                    var strarray=response.split('|');

/*
                      $('#txtfirstname').val(strarray[1]);
                      $('#txtmiddlename').val(strarray[2]);
                      $('#txtlastname').val(strarray[3]);
                      $('#selSex').val(strarray[4]);
                      $('#dtDOB').val(strarray[5]);
*/
                    alert('Update Success!');
                    window.location = path;

                }else if (response.indexOf("**failed**") > -1){
                   
                    alert('Update Failed!');
               
                 }
            }
        });        

  


    });

    $(document).on("click","#btnViewPaymentDetails", function(e){
        e.preventDefault();
        
        var Member_Code = $(this).attr('Member_Code');

        $('#txtlastname').val('');
        $('#txtmiddlename').val('');
        $('#txtfirstname').val('');
        $('#selSex').val('');
        $('#dtDOB').val('');

        $('#dtDOI').val('');
        $('#selPlan').val('');
        $('#selAgent').val('');
        $('#selBranch').val('');

        $('#no_of_units').val('1');
        $('#path').val($(this).attr('path'));

//        $('#dtReceiptDate').val('');
//        $('#txtORPR').val('');
//        $('#selPeriod').val('');
//        $('#selYear').val(2018);
//        $('#txtNoPeriodPaid').val(1);
//        $('#txtAmountPaid').val('');

        $('#Member_Code').val('');
        $('#Member_Code_hidden').val('');

        $.ajax({  
            type: 'GET',
            url: './proc/getregistration_details_proc.php', 
            data: { 
                Member_Code:Member_Code
            },
            success: function(response) {
                
                 console.log('res: '+response);
                 if (response.indexOf("**success**") > -1){
                    /*    0 - result status
                          
                          1 -  'Fname'
                          2 -  'Mname'
                          3 -  'Lname'
                          4 -  'Sex'
                          5 -  'Bdate'

                          //account details
                          6 -  'date_of_membership'
                          7 -  'Plan_id'
                          8 -  'agent_id'
                          9 -  'Branch_ID'

                    */
                    var strarray=response.split('|');

                      $('#Member_Code').val(Member_Code);
                      $('#Member_Code_hidden').val(Member_Code);

                      $('#txtfirstname').val(strarray[1]);
                      $('#txtmiddlename').val(strarray[2]);
                      $('#txtlastname').val(strarray[3]);
                      $('#selSex').val(strarray[4]);
                      $('#dtDOB').val(strarray[5]);

                      $('#dtDOI').val(strarray[6]);
                      $('#selPlan').val(strarray[7]);
                      $('#selAgent').val(strarray[8]);
                      $('#selBranch').val(strarray[9]);

                      $('#no_of_units').val(strarray[10]);

                      /*
                      $('#dtReceiptDate').val(strarray[10]);
                      $('#txtORPR').val(strarray[11]);
                      $('#selPeriod').val(strarray[12]);
                      $('#selYear').val(strarray[13]);
                      $('#txtNoPeriodPaid').val(strarray[14]);
                      $('#txtAmountPaid').val(strarray[15]);
                      */
                }else if (response.indexOf("**failed**") > -1){
                    alert('No record found');

                 }
                 
            }
        });        
    });

    $(document).on("click","#btn_policy_preview",function(e){
        e.preventDefault();
        var iframe = $('#prev_pdf');
        var link = $(this).attr('link');
        
        $(iframe).attr('src', link);      

    });


    // $(document).on("click","#btnclientlistsearch",function(){
    //     var search_criteria = $('#search_criteria').val();
    //     var search_plan= $('select[id="search_plan"]').val();
    //     var search_agent= $('select[id="search_agent"]').val();
    //     alert("Im out");


    //     $('#clientlist').html('');  
    //         $.ajax({  
    //             type: 'GET',
    //             url: './proc/clientlistsearch_proc.php', 
    //             data: { 
    //                 search_criteria:search_criteria,
    //                 search_agent:search_agent,
    //                 search_plan:search_plan
    //             },
    //             success: function(response) {
    //                  //prompt('res: ',response);
    //                  console.log('res: '+response);
    //                  //return;
    //                  if (response.indexOf("**success**") > -1){
    //                     //    0 - result status
    //                     //    1 - html table rows for detail section
    //                     //    2 - row count
    //                     var strarray=response.split('|');
                        
    //                      $('#clientlist').append(strarray[1]).fadeIn('slow');
    //                      $('#row_count').html( strarray[2] +' record found');

    //                  }else if (response.indexOf("**failed**") > -1){
    //                     $('#row_count').html('No record found');
    //                     alert('No record found');

    //                  }
    //             }
    //     });
    // });


    $(document).on('click','#delete_client',function(){
        var member_code = $(this).attr('membercode');
        var userid  = $('#user_info').attr('user_id');
        var row = $(this).closest('tr');

        if (confirm('You are about to permanently delete this client. Do you want to continue?')){
              $.ajax({  
                type: 'GET',
                url: './proc/clientdelete_proc.php', 
                data: { 
                    member_code:member_code,
                    userid:userid
                },
                success: function(response) {
                    if (response.indexOf("**success**") > -1){
                        row.fadeOut(500, function() {
                            $(this).remove();
                        });

                     }else if (response.indexOf("**failed**") > -1){
                         alert('Unable to delete this client! You can only delete newly added client!');
                     }
                }
        });          
        }

    });


</script>

