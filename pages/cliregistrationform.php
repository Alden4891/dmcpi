


<?php

//-- DATA ENTRIES -----------------------------------------------------------------



$viewonly = false;
$user_mode="";
if ($viewonly) $user_mode = "disabled";


//echo "<script>console.log( '>Loading branches...' + new Date().toLocaleString() );</script>";
$res_branch = mysqli_query($con, "SELECT Branch_ID, CONCAT(LEFT(BRANCH_NAME,1),Branch_ID) AS BRANCH_CODE, BRANCH_NAME, BRANCH_MANAGER FROM branch_details GROUP BY BRANCH_CODE;") or die(mysqli_error());

//echo "<script>console.log( '>Loading Insurances' + new Date().toLocaleString() );</script>";
$res_insurace = mysqli_query($con, "SELECT CODE AS INS_CODE, NAME AS INS_NAME FROM insurance ") or die(mysqli_error());

//echo "<script>console.log( '>Loading AO' + new Date().toLocaleString() );</script>";
$res_ao =    mysqli_query($con, "SELECT `AgentID` , CONCAT(`First_name`,' ',LEFT(`Middle_Name`,1),'. ',`Last_name`) AS AGENT_NAME , `Initials` AS `AGENT_CODE` FROM `dmcpi1_dmcsm`.`agent_profile` ;") or die(mysqli_error());

//echo "<script>console.log( '>Loading agents' + new Date().toLocaleString() );</script>";
$res_agent = mysqli_query($con, "SELECT `AgentID` , CONCAT(`First_name`,' ',LEFT(`Middle_Name`,1),'. ',`Last_name`) AS AGENT_NAME , `Initials` AS `AGENT_CODE` FROM `dmcpi1_dmcsm`.`agent_profile` WHERE agentid > -1;") or die(mysqli_error());

//echo "<script>console.log( '>Loading plans' + new Date().toLocaleString() );</script>";
$res_plan = mysqli_query($con, "SELECT Plan_ID, Plan_Code, plan_name FROM packages GROUP BY Plan_Code, plan_name;") or die(mysqli_error());


$Member_Code='';
        $ddFname='';
        $ddMname='';
        $ddLname='';
        $ddFullname='';
        $ddNname='';
        $ddSex='';
        $ddcStatus='';
        $ddStreet='';
        $ddBarangay='';
        $ddCity='';
        $ddProvince='';
        $ddIDno='';
        $ddBdate='';
        $ddAge='';
        $ddBplace='';
        $ddOccupation='';
        $ddreligion='';
        $ddpname='';
        $ddpage='';
        $ddprelation='';
        $ddpcontactno='';
        $ddcstreet='';
        $ddcbarangay='';
        $ddccity='';
        $ddcprovince='';
        $ddmcontactno='';
        $ddbname='';
        $ddbbdate='';
        $ddbage='';
        $ddbrelation='';
        $ddbstatus='';
        $ddbcontactno='';
        $dddname1='';
        $dddbdate1='';
        $dddage1='';
        $dddrelation1='';
        $dddstatus1='';
        $dddname2='';
        $dddbdate2='';
        $dddage2='';
        $dddrelation2='';
        $dddstatus2='';
        $dddname3='';
        $dddbdate3='';
        $dddage3='';
        $dddrelation3='';
        $dddstatus3='';
        $dddname4='';
        $dddbdate4='';
        $dddage4='';
        $dddrelation4='';
        $dddstatus4='';
        $ddplan_code='';
        $ddno_of_units='';
        $ddagent='';
        $ddinsurance_type='';
        $dddate_of_membership='';
        $ddcurrent_term='';
        $ddaccount_status='';
        $ddremarks='';
        $ddAO='';
        $ddBM='';
        $ddPRdate='';
        $ddPRno='';
        $ddORdate='';
        $ddORno='';
        $ddamount='';
        $ddAgentName='';
        $ddAOname='';
        $ddplan_name='';
        $ddBranch_name='';



$Member_Code = (isset($_REQUEST['Member_Code'])?$_REQUEST['Member_Code']:'none');
$uniqid = (isset($_REQUEST['uniqid'])?$_REQUEST['uniqid']:'');


$res_ps = mysqli_query($con,"select Amt_Due,ORdate,ORno from installment_ledger where Member_Code = '$Member_Code' and Installment_No=0;");

$ps_arr = mysqli_fetch_array($res_ps,MYSQLI_ASSOC);    

$ps_orno = $ps_arr["Amt_Due"];    
$ps_ordate = $ps_arr["ORdate"];    
$ps_amount = $ps_arr["ORno"];    

//echo "Member_Code: [$Member_Code] - ".empty($Member_Code) ;

if ($Member_Code!='none' && !empty($Member_Code)){

    echo "<script>console.log( '>Member_Code: $Member_Code');</script>";

    $res_membership_form = mysqli_query($con, "

SELECT DISTINCT
  `members_profile`.`Member_Code`        AS `Member_Code`,
  `members_profile`.`Fname`              AS `Fname`,
  `members_profile`.`Mname`              AS `Mname`,
  `members_profile`.`Lname`              AS `Lname`,
  ((((`members_profile`.`Lname` + ',..... ') + `members_profile`.`Fname`) + ' ') + `members_profile`.`Mname`) AS `Fullname`,
  `members_profile`.`Nname`              AS `Nname`,
  `members_profile`.`Sex`                AS `Sex`,
  `members_profile`.`Status`             AS `Status`,
  `members_profile`.`Address`            AS `Address`,
  `members_profile`.`IDno`               AS `IDno`,
  `members_profile`.`Bdate`              AS `Bdate`,
  `members_profile`.`Age`                AS `Age`,
  `members_profile`.`Bplace`             AS `Bplace`,
  `members_profile`.`Occupation`         AS `Occupation`,
  `members_profile`.`Religion`           AS `religion`,
  `members_profile`.`Pname`              AS `pname`,
  `members_profile`.`Page`               AS `page`,
  `members_profile`.`Prelation`          AS `prelation`,
  `members_profile`.`Pcontactno`         AS `pcontactno`,
  `members_profile`.`CAddress`           AS `CollectionAddress`,
  `members_profile`.`Mcontactno`         AS `mcontactno`,
  `members_profile`.`Bname`              AS `bname`,
  `members_profile`.`Bbdate`             AS `bbdate`,
  `members_profile`.`Bage`               AS `bage`,
  `members_profile`.`Brelation`          AS `brelation`,
  `members_profile`.`Bstatus`            AS `bstatus`,
  `members_profile`.`Bcontactno`         AS `bcontactno`,
  `members_profile`.`Dname1`             AS `dname1`,
  `members_profile`.`Dbdate1`            AS `dbdate1`,
  `members_profile`.`Dage1`              AS `dage1`,
  `members_profile`.`Drelation1`         AS `drelation1`,
  `members_profile`.`Dstatus1`           AS `dstatus1`,
  `members_profile`.`Dname2`             AS `dname2`,
  `members_profile`.`Dbdate2`            AS `dbdate2`,
  `members_profile`.`Dage2`              AS `dage2`,
  `members_profile`.`Drelation2`         AS `drelation2`,
  `members_profile`.`Dstatus2`           AS `dstatus2`,
  `members_profile`.`Dname3`             AS `dname3`,
  `members_profile`.`Dbdate3`            AS `dbdate3`,
  `members_profile`.`Dage3`              AS `dage3`,
  `members_profile`.`Drelation3`         AS `drelation3`,
  `members_profile`.`Dstatus3`           AS `dstatus3`,
  `members_profile`.`Dname4`             AS `dname4`,
  `members_profile`.`Dbdate4`            AS `dbdate4`,
  `members_profile`.`Dage4`              AS `dage4`,
  `members_profile`.`Drelation4`         AS `drelation4`,
  `members_profile`.`Dstatus4`           AS `dstatus4`,
  `packages`.`Plan_Code`                 AS `plan_code`,
  `packages`.`form_number`               AS `form_number`,
  `members_account`.`No_of_units`        AS `no_of_units`,
  `agent_profile`.`Initials`             AS `agent`,
  `agent_profile`.`AgentID`              AS `agent_id`,
  CONCAT(`agent_profile`.`First_name`,' ',LEFT(`agent_profile`.`Middle_Name`,1),'. ',`agent_profile`.`Last_name`) AS `agent_fullname`,
  `members_account`.`Insurance_Type`     AS `insurance_type`,
  `members_account`.`Date_of_membership` AS `date_of_membership`,
  `members_account`.`Current_term`       AS `current_term`,
  `members_account`.`Account_Status`     AS `account_status`,
  `members_account`.`Remarks`            AS `remarks`,
  `agent_profile_ao`.`Initials`          AS `AO`,
  `bd`.`Branch_Manager`                  AS `branch_manager`,
  `bd`.`BManager_Initials`               AS `BManager_Initials`,
  `members_account`.`PRdate`             AS `PRdate`,
  `members_account`.`PRno`               AS `PRno`,
  `members_account`.`ORdate`             AS `ORdate`,
  `members_account`.`ORno`               AS `ORno`,
  `members_account`.`Amount`             AS `amount`,
  `agentfullname`.`An`                   AS `AgentName`,
  `aofullname`.`An`                      AS `AOname`,
  `planname`.`Plan_name`                 AS `plan_name`,
  `bd`.`Branch_Name`                     AS `Branch_name`,
  `packages`.`Plan_id`                   AS `Plan_id`,
  `packages`.Amount                      AS `org_amount`

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
WHERE `members_account`.Member_Code = '$Member_Code'

    ") or die(mysqli_error());
    echo "<script>console.log( '>Loading membership_form...' + new Date().toLocaleString() );</script>";

    $rr = mysqli_fetch_array($res_membership_form,MYSQLI_ASSOC);    
    
        $Member_Code=$rr['Member_Code'];
        $ddFname=$rr['Fname'];
        $ddMname=$rr['Mname'];
        $ddLname=$rr['Lname'];
        $ddFullname=$rr['Fullname'];
        $ddNname=$rr['Nname'];
        $ddSex=$rr['Sex'];
        $ddcStatus=$rr['Status'];
        $ddStreet=$rr['Address'];
        $ddIDno=$rr['IDno'];
        $ddBdate=$rr['Bdate'];
        $ddAge=$rr['Age'];
        $ddBplace=$rr['Bplace'];
        $ddOccupation=$rr['Occupation'];
        $ddreligion=$rr['religion'];
        $ddpname=$rr['pname'];
        $ddpage=$rr['page'];
        $ddprelation=$rr['prelation'];
        $ddpcontactno=$rr['pcontactno'];
        $ddcstreet=$rr['CollectionAddress'];
        $ddmcontactno=$rr['mcontactno'];
        $ddbname=$rr['bname'];
        $ddbbdate=$rr['bbdate'];
        $ddbage=$rr['bage'];
        $ddbrelation=$rr['brelation'];
        $ddbstatus=$rr['bstatus'];
        $ddbcontactno=$rr['bcontactno'];
        $dddname1=$rr['dname1'];
        $dddbdate1=$rr['dbdate1'];
        $dddage1=$rr['dage1'];
        $dddrelation1=$rr['drelation1'];
        $dddstatus1=$rr['dstatus1'];
        $dddname2=$rr['dname2'];
        $dddbdate2=$rr['dbdate2'];
        $dddage2=$rr['dage2'];
        $dddrelation2=$rr['drelation2'];
        $dddstatus2=$rr['dstatus2'];
        $dddname3=$rr['dname3'];
        $dddbdate3=$rr['dbdate3'];
        $dddage3=$rr['dage3'];
        $dddrelation3=$rr['drelation3'];
        $dddstatus3=$rr['dstatus3'];
        $dddname4=$rr['dname4'];
        $dddbdate4=$rr['dbdate4'];
        $dddage4=$rr['dage4'];
        $dddrelation4=$rr['drelation4'];
        $dddstatus4=$rr['dstatus4'];
        $ddplan_code=$rr['plan_code'];
        $ddno_of_units=$rr['no_of_units'];
        $ddagent=$rr['agent'];
        $ddinsurance_type=$rr['insurance_type'];
        $dddate_of_membership=$rr['date_of_membership'];
        $ddcurrent_term=$rr['current_term'];
        $ddaccount_status=$rr['account_status'];
        $ddremarks=$rr['remarks'];
        $ddAO=$rr['AO'];
        $ddBM=$rr['branch_manager'];
        $ddPRdate=$rr['PRdate'];
        $ddPRno=$rr['PRno'];
        $ddORdate=$rr['ORdate'];
        $ddORno=$rr['ORno'];
        $ddamount=$rr['amount'];
        $ddAgentName=$rr['AgentName'];
        $ddAOname=$rr['AOname'];
        $ddplan_name=$rr['plan_name'];
        $ddBranch_name=$rr['Branch_name'];
        $ddorg_amount=$rr['org_amount'];

    
}

        
?>

            <div class="content">
               <form id=cliregistrationformID >  
                <input type="hidden" id="uniqid" name="uniqid" value="<?=$uniqid?>" />
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 class="page-header">Member's Account Detail</h3>
                                </div>
                                <div class="col-lg-4">
                                   <BR><BR>
                                   
                                   <span class=" pull-right">
                                   <a href="javascript:history.back()" class="btn btn-danger btn-md" ><i class="glyphicon glyphicon-remove" ></i> CANCEL</a>
                                   <!--button class="btn btn-success btn-md" id=cliregistrationform_submit name="cliregistrationform_submit"><i class="fa fa-save" ></i> SAVE</button>
                                   </span-->
                                    
                                </div>
 
                            </div>

                                <div class="card-content table-responsive">


                                <div class="panel panel-default">
                                  <div class="panel-heading">MEMBER'S INFORMATION </div>
                                  <div class="panel-body">

                                        <div class="row">

                                            <!-- Line 1 -->
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Surname <font color="red">*</font></label>
                                                    <input type="text" class="form-control text-uppercase" id=aasurname value="<?=$ddLname ?>" <?=$user_mode?> required>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">First Name <font color="red">*</font></label>
                                                    <input type="text" class="form-control text-uppercase" id=aafirstname  value="<?=$ddFname ?>"  <?=$user_mode?> required>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Middle Name <font color="red">*</font></label>
                                                    <input type="text" class="form-control text-uppercase" id=aamiddlename  value="<?=$ddMname ?>"  <?=$user_mode?> required>
                                                </div>
                                            </div>

                                            <?php
                                            $selMale = "";
                                            $selFemale = "";
                                            if ($ddSex == "Male") $selMale = " selected ";
                                            if ($ddSex == "Female") $selFemale = " selected ";
                                            ?>

                                            <div class="col-sm-1">
                                                <div class="form-group label-floating" >
                                                    <label class="control-label">Sex <font color="red">*</font></label>
                                                    <select class="form-control" id=aasex  <?=$user_mode?> required>
                                                      <option value="">Select</option>
                                                      <option value="Male" <?=$selMale ?>>Male</option>
                                                      <option value="Female" <?=$selFemale ?>>Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php
                                            $selSingle = "";
                                            $selMarried = "";
                                            $selWidow = "";

                                            if ($ddcStatus == "Single") $selSingle = " selected ";
                                            if ($ddcStatus == "Married") $selMarried = " selected ";
                                            if ($ddcStatus == "Widow") $selWidow = " selected ";
                                            ?>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status <font color="red">*</font></label>
                                                    <select class="form-control" id=aacivilstatus  <?=$user_mode?> required>
                                                      <option value="">Select</option>
                                                      <option value="Single" <?=$selSingle ?>>Single</option>
                                                      <option value="Married" <?=$selMarried ?>>Married</option>
                                                      <option value="Widow" <?=$selWidow ?>>Widow</option>
                                                    </select>

                                                </div>
                                            </div>


                                        </div>

                                        <!-- Line 2 -->
                                        <div class="row">
                                            
                                            <div class="col-sm-9">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Address </label>
                                                    <input type="text" class="form-control text-uppercase" id=aapurok value="<?=$ddStreet ?>"  <?=$user_mode?> >
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Any Valid ID no. </label>
                                                    <input type="text" class="form-control text-uppercase" id=aavalidid value="<?=$ddIDno ?>"  <?=$user_mode?> >
                                                </div>
                                            </div>   

                                        </div>

                                         <!-- Line 3 -->
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating" >
                                                    <label class="control-label">Birth Date <font color="red">*</font></label>
                                                    <input type="date" class="form-control" id=aabirthdate value="<?=($ddBdate==''?'1900-01-01':$ddBdate) ?>"  <?=$user_mode?> required>
                                                </div>
                                            </div>

                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control" id=aaage value="<?=$ddAge ?>"  <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Place</label>
                                                    <input type="text" class="form-control text-uppercase"  id=aabithplace value="<?=$ddBplace ?>"  <?=$user_mode?> >
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Occupation </label>
                                                    <input type="text" class="form-control text-uppercase" id=aaoccupation value="<?=$ddOccupation ?>"  <?=$user_mode?> >
                                                </div>
                                            </div>                                
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Religion </label>
                                                    <input type="text" class="form-control text-uppercase" id=aareligion value="<?=$ddreligion ?>"  <?=$user_mode?> >
                                                </div>
                                            </div>   


                                            

                                        </div>

                                  </div>
                                </div>

                                


                                <div class="panel panel-default">
                                  <div class="panel-heading">PAYOR'S INFORMATION</div>
                                  <div class="panel-body">
<div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group label-floating">
                                                <label class="control-label">NAME </label>
                                                <input type="text" class="form-control text-uppercase" id=aapayorname value="<?=$ddpname ?>"  <?=$user_mode?>>
                                            </div>
                                        </div>   
                                        <div class="col-sm-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">AGE </label>
                                                <input type="number" class="form-control text-uppercase" id=aapayorage value="<?=$ddpage ?>"  <?=$user_mode?>>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">RELATION </label>
                                                <input type="text" class="form-control text-uppercase" id=aapayorrelation value="<?=$ddprelation ?>"  <?=$user_mode?> >
                                            </div>
                                        </div>   
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CONTACT NO. </label>
                                                <input type="number" class="form-control text-uppercase" id=aapayorcontactno value="<?=$ddpcontactno ?>"  <?=$user_mode?> >
                                            </div>
                                        </div>   
    
</div>

<div class="row">

                                       <div class="col-sm-9">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Address </label>
                                                <input type="text" class="form-control text-uppercase" id=aapayorpurok  value="<?=$ddcstreet ?>" <?=$user_mode?> >
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Member's Contact No. </label>
                                                <input type="number" class="form-control text-uppercase" id=aamembercontactno  value="<?=$ddmcontactno ?>" <?=$user_mode?> >
                                            </div>
                                        </div>  
    
</div>








                                  </div>
                                </div>


                       <div class="panel panel-default">
                                  <div class="panel-heading">BENEFICIARY</div>
                                  <div class="panel-body">
        

                                       <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Name <font color="red">*</font></label>
                                                <input type="text" class="form-control text-uppercase" id=aabenename  value="<?=$ddbname ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>


                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Birth Date <font color="red">*</font></label>
                                                <input type="date" class="form-control"  id=aabenebirthdate  value="<?=($ddbbdate==''?'1900-01-01':$ddbbdate) ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Age</label>
                                                <input type="text" class="form-control"  id=aabeneage value="<?=$ddbage ?>" <?=$user_mode?> required disabled>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Relation <font color="red">*</font></label>
                                                <input type="text" class="form-control text-uppercase"  id=aabenerelation value="<?=$ddbrelation ?>" <?=$user_mode?> required>
                                            </div>
                                        </div>
                                        <?php
                                        $selbSingle = "";
                                        $selbMarried = "";
                                        $selbWidow = "";

                                        if ($ddbstatus == "Single") $selbSingle = " selected ";
                                        if ($ddbstatus == "Married") $selbMarried = " selected ";
                                        if ($ddbstatus == "Widow") $selbWidow = " selected ";
                                        ?>                                        
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Civil Status <font color="red">*</font></label>
                                                <select class="form-control"  id=aabenecivilstatus <?=$user_mode?> required>
                                                   <option value="">Select</option>
                                                  <option value="Single" <?=$selbSingle ?>>Single</option>
                                                  <option value="Married" <?=$selbMarried ?>>Married</option>
                                                  <option value="Widow" <?=$selbWidow ?>>Widow</option>
                                               </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contact No. </label>
                                                <input type="number" class="form-control text-uppercase"  id=aabenecontactno  value="<?=$ddbcontactno ?>" <?=$user_mode?> >
                                            </div>
                                        </div>  


                                  </div>



                                 <div class="panel-footer">DEPENDENTS (OPTIONAL)</div>
                                    <div class="panel-body">

                                            

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control text-uppercase" id=aadepname1  value="<?=$dddname1 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate1  value="<?=($dddbdate1==''?'1900-01-01':$dddbdate1) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage1  value="<?=$dddage1 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control text-uppercase"  id=aadeprelationship1  value="<?=$dddrelation1 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle1 = "";
                                        $seldMarried1 = "";
                                        $seldWidow1 = "";

                                        if ($dddstatus1 == "Single") $seldSingle1 = " selected ";
                                        if ($dddstatus1 == "Married") $seldMarried1 = " selected ";
                                        if ($dddstatus1 == "Widow") $seldWidow1 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus1 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle1 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried1 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow1 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div>                                


                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control text-uppercase" id=aadepname2  value="<?=$dddname2 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate2  value="<?=($dddbdate2==''?'1900-01-01':$dddbdate2) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage2  value="<?=$dddage2 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control text-uppercase"  id=aadeprelationship2  value="<?=$dddrelation2 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle2 = "";
                                        $seldMarried2 = "";
                                        $seldWidow2 = "";

                                        if ($dddstatus2 == "Single") $seldSingle2 = " selected ";
                                        if ($dddstatus2 == "Married") $seldMarried2 = " selected ";
                                        if ($dddstatus2 == "Widow") $seldWidow2 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus2 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle2 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried2 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow2 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div> 

                                                                 


                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control text-uppercase" id=aadepname3  value="<?=$dddname3 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate3  value="<?=($dddbdate3==''?'1900-01-01':$dddbdate3) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage3  value="<?=$dddage3 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control text-uppercase"  id=aadeprelationship3  value="<?=$dddrelation3 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle3 = "";
                                        $seldMarried3 = "";
                                        $seldWidow3 = "";

                                        if ($dddstatus3 == "Single") $seldSingle3 = " selected ";
                                        if ($dddstatus3 == "Married") $seldMarried3 = " selected ";
                                        if ($dddstatus3 == "Widow") $seldWidow3 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus3 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle3 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried3 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow3 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div>    

                                                                    
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" class="form-control text-uppercase" id=aadepname4  value="<?=$dddname4 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Birth Date</label>
                                                    <input type="date" class="form-control" id=aadepbirthdate4  value="<?=($dddbdate4==''?'1900-01-01':$dddbdate4) ?>" <?=$user_mode?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Age</label>
                                                    <input type="text" class="form-control"  id=aadepage4  value="<?=$dddage4 ?>" <?=$user_mode?> disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Relation</label>
                                                    <input type="text" class="form-control text-uppercase"  id=aadeprelationship4  value="<?=$dddrelation4 ?>" <?=$user_mode?>>
                                                </div>
                                            </div>

                                        <?php
                                        $seldSingle4 = "";
                                        $seldMarried4 = "";
                                        $seldWidow4 = "";

                                        if ($dddstatus4 == "Single") $seldSingle4 = " selected ";
                                        if ($dddstatus4 == "Married") $seldMarried4 = " selected ";
                                        if ($dddstatus4 == "Widow") $seldWidow4 = " selected ";
                                        ?> 

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Civil Status</label>
                                                    <select class="form-control"  id=aadepcivilstatus4 <?=$user_mode?>>
                                                        <option value="">Select</option>
                                                        <option value="Single" <?=$seldSingle4 ?>>Single</option>
                                                        <option value="Married" <?=$seldMarried4 ?>>Married</option>
                                                        <option value="Widow" <?=$seldWidow4 ?>>Widow</option>
                                                     </select>
                                                </div>
                                            </div> 
                                     

                                    </div>  

                                </div>


                                    <div class="panel panel-default">
                                      <div class="panel-heading">ACCOUNT DETAIL</div>
                                      <div class="panel-body">


                                        <div class="row" id=row1> 
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Member's Code</label>
                               
                                                    <input type="hidden" class="form-control text-uppercase" id=aamembercode  value="<?=$Member_Code ?>">
                               
                                                    <input type="text" class="form-control text-uppercase" id=aamembercode2  value="<?=$Member_Code ?>" disabled>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Plan Type <font color="red">*</font></label>
                                                    <select class="form-control" id=aaplantype <?=$user_mode?> required>
                                                      <option value="">None</option>
                                                    <?php
                                                    
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
                                             <div class="col-sm-1">
                                                <div class="form-group label-floating">
                                                    <label class="control-label" >Unit(s) <font color="red">*</font></label>
                                                    <input type="text" class="form-control" id=aaunits  value="<?=$ddno_of_units ?>" <?=$user_mode?> required numberonly>
                                                </div>
                                            </div>                                           
                                            <div class="col-sm-4">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Branch <font color="red">*</font></label>
                                                    <select class="form-control" id=aabranchmanager <?=$user_mode?> required>
                                                      <option value="">None</option>
                                                    <?php
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





                                        </div> <!-- row1 -->
                                        <div class="row" id=row2>


                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">AO <font color="red">*</font></label>
                                                    <select class="form-control" id=aaao <?=$user_mode?> required>
                                                      
                                                     <?php
                                                     
                                                        while ($r=mysqli_fetch_array($res_ao,MYSQLI_ASSOC)) { 
                                                            $value = $r["AgentID"];
                                                            $code = $r["AGENT_CODE"];
                                                            $name = $r["AGENT_NAME"];
                                                            $selAO="";
                                                            if ($ddAO==$code) $selAO = "selected";
                                                            echo "<option value=\"$value\" $selAO>$code</option>";
                                                        }
                                                     mysqli_free_result($res_ao);
                                                     
                                                    ?>     

                                                    </select>
                                                </div>
                                            </div>  
                                            
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Agent <font color="red">*</font></label>
                                                    <select class="form-control" id=aaagent <?=$user_mode?> required>
                                                      <option value="">NONE</option>
                                                    <?php
                                                    
                                                        while ($r=mysqli_fetch_array($res_agent,MYSQLI_ASSOC)) { 
                                                            $value = $r["AgentID"];
                                                            $code = $r["AGENT_CODE"];
                                                            $name = $r["AGENT_NAME"];
                                                            $selAgent="";
                                                            if ($ddagent==$code) $selAgent = "selected";
                                                            echo "<option value=\"$value\" $selAgent>$code</option>";
                                                        }
                                                     mysqli_free_result($res_agent);
                                                    
                                                    ?>                                                      
                                                    </select>
                                                </div>
                                            </div>  

                                            <div class="col-sm-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Ins. Type <font color="red">*</font></label>
                                                    <select class="form-control" id=aainsurance <?=$user_mode?> required>
                                                    <option value="">NONE</option>
                                                    <?php
                                                        while ($r=mysqli_fetch_array($res_insurace,MYSQLI_ASSOC)) { 
                                                            $value = $r["INS_CODE"];
                                                            $name = $r["INS_NAME"];
                                                            $selIns = "";
                                                            if ($value == $ddinsurance_type) $selIns = "selected";
                                                            echo "<option value=\"$value\" $selIns>$name</option>";
                                                        }
                                                        mysqli_free_result($res_insurace);
                                                    ?>                                                   
                                                    </select>
                                                </div>
                                            </div>  

                                             <div class="col-sm-3">
                                                <div class="form-group label-floating" >
                                                    <label class="control-label">Applied Date <font color="red">*</font></label>
                                                    <input type="date" class="form-control" id=aamembershipdate   value="<?=($dddate_of_membership==''?date('Y-m-d'):$dddate_of_membership) ?>" <?=$user_mode?> required>
                                                </div>
                                            </div>                                          

  
                                        </div> <!-- row2 -->

                                         <div class="panel panel-default">
                                          <div class="panel-heading">
                                              PAYMENTS
                                              <div class="pull-right">


                                                  <!--button type="button" class="btn btn-success btn-xs" aria-label="ADD Receipt" id=new_receipt>
                                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Receipt
                                                  </button-->


                                              </div>




                                          </div>
                                          <div class="panel-body">
                                          
                                          <div class="row " id=row3>
      

                                              <div class="col-sm-2">
                                                  <div class="form-group label-floating">
                                                      <label class="control-label">O.R. Date <font color="red">*</font></label>
                                                      <input type="date" class="form-control"  id=aaordate   value="<?=($ddORdate==''?date('Y-m-d'):$ddORdate) ?>" <?=$user_mode?> required>
                                                  </div>
                                              </div>
                                               <div class="col-sm-3">
                                                  <div class="form-group label-floating">
                                                      <label class="control-label">O.R. # <font color="red">*</font>  </label>
                                                      <font size=1>Use forward slash (/) as O.R. number separator</font> 
                                                      <input type="text" class="form-control" onkeypress="return isNumberKey(event)" id=aaornumber  value="<?=$ddORno ?>" <?=$user_mode?> required>
                                                  </div>
                                              </div>  

                                              <div class="col-sm-2">
                                                  <div class="form-group label-floating">
                                                      <label class="control-label">Mo. Payable <font color="red">*</font></label>
                                                      <input type="number" class="form-control" disabled=true id=aaamount  value="<?=$ddamount ?>" <?=$user_mode?> required numberonly>
                                                      <input type="hidden" class="form-control" id=aaamountorg  value="<?=$ddorg_amount?>" readonly>
                                                  </div>
                                              </div>  

                                               <div class="col-sm-3">
                                                  <div class="form-group label-floating">
                                                      <label class="control-label">Coverage <font color="red">*</font></label>
                                                      <div class="input-group">
                                                        <span class="input-group-addon"><input type=checkbox  id=chkput> PUT</span>
                                                        <select class="form-control" class="" disabled=true id=selput>
                                                          <option value="1">Current Period</option>

                                                        </select>
                                                      </div>
                                                  </div>
                                              </div>  

                                              <div class="col-sm-2">
                                                  <div class="form-group label-floating">
                                                      <label class="control-label">Total Amount</label>
                                                      <input type="number" class="form-control" disabled=true id=aatotalamount  value="0" <?=$user_mode?> required numberonly>
                                                  </div>
                                              </div>  





                                          </div> <!-- row3 -->
                                          <div id=new_receipt_container></div>
                      

                                          <div class="row" id="plastic_sleeves_row"> 
                                              <?php
                                                  $ps_checked = "";
                                                  $ps_container_class = "hidden";
                                                  $ps_amount_value = "0";
                                                  $ps_ordate_value = "";
                                                  $ps_orno_value = "";

                                                  if ($ps_amount > 0) {
                                                      $ps_checked = "checked";
                                                      $ps_container_class = "";

                                                      $ps_amount_value = $ps_amount;
                                                      $ps_ordate_value = $ps_ordate;
                                                      $ps_orno_value = $ps_orno;
                                                  }

                                              ?>

                                                  <div class="col-sm-12 bg-info">
                                                      <div class="form-group label-floating  ">
                                                          <label class="control-label"><input type="checkbox" id="chk_add_plastic_sleeves" <?=$ps_checked?> > + Plastic Sleeves Fee (P100)</label>
                                                      </div>
                                                  </div>
                                              </div>


                                              <div class="row <?=$ps_container_class?>" id="plastic_sleeves_container"> 
                                                  <div class="col-sm-4 bg-info ">
                                                      <div class="form-group label-floating">
                                                          <label class="control-label">OR Date</label>
                                                          <input type="date" class="form-control text-uppercase" id=ps_ordate  value="<?=$ps_ordate_value?>" >
                                                      </div>

                                                  </div>
                                                  <div class="col-sm-4 bg-info">
                                                      <div class="form-group label-floating">
                                                          <label class="control-label">OR#</label>
                                                          <input type="NUMBER" class="form-control text-uppercase" id=ps_orno  value="<?=$ps_orno_value?>" >
                                                      </div>
                                                  </div>
                                                  <div class="col-sm-4 bg-info">
                                                      <div class="form-group label-floating">
                                                          <label class="control-label">AMOUNT</label>
                                                          <input type="text" class="form-control text-uppercase" id=ps_amount  value="<?=$ps_amount_value?>" >
                                                      </div>
                                                  </div>


                                            </div> <!-- plastic_sleeves_row -->
                                          </div>
                                        </div>  
                                          

                                        <br>

                                   <span class=" pull-right">
                                   <button class="btn btn-success btn-md" id=cliregistrationform_submit name="cliregistrationform_submit"><i class="fa fa-save" ></i> SAVE</button>
                                   </span>



                                      </div> <!-- panel body -->
                                    </div>
         


                       </div>


                                </div>
                            </div>
                        </div>
      
                    </div>
                </div>
              </form>
            </div>

 <SCRIPT language=Javascript>
       
       //return true if the entered key within ('0~9', 'space', '/' ) 
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          
          //allow only one slashes
          var key =  String.fromCharCode(evt.keyCode);
          var value = document.getElementById('aaornumber').value;
          if (value.indexOf('/') > -1 && key=="/"){
            return false;
          }

          //dont allw slash in 1st char
          if (value=="" && key =="/") return false;

          //allow number of forward slash
          if ((charCode>=47 && charCode <=57) || charCode==32 ) {
            return true;
          }else{
            return false;
          }
       }
      
</SCRIPT>

<script type="text/javascript">
  
function paymentCoverage_load(){
    $("#selput").html("");

    var options = "<option value=1>Current Period</option>";
    var doi_data = $("#aamembershipdate").val();
    var arr_doi = doi_data.split('-');
    
    var doi_year = arr_doi[0];
    var doi_month = arr_doi[1]-1;
    var doi_day = 15;
 
  

  for (var i = 0; i < 36; i++) { 
      var doi = new Date(doi_year, doi_month, doi_day);
      doi.setMonth(doi_month+(i+1));
      var put =  formattedDate(doi);
      options = options + "<option value="+(i+2)+">"+put+"</option>";
  }
     $("#selput").html(options);
}


function formattedDate(d = new Date) {
  const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

  let month = String(d.getMonth() + 1);
  let day = String(d.getDate());
  const year = String(d.getFullYear());

  if (month.length < 2) month = '0' + month;
  if (day.length < 2) day = '0' + day;

  return monthNames[month-1]+` ${year}`;
}

</script>



<script>
function totals_update() {
    var aaamount = $("#aaamount").val();
    var put_index  = $("#selput").val();
    var total_amount = aaamount * put_index;

    $("#aatotalamount").val(total_amount);
}

$("#chkput").on("change",function(e){
    var id = parseInt($(this).val(), 10);
          if($(this).is(":checked")) {
            $('#selput').prop('disabled', false);
            $('#selput').val(2);
            $('#aamembershipdate').prop("disabled",true);
            $('#aaordate').prop("disabled",true);
            paymentCoverage_load();  
          }else{
            $('#selput').prop('disabled', true);   
            $('#selput').val(1);
            $('#aamembershipdate').prop("disabled",false);
            $('#aaordate').prop("disabled",false);
          }
            totals_update();    
});

$("#aaornumber").on("change", function(e){
    var Member_Code = $('#aamembercode').val();
    var value = $(this).val();
    if (value != '' && Member_Code==''){
        $.ajax({  
            type: 'GET',
            url: './proc/getvalue2.php', 
            data: { 
                where:"orno = '"+value+"' OR orno LIKE '"+value+"/%' OR orno LIKE '%/"+value+"'",
                table:'installment_ledger',
                field:'count(*)'
            },
            success: function(response) {
                //alert(response);
                var strarray=response.split('|');
                if (strarray[0]!='0' || strarray[0]>0){
                  alert('The OR number you entered already exists in the database.');
                  $('#cliregistrationform_submit').prop('disabled',true);                                    
                }else{
                  $('#cliregistrationform_submit').prop('disabled',false);
                }
            }
        });

      }

});

$("#selput").on("change",function(e){
            totals_update();    
});

$('#new_receipt').on('click',function(e){
  e.preventDefault();
  if(confirm('Are you sure you want to add receipt?')){

     var row_htm =    " <div class=\"row \" id=row_added> "
                    + " <div class=\"col-sm-3\"> "
                    + "  <div class=\"form-group label-floating\"> "
                    + "  <input type=\"date\" class=\"form-control\" id=aaordate value=\"1900-01-01\" <?=$user_mode?> required> "
                    + "  </div> "
                    + "  </div> "
                    + "  <div class=\"col-sm-3\"> "
                    + "  <div class=\"form-group label-floating\"> "
                    + "  <input type=\"number\" class=\"form-control\" id=aaornumber value=\"0\" <?=$user_mode?> required numberonly> "
                    + "  </div> "
                    + "  </div>  "
                    + "  <div class=\"col-sm-3\"> "
                    + "  <div class=\"form-group label-floating\"> "
                    + "  <input type=\"number\" class=\"form-control\" id=aaamount value=\"\" <?=$user_mode?> required numberonly> "
                    + "  <input type=\"hidden\" class=\"form-control\" id=aaamountorg value=\"\"> "
                    + "  </div> "
                    + "  </div>  "
                    + "  <div class=\"col align-self-center\"> "
                    + "  <font size=\"4\" face=\"verdana\" color=\"green\">&nbsp;</font> "
                    + "  <button type=\"button\" id=btn_remove_payment_row class=\"btn btn-danger btn-xs\" aria-label=\"Left Align\"> "
                    + "  <span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> "
                    + "  </button> "
                    + "  </div>  "
                    + "  </div> <!-- row3 -->";

    //alert(row_htm);

    $('#new_receipt_container').append(row_htm);


  }
});

$('#btn_remove_payment_row').on('click',function(e){
  e.preventDefault();
    //var row = $(this).closest('');




});

$('#aabranchmanager').on('change',function(e){    
    var Branch_ID = $(this).val();
    if (Branch_ID != '' && Branch_ID > 0){

        $.ajax({  
            type: 'GET',
            url: './proc/getComboData.php', 
            data: { 
                tableName: "v_branchagents",
                valueMember:  "AgentID",
                displayMember:  "Initials",
                condition: "Branch_ID = " + Branch_ID,
            },
            success: function(response) {
                //prompt('res: ',response);
                console.log(response);
                 $('#aaagent').html(response);
                 $('#aaao').html(response);

            }
        });
    }
});

$('#aaunits').on('change',function(e){
    
    var unit = $(this).val();

    if (unit != '' && unit > 0){
        $('#aaamount').val($('#aaamountorg').val()*unit);
        totals_update();
    }
});


$('#aaplantype').on('change',function(e){
    $('#aaunits').val(1);
    var Plan_id = $(this).val();

    if (Plan_id != ''){
        $.ajax({  
            type: 'GET',
            url: './proc/getvalue.php', 
            data: { 
                idvalue:Plan_id,
                idname:'Plan_ID',
                table:'packages',
                field:'Amount'
            },
            success: function(response) {
                //alert(response);
                var strarray=response.split('|');
                $('#aaamount').val(strarray[0]);
                $('#aaamountorg').val(strarray[0]);
                totals_update();

            }
        });
    }else{
        $('#aaamount').val('');   
    }
});


//auto age computation
$('#aabirthdate').on('change',function(e){
    $('#aaage').val(getAge($(this).val()));
});
$('#aabenebirthdate').on('change',function(e){
    $('#aabeneage').val(getAge($(this).val()));
});
$('#aadepbirthdate1').on('change',function(e){
    $('#aadepage1').val(getAge($(this).val()));
});
$('#aadepbirthdate2').on('change',function(e){
    $('#aadepage2').val(getAge($(this).val()));
});
$('#aadepbirthdate3').on('change',function(e){
    $('#aadepage3').val(getAge($(this).val()));
});
$('#aadepbirthdate4').on('change',function(e){
    $('#aadepage4').val(getAge($(this).val()));
});


$('#aaordate').on('change',function(e){
    $('#aamembershipdate').val($(this).val());
});



function getAge(dateString) 
{
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
    {
        age--;
    }
    return age;
}

$('#chk_add_plastic_sleeves').on('change', function(e){
    e.preventDefault();
     if($(this).is(":checked")) {

        $( "#plastic_sleeves_container" ).removeClass('hidden');
        $( "#plastic_sleeves_container" ).hide();

        $( "#plastic_sleeves_container" ).show( "fast", function() {
          $('#ps_orno').val('');
          $('#ps_ordate').val($('#aaordate').val());
          $('#ps_amount').val(100);
          $('#ps_orno').focus();
        });

     }else{
        $('#plastic_sleeves_container').slideUp("fast",function(){
          $('#ps_orno').val('');
          $('#ps_ordate').val('');
          $('#ps_amount').val('');          
        });
     }


});


$('#cliregistrationform_submit').on('click', function(e) {
    e.preventDefault();
    $("#cliregistrationform_submit").attr("disabled", true);
    //validate inputs



    var error_count = 0;

    //validation of required inputbox
    $('#cliregistrationformID input[type="text"]').each(function(){
        //if (this.value.match(/\D/)) // regular expression for numbers only.
            if (this.hasAttribute("required")){
              //  alert($(this).val());
                if ($(this).val().trim() == '') {
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error"); 
                }

            } 
    });

    //valdation of required  dropdown box
    $('#cliregistrationformID select').each(function(){
         if (this.hasAttribute("required")){
            if ($(this).val().trim()=='' || $(this).val().trim()=='Select' ){
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error");    
            }
         }
    });

    //validation of requried date
    $('#cliregistrationformID input[type="date"]').each(function(){
        //if (this.value.match(/\D/)) // regular expression for numbers only.
            if (this.hasAttribute("required")){

                if ($(this).val().trim()=='' || ($(this).val().trim()=='1900-01-01')){
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error");                       
                }

            } 
    });

    //check if age fields are greater that 140 years limit
    if ($('#aaage').val()> 140) {
         error_count+=1;
        $('#aaage').closest("div").addClass("has-error");
        $('#aabirthdate').closest("div").addClass("has-error");
        $('#aabirthdate').focus();
    }else{
         $('#aaage').closest("div").removeClass("has-error");
         $('#aabirthdate').closest("div").removeClass("has-error");
    }

    if ($('#aapayorage').val()> 140) {
         error_count+=1;
        $('#aapayorage').closest("div").addClass("has-error");
        $('#aapayorage').focus();
    }else{
         $('#aapayorage').closest("div").removeClass("has-error");
    }

    if ($('#aabeneage').val()> 140) {
         error_count+=1;
        $('#aabeneage').closest("div").addClass("has-error");
        $('#aabenebirthdate').closest("div").addClass("has-error");
        $('#aabenebirthdate').focus();
    }else{
         $('#aabeneage').closest("div").removeClass("has-error");
         $('#aabenebirthdate').closest("div").removeClass("has-error");
    }

    if ($('#aadepage1').val()> 140) {
         error_count+=1;
        $('#aadepage1').closest("div").addClass("has-error");
        $('#aadepbirthdate1').closest("div").addClass("has-error");
        $('#aadepbirthdate1').focus();
    }else{
         $('#aadepage1').closest("div").removeClass("has-error");
         $('#aadepbirthdate1').closest("div").removeClass("has-error");
    }

    if ($('#aadepage12').val()> 140) {
         error_count+=1;
        $('#aadepage1').closest("div").addClass("has-error");
        $('#aadepbirthdate2').closest("div").addClass("has-error");
        $('#aadepbirthdate2').focus();
    }else{
         $('#aadepage2').closest("div").removeClass("has-error");
         $('#aadepbirthdate2').closest("div").removeClass("has-error");
    }

    if ($('#aadepage3').val()> 140) {
         error_count+=1;
        $('#aadepage3').closest("div").addClass("has-error");
        $('#aadepbirthdate3').closest("div").addClass("has-error");
        $('#aadepbirthdate3').focus();
    }else{
         $('#aadepage3').closest("div").removeClass("has-error");
         $('#aadepbirthdate3').closest("div").removeClass("has-error");
    }

    if ($('#aadepage4').val()> 140) {
         error_count+=1;
        $('#aadepage4').closest("div").addClass("has-error");
        $('#aadepbirthdate4').closest("div").addClass("has-error");
        $('#aadepbirthdate4').focus();
    }else{
         $('#aadepage4').closest("div").removeClass("has-error");
         $('#aadepbirthdate4').closest("div").removeClass("has-error");
    }


     if($(this).is(":checked")) {
          $('#ps_orno').val();
          $('#ps_ordate').val();
          $('#ps_amount').val(100);


          if ($('#ps_orno').val() == 0 || ($('#ps_orno').val().trim()=='')){
             error_count+=1;
             $('#ps_orno').closest("div").addClass("has-error");
             if (error_count==1) $(this).focus();
          }else{
             $('#ps_orno').closest("div").removeClass("has-error");                       
          }

          if ($('#ps_amount').val() == 0 || ($('#ps_amount').val().trim()=='')){
             error_count+=1;
             $('#ps_amount').closest("div").addClass("has-error");
             if (error_count==1) $(this).focus();
          }else{
             $('#ps_amount').closest("div").removeClass("has-error");                       
          }

          if ($('#ps_ordate').val().trim()=='' || ($('#ps_ordate').val().trim()=='1900-01-01')){
             error_count+=1;
             $('#ps_ordate').closest("div").addClass("has-error");
             if (error_count==1) $(this).focus();
          }else{
             $('#ps_ordate').closest("div").removeClass("has-error");                       
          }
     }

    //number validation
    $('#cliregistrationformID input[type="text"]').each(function(){
            //check if required and numeric value
            if (this.hasAttribute("required") && this.hasAttribute("numberonly")){
              //  alert($(this).val());
                if ($(this).val().trim() == '') {
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                  
                   if ($.isNumeric($(this).val())) {
                         $(this).closest("div").removeClass("has-error"); 
                   }else{
                         error_count+=1;
                         $(this).closest("div").addClass("has-error"); 
                        if (error_count==1) $(this).focus();
                   }
                }
            }else if(this.hasAttribute("numberonly")) {
                    //check if numeric only (not required)
                   if ($.isNumeric($(this).val())) {
                         $(this).closest("div").removeClass("has-error"); 
                   }else{
                         error_count+=1;
                         $(this).closest("div").addClass("has-error"); 
                         if (error_count==1) $(this).focus();
                   }
            } 
    });


    //prevent amount not devisible by original amount
    var aaamount = $('#aaamount').val();
    var aatotalamount = $('#aatotalamount').val();
    var aaamountorg = $('#aaamountorg').val();

/*
    if (aaamount % aaamountorg != 0 && $('#aamembercode').val()=='') {
        alert('Amount should be devisible by the selected plan monthly payment.\n\nSelected Plan Amount: '+aaamountorg );
        $('#aaamount').closest("div").removeClass("has-error"); 
        $("#cliregistrationform_submit").attr("disabled", false);
        return;
    }
*/
    var number_of_payment = $('#selput').val();

    if (error_count>0) {
        $("#cliregistrationform_submit").attr("disabled", false);        
    }

    if (error_count==0){
        //send POST here
        var userid  = $('#user_info').attr('user_id');
        var uniqid  = $('#uniqid').val();
 

        console.log('userid: '+userid);
        console.log('uniqid: '+uniqid);


        $.ajax({  
            type: 'GET',
            url: './proc/cliregistrationform_proc.php', 
            data: {
                uniqid:uniqid, 
                number_of_payment:number_of_payment,
                userid:userid,
                aamembercode:$('#aamembercode').val(),
                aafirstname :$('#aafirstname').val(),
                aamiddlename:$('#aamiddlename').val(),
                aasurname:$('#aasurname').val(),
                aasex:$('#aasex').val(),
                aacivilstatus:$('#aacivilstatus').val(),
                aapurok:$('#aapurok').val(),
                aavalidid:$('#aavalidid').val(),
                aabirthdate:$('#aabirthdate').val(),
                aaage:$('#aaage').val(),
                aabithplace:$('#aabithplace').val(),
                aaoccupation:$('#aaoccupation').val(),
                aareligion:$('#aareligion').val(),
                aapayorname:$('#aapayorname').val(),
                aapayorage:$('#aapayorage').val(),
                aapayorrelation:$('#aapayorrelation').val(),
                aapayorcontactno:$('#aapayorcontactno').val(),
                aapayorpurok:$('#aapayorpurok').val(),
                aamembercontactno:$('#aamembercontactno').val(),
                aabenename:$('#aabenename').val(),
                aabenebirthdate:$('#aabenebirthdate').val(),
                aabeneage:$('#aabeneage').val(),
                aabenerelation:$('#aabenerelation').val(),
                aabenecivilstatus:$('#aabenecivilstatus').val(),
                aabenecontactno:$('#aabenecontactno').val(),
                aadepname1:$('#aadepname1').val(),
                aadepbirthdate1:$('#aadepbirthdate1').val(),

                aadepage1:$('#aadepage1').val(),
                aadeprelationship1:$('#aadeprelationship1').val(),
                aadepcivilstatus1:$('#aadepcivilstatus1').val(),
                aadepname2:$('#aadepname2').val(),
                aadepbirthdate2:$('#aadepbirthdate2').val(),
                aadepage2:$('#aadepage2').val(),
                aadeprelationship2:$('#aadeprelationship2').val(),
                aadepcivilstatus2:$('#aadepcivilstatus2').val(),
                aadepname3:$('#aadepname3').val(),
                aadepbirthdate3:$('#aadepbirthdate3').val(),
                aadepage3:$('#aadepage3').val(),
                aadeprelationship3:$('#aadeprelationship3').val(),
                aadepcivilstatus3:$('#aadepcivilstatus3').val(),
                aadepname4:$('#aadepname4').val(),
                aadepbirthdate4:$('#aadepbirthdate4').val(),
                aadepage4:$('#aadepage4').val(),
                aadeprelationship4:$('#aadeprelationship4').val(),
                aadepcivilstatus4:$('#aadepcivilstatus4').val(),
                aaplantype:$('#aaplantype').val(),
                aaunits:$('#aaunits').val(),
                aaagent:$('#aaagent').val(),
                aainsurance:$('#aainsurance').val(),
                aamembershipdate:$('#aamembershipdate').val(),
                aaao:$('#aaao').val(),
                aabranchmanager:$('#aabranchmanager').val(),

                aaordate:$('#aaordate').val(),
                aaornumber:$('#aaornumber').val(),
                aaamount:$('#aaamount').val(),
                aatotalamount:$('#aatotalamount').val(),
                ps_orno:$('#ps_orno').val(),
                ps_ordate:$('#ps_ordate').val(),
                ps_amount:$('#ps_amount').val(),
            },
            success: function(response) {
               //prompt('res:',response);
               //return;
                if (response.indexOf("**success**") > -1){
                   alert('Success!');
                   window.location = "index.php?page=clientlist";
                  
                }else if (response.indexOf("**failed**") > -1){
                   alert('No record found');
                }
            }
        });


    }else{
            
            $("#cliregistrationform_submit").attr("disabled", false);

    }
});


</script>   
